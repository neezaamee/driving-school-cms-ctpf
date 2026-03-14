<?php session_start();
$pageTitle = "New Admission";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

use App\Models\User;
use App\Models\School;
use App\Models\Student;
use App\Models\Voucher;
use App\Models\Admission;
use App\Models\Bank;

// 1. Initialize User Context
$currentUser = User::find($_SESSION['loginUserID']);
$userSchoolID = $currentUser->idschool;
$currentSchool = School::find($userSchoolID);
$schoolName = $currentSchool->location;

// 2. AJAX Voucher Check
if (isset($_GET['check_voucher'])) {
    if (ob_get_length()) ob_clean();
    header('Content-Type: application/json');
    $voucherno = trim(CleanData($_GET['voucherno']));
    $voucher = Voucher::findByNo($voucherno);
    
    if ($voucher) {
        if ($voucher->status == 1) {
            $payment = feePaymentByVoucherID($voucher->id);
            $admission = findAdmissionByVoucherID($voucher->id);
            
            echo json_encode([
                'status' => 'paid',
                'voucherno' => $voucherno,
                'paid_date' => ($payment && isset($payment->paid_date)) ? date('d-M-Y', strtotime($payment->paid_date)) : 'N/A',
                'admission_date' => ($admission && isset($admission->admission_date)) ? date('d-M-Y', strtotime($admission->admission_date)) : 'N/A',
                'registration' => ($admission && isset($admission->registration)) ? $admission->registration : 'N/A'
            ]);
        } else {
            echo json_encode(['status' => 'unpaid']);
        }
    } else {
        echo json_encode(['status' => 'not_found']);
    }
    exit();
}

// 3. Logic: Handle Step 3 (Final Processing & Printing)
$step3Result = null;
if (isset($_POST['submit']) || isset($_POST['submit2'])) {
    if (!isset($_POST['csrf']) || !verify_csrf_token($_POST['csrf'])) {
        die("<h3 class='text-center text-danger'>Security Error: Invalid or missing CSRF token.</h3>");
    }
    
    $voucherID = CleanData($_POST['voucherid']);
    $Voucher = Voucher::find($voucherID);
    
    if ($Voucher->status == 1 && !isset($_POST['reprint'])) {
        $step3Result = ['error' => 'Voucher already paid and admission processed.'];
    } else {
        $studentID = $Voucher->idstudent;
        $courseID = $Voucher->idcourse;
        $PicknDrop = $Voucher->pickndrop;
        $studentSchoolID = $Voucher->idschool;
        $paidDate = CleanData($_POST['paiddate']);
        $bankID = CleanData($_POST['bank']);
        $admissionDate = CleanData($_POST['admissiondate']);
        
        if (isset($_POST['submit'])) {
            $Email = CleanData($_POST['email']);
            $DOB = CleanData($_POST['dob']);
            $Address = CleanData($_POST['address']);
            $Phone = CleanData($_POST['phone']);
            $Group = CleanData($_POST['time']);
            $bloodID = CleanData($_POST['blood']);
            updateStudentDetails($studentID, $Email, $DOB, $Address, $Phone, $Group, $bloodID);
        }

        mysqli_begin_transaction($con);
        try {
            $current_year = date("Y");
            $counter_sql = "SELECT total_admissions, year FROM school_counters WHERE idschool = ? FOR UPDATE";
            $counter_stmt = mysqli_prepare($con, $counter_sql);
            mysqli_stmt_bind_param($counter_stmt, "i", $studentSchoolID);
            mysqli_stmt_execute($counter_stmt);
            $counter_result = mysqli_stmt_get_result($counter_stmt);

            if (mysqli_num_rows($counter_result) > 0) {
                $counter_row = mysqli_fetch_assoc($counter_result);
                $NR = ($counter_row['year'] == $current_year) ? $counter_row['total_admissions'] + 1 : 1;
                $update_sql = "UPDATE school_counters SET total_admissions = ?, year = ? WHERE idschool = ?";
                $update_stmt = mysqli_prepare($con, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "iii", $NR, $current_year, $studentSchoolID);
                mysqli_stmt_execute($update_stmt);
            } else {
                $NR = 1;
                $insert_sql = "INSERT INTO school_counters (idschool, total_admissions, year) VALUES (?, ?, ?)";
                $insert_stmt = mysqli_prepare($con, $insert_sql);
                mysqli_stmt_bind_param($insert_stmt, "iii", $studentSchoolID, $NR, $current_year);
                mysqli_stmt_execute($insert_stmt);
            }
            $Registration = date("Y") .'-'. $studentSchoolID .'-'. "CTP" .'-'. $NR;
            mysqli_commit($con);
        } catch (Exception $e) {
            mysqli_rollback($con);
            die("Error generating registration number: " . $e->getMessage());
        }

        $feePaymentID = newFeePayment($voucherID, $studentID, $studentSchoolID, $bankID, $paidDate, $_SESSION['loginUserID']);
        $paymentID = mysqli_insert_id($con);
        newAdmission($Registration, $PicknDrop, $studentID, $courseID, $voucherID, $paymentID, $studentSchoolID, $_SESSION['loginUserID'], $admissionDate);
        updateVoucherStatusToPaid($voucherID);
        
        log_audit_event($_SESSION['loginUserID'] ?? 0, 'CREATE', 'admissions', $Registration, "New admission processed for student ID $studentID");

        $step3Result = [
            'Registration' => $Registration,
            'studentID' => $studentID,
            'paymentID' => $paymentID,
            'admissionDate' => $admissionDate,
            'paidDate' => $paidDate,
            'bankID' => $bankID,
            'Voucher' => $Voucher,
            'courseID' => $courseID
        ];
    }
}

