<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;
$School = schoolByID($userSchoolID);
$schoolName = $School->location;

$success_msg = "";
$error_msg = "";
$show_receipt = false;
$Registration = "";

// Handle Stage 2: Form Submission (Processing)
if (isset($_POST['submit_enrollment'])) {
    $students_copyID = CleanData($_POST['students_copyid']);
    $Email = CleanData($_POST['email']);
    $DOB = CleanData($_POST['dob']);
    $paidDate = CleanData($_POST['paiddate']);
    $Address = CleanData($_POST['address']);
    $Phone = CleanData($_POST['phone']);
    $Group = CleanData($_POST['time']);
    $BloodID = CleanData($_POST['blood']);
    $BloodString = bloodByID($BloodID)->name;
    
    // Fetch Student and Voucher details
    $Student = studentByID($students_copyID);
    $Voucher = voucherByStudentID($students_copyID); // This gets the latest status=1 voucher
    
    if ($Voucher) {
        $voucherID = $Voucher->id;
        $voucherNo = $Voucher->vouchernumber;
        $courseID = $Student->idcourse;
        $courseName = courseByID($courseID)->coursename;
        
        $studentSchoolID = $Student->idschool;
        $GenderValue = $Student->gender;
        $admissionID = 10; // Default status/category from legacy code
        
        // Calculate Registration Number
        $sql_count = "SELECT COUNT(*) as total FROM admissions";
        $res_count = mysqli_query($con, $sql_count);
        $row_count = mysqli_fetch_assoc($res_count);
        $NR = $row_count['total'] + 1;
        $Registration = date("y") . $studentSchoolID . "CTPF" . $NR;

        // Start Transaction
        mysqli_begin_transaction($con);
        try {
            // 1. Update Student Details
            if (!updateStudentDetails($students_copyID, $Email, $DOB, $Address, $Phone, $Group, $BloodID)) {
                throw new Exception("Failed to update student details.");
            }

            // 2. Update Voucher Status
            if (!updateVoucherStatusToPaid($voucherID)) {
                throw new Exception("Failed to update voucher status.");
            }

            // 3. Record Fee Payment
            $bankID = 1; // Default bank as per legacy code
            $feePaymentID = newFeePayment($voucherID, $students_copyID, $studentSchoolID, $bankID, $paidDate, $userID);
            if (!$feePaymentID) {
                throw new Exception("Failed to record fee payment.");
            }

            // 4. Create Admission Record
            $PicknDropValue = ($Voucher->pickndrop > 0) ? "YES" : "NO";
            $admissionDate = date("Y-m-d");
            if (!newAdmission($Registration, $PicknDropValue, $students_copyID, $courseID, $voucherID, $feePaymentID, $studentSchoolID, $userID, $admissionDate)) {
                throw new Exception("Failed to create admission record.");
            }

            mysqli_commit($con);
            $success_msg = "Enrollment processed successfully!";
            $show_receipt = true;
        } catch (Exception $e) {
            mysqli_rollback($con);
            $error_msg = "Error processing enrollment: " . $e->getMessage();
        }
    } else {
        $error_msg = "Active voucher not found for this student.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            table { border: 1px solid black !important; border-collapse: collapse !important; width: 100% !important; }
            th, td { border: 1px solid black !important; padding: 8px !important; }
        }
        .print-only { display: none; }
        table.receipt-table { border: 1px solid black !important; border-collapse: collapse !important; width: 100%; }
        table.receipt-table th, table.receipt-table td { border: 1px solid black !important; padding: 10px !important; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="no-print">
            <?php include('topNav.php'); ?>
            <?php include('sidebar.php'); ?>
        </div>
        
        <div class="content-wrapper">
            <div class="content-header no-print">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Enrollment - <?php echo $schoolName; ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php if ($success_msg): ?>
                        <div class="alert alert-success no-print"><?php echo $success_msg; ?> <button onclick="window.print()" class="btn btn-sm btn-dark ml-2">Print Admission Form</button></div>
                    <?php endif; ?>
                    <?php if ($error_msg): ?>
                        <div class="alert alert-danger no-print"><?php echo $error_msg; ?></div>
                    <?php endif; ?>

                    <?php if ($show_receipt): 
                        // Fetch fresh data for receipt
                        $Student = studentByID($students_copyID);
                        $Voucher = voucherByID($voucherID);
                        $GenderText = genderByID($Student->gender)->name;
                        $courseName = courseByID($Student->idcourse)->coursename;
                    ?>
                        <!-- Admission Form / Receipt -->
                        <div class="card card-success no-print">
                            <div class="card-header"><h3 class="card-title">Admission Confirmed</h3></div>
                        </div>
                        
                        <div class="print-area">
                            <table class="receipt-table">
                                <tr id="form-heading">
                                    <th class="text-center" colspan="5" style="font-size: x-large;">Admission Form <br /><?php echo "Driving School ".$schoolName. " - City Traffic Police Faisalabad" ;?></th>
                                </tr>
                                <tr>
                                    <th>Admission Date</th><td><?php echo date("d-m-Y"); ?></td>
                                    <th>Registration No</th><td><?php echo $Registration; ?></td>
                                    <th rowspan="4" class="text-center" style="width: 20%">Photo 3x5</th>
                                </tr>
                                <tr>
                                    <th>Voucher Number</th><td><?php echo $Voucher->vouchernumber; ?></td>
                                    <th>Voucher Paid Date</th><td><?php echo $paidDate; ?></td>
                                </tr>
                                <tr>
                                    <th>Name of Student</th><td><?php echo strtoupper($Student->fullname); ?></td>
                                    <th>CNIC</th><td><?php echo $Student->cnic; ?></td>
                                </tr>
                                <tr>
                                    <th>Guardian</th><td><?php echo strtoupper($Student->fathername); ?></td>
                                    <th>Email</th><td><?php echo $Email; ?></td>
                                </tr>
                                <tr>
                                    <th>DOB</th><td><?php echo $DOB; ?></td>
                                    <th>Phone</th><td><?php echo $Phone; ?></td>
                                    <td rowspan="3" class="text-center align-middle">Candidate Sign</td>
                                </tr>
                                <tr>
                                    <th>Gender</th><td><?php echo $GenderText; ?></td>
                                    <th>Time</th><td><?php echo $Group; ?></td>
                                </tr>
                                <tr>
                                    <th>Blood Group</th><td><?php echo $BloodString; ?></td>
                                    <th>Course</th><td><?php echo $courseName; ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th><td colspan="4"><?php echo $Address; ?></td>
                                </tr>
                            </table>
                            <br>
                            <table class="receipt-table">
                                <tr><th colspan="4" class="text-center" style="padding: 10px; font-size: larger;">Course Attendance Sheet</th></tr>
                                <?php for($i = 1; $i<=14; $i+=2): ?>
                                <tr>
                                    <th style="width: 20%">Class <?php echo $i; ?></th><td style="width: 30%"></td>
                                    <th style="width: 20%">Class <?php echo $i+1; ?></th><td style="width: 30%"></td>
                                </tr>
                                <?php endfor; ?>
                            </table>
                            <br>
                            <table class="receipt-table">
                                <tr><th style="width: 10%">1</th><th style="width: 40%">Photography</th><td></td></tr>
                                <tr><th>2</th><th>CNIC Copy</th><td></td></tr>
                                <tr><th>3</th><th>Learner License Copy</th><td></td></tr>
                            </table>
                        </div>
                        <div class="row mt-3 no-print">
                            <div class="col-12"><a href="newEnrollment.php" class="btn btn-primary">Process Another</a></div>
                        </div>

                    <?php elseif (isset($_POST['submit_voucher'])): 
                        $voucherNo = CleanData($_POST['voucherno']);
                        $Voucher = voucherByNo($voucherNo);
                        if ($Voucher && $Voucher->status == 1):
                            $students_copyID = $Voucher->idstudents_copy;
                            $Student = studentByID($students_copyID);
                            $GenderText = genderByID($Student->gender)->name;
                            $courseName = courseByID($Student->idcourse)->coursename;
                    ?>
                        <!-- Enrollment Form -->
                        <div class="card card-primary">
                            <div class="card-header"><h3 class="card-title">Enroll Student: <?php echo $Student->fullname; ?></h3></div>
                            <form role="form" method="post" action="newEnrollment.php">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md">
                                            <label>CNIC</label>
                                            <input type="text" class="form-control" value="<?php echo $Student->cnic; ?>" readonly>
                                            <input type="hidden" name="students_copyid" value="<?php echo $students_copyID; ?>">
                                        </div>
                                        <div class="form-group col-md">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" value="<?php echo $Student->fullname; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md">
                                            <label>Course</label>
                                            <input type="text" class="form-control" value="<?php echo $courseName; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Voucher Paid Date</label>
                                            <input type="date" class="form-control" name="paiddate" value="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Date of Birth</label>
                                            <input type="date" class="form-control" name="dob" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Phone</label>
                                            <input type="number" class="form-control" name="phone" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Blood Group</label>
                                            <select class="form-control" name="blood" required>
                                                <?php echo bloodList(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Shift/Time</label>
                                            <select class="form-control" name="time" required>
                                                <option value="Morning">Morning</option>
                                                <option value="Evening">Evening</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="submit_enrollment" class="btn btn-success btn-block">Confirm Enrollment & Print Form</button>
                                </div>
                            </form>
                        </div>
                        <?php else: ?>
                            <div class='alert alert-warning'>Voucher not found or already paid.</div>
                            <!-- Search Form -->
                            <div class="card card-info">
                                <div class="card-header"><h3 class="card-title">Search Voucher</h3></div>
                                <form role="form" method="post" action="newEnrollment.php">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Enter Voucher Number</label>
                                            <input type="text" class="form-control" name="voucherno" placeholder="e.g. 2407..." required autofocus>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="submit_voucher" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- Default Stage: Search -->
                        <div class="card card-info">
                            <div class="card-header"><h3 class="card-title">Search Voucher</h3></div>
                            <form role="form" method="post" action="newEnrollment.php">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Enter Voucher Number</label>
                                        <input type="text" class="form-control" name="voucherno" placeholder="e.g. 2407..." required autofocus>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="submit_voucher" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        
        <div class="no-print">
            <?php include('footer.php'); ?>
        </div>
    </div>
    <?php include('footerPlugins.php'); ?>
</body>
</html>
