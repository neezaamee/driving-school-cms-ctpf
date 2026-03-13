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
$show_voucher = false;

// Stage 3: Process Voucher Generation
if (isset($_POST['submit_generate_voucher'])) {
    $studentSchoolID = CleanData($_POST['stschoolid']);
    $CNIC = CleanData($_POST['cnic']);
    $Name = strtoupper(CleanData($_POST['fullname']));
    $Guardian = strtoupper(CleanData($_POST['fathername']));
    $Gender = CleanData($_POST['gender']);
    $courseID = CleanData($_POST['course']);
    $pickdropFee = CleanData($_POST['pickndrop']);
    $studentCategory = CleanData($_POST['stcategory']);
    $Discount = CleanData($_POST['discount']);
    $discountBy = CleanData($_POST['discountby']);
    $Remarks = CleanData($_POST['remarks']);
    
    $Course = courseByID($courseID);
    $courseName = "$Course->coursename - $Course->duration";
    $courseFee = $Course->fee;
    
    // Generate Voucher Number
    $voucherNo = date("ymd") . "-" . $courseID . $studentSchoolID . "-" . rand(111111, 999999);
    
    // Calculation
    $SchoolInfo = schoolByID($studentSchoolID);
    $CityInfo = cityByID($SchoolInfo->idcity);
    $prospectusFee = $CityInfo->bookfee;
    $bankCharges = $CityInfo->bankfee; 
    // Let's stick to legacy math:
    $Total = (int)$courseFee + (int)$pickdropFee + (int)$prospectusFee;
    $grandTotal = (int)$Total - (int)$Discount;
    $netPayable = $grandTotal + (int)$bankCharges;

    // Start Transaction
    mysqli_begin_transaction($con);
    try {
        // 1. Handle Student Record
        $existingStudent = findStudentByCNIC($CNIC);
        if ($existingStudent) {
            $studentID = studentsByCNIC($CNIC)->id;
            // Optionally update existing student category if needed
        } else {
            $studentID = addStudentWithNull($Name, $Guardian, $Gender, $CNIC);
        }

        if (!$studentID) throw new Exception("Failed to process student record.");

        // 2. Add Voucher
        $newVoucherID = addVoucher($voucherNo, $courseFee, $prospectusFee, $pickdropFee, $Total, $Discount, $discountBy, $Remarks, $grandTotal, $studentID, $studentCategory, $courseID, $studentSchoolID, $userID, 0);
        
        if (!$newVoucherID) throw new Exception("Failed to create voucher.");

        mysqli_commit($con);
        $show_voucher = true;
    } catch (Exception $e) {
        mysqli_rollback($con);
        $error_msg = "Error: " . $e->getMessage();
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
            @page { size: landscape; margin: 5mm; }
            body { background: none; }
            .content-wrapper { margin: 0 !important; padding: 0 !important; background: none !important; }
            .main-sidebar, .main-header, .main-footer { display: none !important; }
        }
        .voucher-container { display: flex; gap: 10px; font-size: 11px; }
        .voucher-copy { flex: 1; border: 1px solid #000; padding: 10px; background: #fff; position: relative; }
        .voucher-header { text-align: center; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px; }
        .voucher-table { width: 100%; table-layout:fixed; border-collapse: collapse; margin-bottom: 10px; }
        .voucher-table th, .voucher-table td { border: 1px solid #000; padding: 3px 5px; text-align: left; }
        .voucher-footer { font-size: 9px; margin-top: 10px; }
        .copy-type { font-weight: bold; text-align: center; text-transform: uppercase; margin-top: 5px; border-top: 1px solid #000; }
        .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1; z-index: 0; pointer-events: none; width: 100%; }
        /*.watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); opacity: 0.1; z-index: 0; pointer-events: none; width: 70%; }*/
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
                            <h1 class="m-0 text-dark">New Enrollment - <?php echo $schoolName; ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php if ($error_msg): ?>
                        <div class="alert alert-danger no-print"><?php echo $error_msg; ?></div>
                    <?php endif; ?>

                    <?php if ($show_voucher): ?>
                        <div class="alert alert-success no-print">Voucher generated successfully! <button onclick="window.print()" class="btn btn-sm btn-dark ml-2">Print Voucher</button></div>
                        
                        <div class="voucher-container">
                            <?php 
                            $copies = ["Bank Copy", "School Copy", "Student Copy"];
                            foreach ($copies as $copy_name): 
                            ?>
                            <div class="voucher-copy">
                                <img src="images/CTPF2.png" class="watermark" alt="CTP Watermark">
                                <div class="voucher-header">
                                    <h6>Driving School Traffic Police Punjab</h6>
                                    <strong style="font-size: larger;"><?php echo $SchoolInfo->location; ?> - <?php echo $CityInfo->name; ?></strong><br>
                                    <strong>Fee Challan</strong>
                                </div>
                                <div style="font-size: 9px; margin-bottom: 5px;"><?php echo $CityInfo->extras; ?></div>
                                <table class="voucher-table">
                                    <tr><th>PSID / Voucher #</th><td><strong><?php echo $voucherNo; ?></strong></td></tr>
                                    <tr><th>Issue Date</th><td><?php echo date("d-m-Y"); ?></td></tr>
                                    <tr><th>Due Date</th><td><?php echo date('d-m-Y', strtotime("+4 days")); ?></td></tr>
                                    <tr><th>Name</th><td><?php echo $Name; ?></td></tr>
                                    <tr><th>Guardian</th><td><?php echo $Guardian; ?></td></tr>
                                    <tr><th>CNIC</th><td><?php echo $CNIC; ?></td></tr>
                                    <tr><th>Program</th><td><?php echo $courseName; ?></td></tr>
                                </table>
                                <table class="voucher-table">
                                    <thead><tr><th>Description</th><th style="text-align: right">Amount</th></tr></thead>
                                    <tbody>
                                        <tr><td>Admission Fee</td><td style="text-align: right"><?php echo number_format($courseFee); ?></td></tr>
                                        <tr><td>Course Book</td><td style="text-align: right"><?php echo number_format($prospectusFee); ?></td></tr>
                                        <tr><td>Pick and Drop</td><td style="text-align: right"><?php echo $pickdropFee > 0 ? number_format($pickdropFee) : "-"; ?></td></tr>
                                        <tr><td>Fee Concession</td><td style="text-align: right"><?php echo $Discount > 0 ? "-".number_format($Discount) : "-"; ?></td></tr>
                                        <tr><td>Bank Service Charges</td><td style="text-align: right"><?php echo number_format($bankCharges); ?></td></tr>
                                        <tr><th><strong>Total Payable</strong></th><th style="text-align: right"><strong><?php echo number_format($netPayable); ?>/-</strong></th></tr>
                                    </tbody>
                                </table>
                                <div class="voucher-footer">
                                    <ul>
                                        <li>Fee must be deposited within due date at authorized banks.</li>
                                        <li>Voucher cancels automatically after due date.</li>
                                        <li>Note: Computer generated fee voucher.</li>
                                    </ul>
                                </div>
                                <div class="copy-type"><?php echo $copy_name; ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-3 no-print">
                            <a href="newEnroll.php" class="btn btn-primary">New Enrollment</a>
                        </div>
                        <script>
                            setTimeout(function() {
                                // Optional auto-redirect logic if desired
                            }, 5000);
                        </script>

                    <?php elseif (isset($_POST['submit'])): 
                        $CNIC = CleanData($_POST['cnic']);
                        $Student = studentsByCNIC($CNIC);
                        $found = ($Student) ? true : false;
                    ?>
                        <!-- Stage 2: Enrollment Details -->
                        <div class="card card-primary">
                            <div class="card-header"><h3 class="card-title"><?php echo $found ? "Existing Student Details" : "New Student Details"; ?></h3></div>
                            <form role="form" method="post" action="newEnroll.php">
                                <div class="card-body">
                                    <div class="form-row">
                                        <?php if (isAdmin()): ?>
                                            <div class="form-group col-md-12"><label>School</label>
                                                <select class="form-control" name="stschoolid"><?php echo schoolsList($userSchoolID); ?></select>
                                            </div>
                                        <?php else: ?>
                                            <input type="hidden" name="stschoolid" value="<?php echo $userSchoolID; ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4"><label>CNIC</label>
                                            <input type="text" class="form-control" name="cnic" value="<?php echo $CNIC; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-4"><label>Full Name</label>
                                            <input type="text" class="form-control" name="fullname" value="<?php echo $found ? $Student->fullname : ''; ?>" <?php echo $found ? 'readonly' : 'required'; ?>>
                                        </div>
                                        <div class="form-group col-md-4"><label>Guardian Name</label>
                                            <input type="text" class="form-control" name="fathername" value="<?php echo $found ? $Student->fathername : ''; ?>" <?php echo $found ? 'readonly' : 'required'; ?>>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4"><label>Gender</label>
                                            <?php if ($found): ?>
                                                <input type="text" class="form-control" value="<?php echo genderByID($Student->gender)->name; ?>" readonly>
                                                <input type="hidden" name="gender" value="<?php echo $Student->gender; ?>">
                                            <?php else: ?>
                                                <select class="form-control" name="gender" required>
                                                    <option value="1">Male</option><option value="2">Female</option><option value="3">Transgender</option>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-md-4"><label>Course</label>
                                            <select class="form-control" name="course" required><?php echo coursesList(); ?></select>
                                        </div>
                                        <div class="form-group col-md-4"><label>Pick n Drop</label>
                                            <select class="form-control" name="pickndrop" required>
                                                <option value="0">NO</option><option value="1000">YES</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4"><label>Student Category</label>
                                            <select class="form-control" id="stcategory" name="stcategory" onchange="toggleDiscountFields()"><?php echo studentCategories(1); ?></select>
                                        </div>
                                        <div class="form-group col-md-4" id="discountContainer" style="display:none;"><label>Discount</label>
                                            <input type="number" class="form-control" name="discount" value="0">
                                        </div>
                                        <div class="form-group col-md-4" id="discountByContainer" style="display:none;"><label>Discount By</label>
                                            <select class="form-control" name="discountby"><?php echo authoritiesList(10); ?></select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-12"><label>Remarks</label>
                                            <textarea class="form-control" name="remarks" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="submit_generate_voucher" class="btn btn-success btn-block">Generate & Print Voucher</button>
                                </div>
                            </form>
                        </div>

                    <?php else: ?>
                        <!-- Stage 1: CNIC Entry -->
                        <div class="card card-info">
                            <div class="card-header"><h3 class="card-title">New Enrollment / Check CNIC</h3></div>
                            <form role="form" method="post" action="newEnroll.php" id="cnicForm">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>CNIC</label>
                                        <input type="number" class="form-control" name="cnic" placeholder="13 Digits (no dashes)" required autofocus>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Check CNIC</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <div class="no-print"><?php include('footer.php'); ?></div>
    </div>
    <?php include('footerPlugins.php'); ?>
    <script>
        function toggleDiscountFields() {
            var category = document.getElementById("stcategory").value;
            var dC = document.getElementById("discountContainer");
            var dbC = document.getElementById("discountByContainer");
            if (category == "1") {
                dC.style.display = "none"; dbC.style.display = "none";
            } else {
                dC.style.display = "block"; dbC.style.display = "block";
            }
        }
    </script>
</body>
</html>