// 4. Logic: Handle Step 2 (Voucher Processing)
$step2Voucher = null;
$step2Error = null;
if (isset($_POST['process_voucher'])) {
    if (!isset($_POST['csrf']) || !verify_csrf_token($_POST['csrf'])) {
        die("<h3 class='text-center text-danger'>Security Error: Invalid or missing CSRF token.</h3>");
    }
    $voucherNo = trim(CleanData($_POST['voucherno']));
    $step2Voucher = Voucher::findByNo($voucherNo);
    if (!$step2Voucher) {
        $step2Error = "Voucher Not Found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
    <style>
        #profiletbl td, #profiletbl th {
            padding: 10px !important;
        }
        @media print {
            .printable-section {
                padding: 10px;
            }
            @page { size: A4 portrait; margin: 5mm; }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed" <?php if(isset($_POST['submit']) || isset($_POST['submit2'])); ?>>
    <div class="wrapper">
        <?php include('topNav.php') ?>
        <?php include('sidebar.php') ?>
        
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">New Admission - <?php echo e($schoolName); ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Admission Form</h3>
                                </div>
                                <div class="card-body">
                                <?php
                                if ($step3Result) {
                                    if (isset($step3Result['error'])) {
                                        echo "<h3 class='text-center text-danger'>".e($step3Result['error'])."</h3>";
                                        echo "<div class='text-center'><a href='newAdmission.php' class='btn btn-primary'>Go Back</a></div>";
                                    } else {
                                        // Destructure result
                                        $Registration = $step3Result['Registration'];
                                        $studentID = $step3Result['studentID'];
                                        $paymentID = $step3Result['paymentID'];
                                        $admissionDate = $step3Result['admissionDate'];
                                        $paidDate = $step3Result['paidDate'];
                                        $bankID = $step3Result['bankID'];
                                        $Voucher = $step3Result['Voucher'];
                                        $courseID = $step3Result['courseID'];

                                        $Admission = Admission::findByRegistration($Registration);
                                        $Student = Student::find($studentID);
                                        
                                        $SchoolInfo = School::find($Voucher->idschool);
                                        $CityInfo = cityByID($SchoolInfo->idcity); 
                                        
                                        $photoPath = 'StudentImages/' . $Student->cnic . '.JPG';
                                        if (!file_exists($photoPath)) {
                                            $photoPath = ($Student->gender == '2') ? 'dist/img/avatar2.png' : 'dist/img/avatar5.png';
                                        }
                                        ?>
                                        <div class="printable-section">
                                            <div class="text-center mb-4">
                                                <h2 class="font-weight-bold">REGISTRATION FORM</h2>
                                                <strong style="font-size: medium">Driving School - Traffic Police Punjab</strong><br>
                                                <strong style="font-size: medium"><?php echo e($SchoolInfo->location . " " . $CityInfo->name); ?></strong>
                                            </div>

                                            <table id="profiletbl" class="table table-bordered table-sm table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th>Admission Date</th>
                                                        <td colspan="2"><?php echo date('d-M-Y', strtotime($admissionDate)); ?></td>
                                                        <th class="text-center" rowspan="5">
                                                            <img width="180px" height="180px" src="<?php echo $photoPath; ?>" class="img-thumbnail elevation-2" alt="Student Photo">
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Registration No</th>
                                                        <td colspan="2"><span class="badge badge-primary" style="font-size: 1rem;"><?php echo e($Registration); ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Voucher Number / PSID</th>
                                                        <td colspan="2"><?php echo e($Voucher->vouchernumber); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Voucher Paid Date</th>
                                                        <td colspan="2"><?php echo date('d-M-Y', strtotime($paidDate)) . " - " . Bank::find($bankID)->name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>CNIC</th>
                                                        <td colspan="2"><strong><?php echo e($Student->cnic); ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Name of Student</th>
                                                        <td colspan="3"><?php echo e(strtoupper($Student->fullname)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Guardian</th>
                                                        <td colspan="3"><?php echo e(strtoupper($Student->fathername)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>DOB / Gender</th>
                                                        <td colspan="3">
                                                            <?php echo date('d-m-Y', strtotime($Student->dob)); ?> / 
                                                            <span class="badge badge-info"><?php echo e(genderByID($Student->gender)->name); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Student Category</th>
                                                        <td><span class="badge badge-secondary"><?php echo e(studentCategoryByID($Voucher->idstudentcategory)->name); ?></span></td>
                                                        <th>Blood Group</th>
                                                        <td><span class="badge badge-danger"><?php echo e(bloodByID($Student->idblood)->name ?: 'N/A'); ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone</th>
                                                        <td><?php echo e($Student->phone); ?></td>
                                                        <th>Email</th>
                                                        <td><?php echo e($Student->email ?: '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Course Details</th>
                                                        <td><strong><?php echo e(courseByID($courseID)->coursename); ?></strong> <small>(<?php echo e(courseByID($courseID)->duration); ?>)</small></td>
                                                        <th>Time Group</th>
                                                        <td><?php echo e($Student->timegroup); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fee Concession</th>
                                                        <td>Rs. <?php echo number_format($Voucher->discount ?? 0); ?></td>
                                                        <th>Grand Total Fee</th>
                                                        <td>Rs. <?php echo number_format($Voucher->grand_total); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td colspan="3"><?php echo e($Student->address); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Remarks</th>
                                                        <td colspan="3"><?php echo e($Voucher->remarks ?: '-'); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="row mt-5 pt-4">
                                                <div class="col-4 text-center border-top">
                                                    <p class="mt-2 font-weight-bold">Signature Applicant</p>
                                                </div>
                                                <div class="col-4"></div>
                                                <div class="col-4 text-center border-top">
                                                    <p class="mt-2 font-weight-bold">Signature Admin</p>
                                                </div>
                                            </div>

                                            <div style="border-top: 3px dashed #000; margin: 50px 0;"></div>

                                            <!-- Student Card Section -->
                                            <div class="student-card-wrapper d-flex justify-content-center">
                                                <div class="card card-outline card-danger" style="width: 100%; max-width: 600px;">
                                                    <div class="card-header text-center">
                                                        <h4 class="m-0">STUDENT CARD</h4>
                                                        <small>Car Driving School <?php echo e($SchoolInfo->location . " " . $CityInfo->name); ?></small>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="row no-gutters">
                                                            <div class="col-8 p-3">
                                                                <table class="table table-sm table-borderless m-0">
                                                                    <tr>
                                                                        <th style="width: 40%;">Registration:</th>
                                                                        <td><?php echo e($Registration); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Student:</th>
                                                                        <td><strong><?php echo e(strtoupper($Student->fullname)); ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>CNIC:</th>
                                                                        <td><?php echo e($Student->cnic); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Course:</th>
                                                                        <td><?php echo e(courseByID($courseID)->coursename . " (" . courseByID($courseID)->duration . ")"); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Time Group:</th>
                                                                        <td><?php echo e($Student->timegroup); ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-4 text-center p-3 align-self-center">
                                                                <img width="120px" height="120px" src="<?php echo $photoPath; ?>" class="img-circle elevation-2 shadow-sm" alt="Student Card Photo">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-center mt-4 mb-4">
                                                <button class="btn btn-success d-print-none" onclick="window.print()">
                                                    <i class="fas fa-print"></i> Print Form
                                                </button>
                                                <a href="newAdmission.php" class="btn btn-secondary d-print-none">
                                                    <i class="fas fa-arrow-left"></i> Back
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } elseif ($step2Voucher || $step2Error) {
                                    if ($step2Error) {
                                        echo "<h3 class='text-center text-danger'>".e($step2Error)."</h3>";
                                        echo "<div class='text-center'><a href='newAdmission.php' class='btn btn-primary'>Go Back</a></div>";
                                    } else {
                                        $Voucher = $step2Voucher;
                                        $voucherNo = $Voucher->vouchernumber;
                                        
                                        if ($Voucher->status == 1) {
                                            $payment = feePaymentByVoucherID($Voucher->id);
                                            $admission = findAdmissionByVoucherID($Voucher->id);
                                            ?>
                                            <div class="alert alert-warning">
                                                <h5><i class="icon fas fa-exclamation-triangle"></i> Already Paid!</h5>
                                                This voucher (<strong><?php echo e($voucherNo); ?></strong>) has already been processed. <br>
                                                <strong>Registration No:</strong> <?php echo $admission ? e($admission->registration) : 'N/A'; ?> <br>
                                                <strong>Admission Date:</strong> <?php echo $admission ? date('d-M-Y', strtotime($admission->admission_date)) : 'N/A'; ?> <br>
                                                <strong>Paid Date:</strong> <?php echo ($payment && isset($payment->paid_date)) ? date('d-M-Y', strtotime($payment->paid_date)) : 'N/A'; ?>
                                            </div>
                                            <a href="newAdmission.php" class="btn btn-primary">Try Another Voucher</a>
                                            <?php
                                        } else {
                                            $studentID = $Voucher->idstudent;
                                            $Student = Student::find($studentID);
                                            $IsAlreadyAdmitted = findAdmissionByStudentID($studentID);
                                            ?>
                                            <form role="form" method="post" action="newAdmission.php">
                                                <input type="hidden" name="csrf" value="<?php echo generate_csrf_token(); ?>">
                                                <input type="hidden" name="voucherid" value="<?php echo e($Voucher->id); ?>">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4"><label>CNIC</label><input type="text" class="form-control" value="<?php echo e($Student->cnic); ?>" readonly></div>
                                                    <div class="form-group col-md-4"><label>Name</label><input type="text" class="form-control" value="<?php echo e($Student->fullname); ?>" readonly></div>
                                                    <div class="form-group col-md-4"><label>Father Name</label><input type="text" class="form-control" value="<?php echo e($Student->fathername); ?>" readonly></div>
                                                </div>
                                                <?php if ($IsAlreadyAdmitted) { ?>
                                                    <!-- Simplified form for existing student (only payment details) -->
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4"><label>Admission Date</label><input type="date" class="form-control" name="admissiondate" required></div>
                                                        <div class="form-group col-md-4"><label>Voucher Paid Date</label><input type="date" class="form-control" name="paiddate" required></div>
                                                        <div class="form-group col-md-4">
                                                            <label>Bank</label>
                                                            <select class="form-control" name="bank" required>
                                                                <?php
                                                                $banks = Bank::all();
                                                                foreach ($banks as $bank) {
                                                                    echo "<option value='".e($bank->id)."'>".e($bank->name)."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="submit2" class="btn btn-primary">Process Admission</button>
                                                <?php } else { ?>
                                                    <!-- Full form for fresh student (profile completion + payment) -->
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6"><label>DOB</label><input type="date" class="form-control" name="dob" required></div>
                                                        <div class="form-group col-md-6"><label>Phone</label><input type="text" class="form-control" name="phone"></div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4"><label>Email</label><input type="email" class="form-control" name="email"></div>
                                                        <div class="form-group col-md-4">
                                                            <label>Blood Group</label>
                                                            <select class="form-control" name="blood" required>
                                                                <option value="1">A+</option><option value="3">B+</option><option value="4">O+</option>
                                                                <option value="2">AB+</option><option value="5">A-</option><option value="7">B-</option>
                                                                <option value="8">O-</option><option value="6">AB-</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Time Group</label>
                                                            <select class="form-control" name="time"><option value="Morning">Morning</option><option value="Evening">Evening</option></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label>Address</label><input type="text" class="form-control" name="address" required></div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4"><label>Admission Date</label><input type="date" class="form-control" name="admissiondate" required></div>
                                                        <div class="form-group col-md-4"><label>Voucher Paid Date</label><input type="date" class="form-control" name="paiddate" required></div>
                                                        <div class="form-group col-md-4">
                                                            <label>Bank</label>
                                                            <select class="form-control" name="bank" required>
                                                                <?php
                                                                $banks = Bank::all();
                                                                foreach ($banks as $bank) {
                                                                    echo "<option value='".e($bank->id)."'>".e($bank->name)."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="submit" class="btn btn-primary">Process Admission</button>
                                                <?php } ?>
                                            </form>
                                            <?php
                                        } 
                                    }
                                } else {
                                    // STEP 1: VOUCHER ENTRY
                                    ?>
                                    <div id="voucher_status_feedback"></div>
                                    <form role="form" method="post" action="newAdmission.php" id="voucher_form">
                                        <input type="hidden" name="csrf" value="<?php echo generate_csrf_token(); ?>">
                                        <div class="form-group">
                                            <label>Enter Voucher No / PSID</label>
                                            <input type="text" class="form-control" name="voucherno" id="voucherno" placeholder="Voucher Number" required autofocus>
                                        </div>
                                        <button type="submit" name="process_voucher" id="process_btn" class="btn btn-primary">Find Voucher</button>
                                    </form>

                                    <script>
                                    $(document).ready(function() {
                                        var checkVoucher = function() {
                                            var vno = $('#voucherno').val().trim();
                                            if (vno.length >= 4) {
                                                $.ajax({
                                                    url: 'newAdmission.php',
                                                    method: 'GET',
                                                    dataType: 'json',
                                                    data: { check_voucher: 1, voucherno: vno },
                                                    success: function(response) {
                                                        if (response.status == 'paid') {
                                                            var html = `
                                                                <div class="alert alert-warning">
                                                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Already Paid!</h5>
                                                                    This voucher has already been processed. <br>
                                                                    <strong>Registration No:</strong> ${response.registration} <br>
                                                                    <strong>Admission Date:</strong> ${response.admission_date} <br>
                                                                    <strong>Paid Date:</strong> ${response.paid_date}
                                                                </div>
                                                            `;
                                                            $('#voucher_status_feedback').html(html);
                                                            $('#process_btn').attr('disabled', true);
                                                        } else {
                                                            $('#voucher_status_feedback').html('');
                                                            $('#process_btn').attr('disabled', false);
                                                        }
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error("AJAX Error: " + status + " - " + error);
                                                        console.log(xhr.responseText); // Helpful for debugging premature output
                                                    }
                                                });
                                            } else {
                                                $('#voucher_status_feedback').html('');
                                                $('#process_btn').attr('disabled', false);
                                            }
                                        };

                                        $('#voucherno').on('keyup change blur paste input', checkVoucher);
                                    });
                                    </script>
                                    <?php
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="d-print-none">
            <?php include('footer.php') ?>
        </div>
    </div>
    <?php include('footerPlugins.php') ?>
</body>
</html>
