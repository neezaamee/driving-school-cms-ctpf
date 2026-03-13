<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;
$School = schoolByID($userSchoolID);
$schoolName = $School->location;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('Head.php'); ?>
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            @page { size: landscape; margin: 10px; }
            body { font-size: 10px; }
            .wrapper { background: none !important; }
            .content-wrapper { margin-left: 0 !important; }
        }
        .print-only { display: none; }
        table { border: 1px solid black !important; border-collapse: collapse !important; }
        th, td { border: 1px solid black !important; padding: 5px !important; }
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
                        <div class="col-sm-6"><h1 class="m-0 text-dark">Voucher Management</h1></div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php
                    if (isset($_POST['submit_voucher'])) {
                        // Logic from createVoucherRSP3.php
                        $schoolID = CleanData($_POST['schoolid']);
                        $CNIC = CleanData($_POST['cnic']);
                        $Name = CleanData($_POST['fullname']);
                        $Guardian = CleanData($_POST['fathername']);
                        $Gender = CleanData($_POST['gender']);
                        $courseID = CleanData($_POST['course']);
                        $pickdropFee = CleanData($_POST['pickndrop']);
                        $Discount = CleanData($_POST['discount']);
                        
                        $Course = courseByID($courseID);
                        $courseName = $Course->coursename;
                        $courseFee = $Course->fee;
                        
                        $voucherNo = date("ymd") . "-" . $courseID . $schoolID . "-" . rand(111111, 999999);
                        $prospectusFee = 400;
                        $Total = $courseFee + $pickdropFee + $prospectusFee;
                        $grandTotal = $Total - $Discount;

                        if (addStudentCreateVoucher($schoolID, $CNIC, $Name, $Guardian, $Gender, $courseID, $pickdropFee, $voucherNo, $courseFee, $prospectusFee, $pickdropFee, $Total, $Discount, $grandTotal)) {
                            ?>
                            <div class="alert alert-success no-print">Voucher created successfully. <button onclick="window.print()" class="btn btn-sm btn-dark ml-2">Print Now</button></div>
                            <div class="row">
                                <?php
                                $copies = ["Bank Copy", "School Copy", "Student Copy"];
                                foreach ($copies as $copyName) {
                                ?>
                                <div class="col-md-4">
                                    <table class="table table-sm" style="width: 100%;">
                                        <tr><th colspan="2" class="text-center"><?php echo "Fee Voucher " . date("Y") . "<br>" . $schoolName; ?></th></tr>
                                        <tr><td colspan="2" style="font-size: 10px;">Acc # 6010123313500013<br>Bank of Punjab - Authorized Branches</td></tr>
                                        <tr><th>Voucher #</th><td><b><?php echo $voucherNo; ?></b></td></tr>
                                        <tr><th>Issue Date</th><td><?php echo date("d-m-Y"); ?></td></tr>
                                        <tr><th>Due Date</th><td><?php echo date('d-m-Y', strtotime("+4 days")); ?></td></tr>
                                        <tr><th>Name</th><td><?php echo $Name; ?></td></tr>
                                        <tr><th>CNIC</th><td><?php echo $CNIC; ?></td></tr>
                                        <tr><th>Course</th><td><?php echo $courseName; ?></td></tr>
                                        <tr><th>Description</th><th class="text-right">Amount</th></tr>
                                        <tr><td>Admission Fee</td><td class="text-right"><?php echo $courseFee; ?></td></tr>
                                        <tr><td>Prospectus</td><td class="text-right"><?php echo $prospectusFee; ?></td></tr>
                                        <?php if($pickdropFee > 0) { ?>
                                        <tr><td>Pick n Drop</td><td class="text-right"><?php echo $pickdropFee; ?></td></tr>
                                        <?php } ?>
                                        <?php if($Discount > 0) { ?>
                                        <tr><td>Discount</td><td class="text-right">-<?php echo $Discount; ?></td></tr>
                                        <?php } ?>
                                        <tr><th>Total Payable</th><th class="text-right"><?php echo $grandTotal; ?>/-</th></tr>
                                        <tr><td colspan="2" class="text-center"><b><?php echo $copyName; ?></b></td></tr>
                                    </table>
                                </div>
                                <?php } ?>
                            </div>
                            <?php
                        } else {
                            echo "<div class='alert alert-danger no-print'>Error creating voucher.</div>";
                        }
                    } else {
                        ?>
                        <div class="card card-primary no-print">
                            <div class="card-header"><h3 class="card-title">Create New Fee Voucher</h3></div>
                            <form role="form" method="post" action="createVoucher.php">
                                <div class="card-body">
                                    <div class="form-row">
                                        <?php if (isAdmin()) { ?>
                                        <div class="form-group col-md-4">
                                            <label>School</label>
                                            <select class="form-control" name="schoolid">
                                                <?php
                                                $s_res = mysqli_query($con, "SELECT * FROM schools WHERE id != 1");
                                                while($s = mysqli_fetch_array($s_res)) echo "<option value='{$s['id']}'>{$s['location']}</option>";
                                                ?>
                                            </select>
                                        </div>
                                        <?php } else { ?><input type="hidden" name="schoolid" value="<?php echo $userSchoolID; ?>"><?php } ?>
                                        <div class="form-group col-md-4">
                                            <label>CNIC</label>
                                            <input type="number" class="form-control" name="cnic" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" name="fullname" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Guardian Name</label>
                                            <input type="text" class="form-control" name="fathername" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender">
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                                <option value="3">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Course</label>
                                            <select class="form-control" name="course">
                                                <?php
                                                $c_res = mysqli_query($con, "SELECT * FROM courses");
                                                while($c = mysqli_fetch_array($c_res)) echo "<option value='{$c['id']}'>{$c['coursename']}</option>";
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Pick n Drop</label>
                                            <select class="form-control" name="pickndrop">
                                                <option value="0">No</option>
                                                <option value="1000">Yes (1000/-)</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Discount</label>
                                            <input type="number" class="form-control" name="discount" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"><button type="submit" name="submit_voucher" class="btn btn-primary">Generate Voucher</button></div>
                            </form>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </section>
        </div>
        <div class="no-print"><?php include('footer.php'); ?></div>
    </div>
    <?php include('footerPlugins.php'); ?>
</body>
</html>
