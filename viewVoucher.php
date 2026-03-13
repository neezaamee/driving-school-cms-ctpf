<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;
$School = schoolByID($userSchoolID);
$schoolName = $School->location;

$error_msg = "";
$show_voucher = false;

if (isset($_POST['search_voucher'])) {
    $voucherNo = CleanData($_POST['voucherno']);
    
    $sql = "SELECT 
                v.*, 
                s.fullname as studentName, s.fathername, s.cnic,
                c.coursename, c.duration,
                sch.location as schoolLoc,
                city.name as cityName, city.extras as cityExtras, city.bankfee, city.bookfee
            FROM vouchers v
            INNER JOIN students s ON v.idstudent = s.id
            INNER JOIN courses c ON v.idcourse = c.id
            INNER JOIN schools sch ON v.idschool = sch.id
            INNER JOIN cities city ON sch.idcity = city.id
            WHERE v.vouchernumber = ?";
    
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $voucherNo);
    mysqli_stmt_execute($stmt);
    $Result = mysqli_stmt_get_result($stmt);
    
    if ($Row = mysqli_fetch_assoc($Result)) {
        $show_voucher = true;
        // Map data to variables for layout
        $Name = $Row['studentName'];
        $Guardian = $Row['fathername'];
        $CNIC = $Row['cnic'];
        $courseName = $Row['coursename'] . " - " . $Row['duration'];
        $courseFee = $Row['admission'];
        $prospectusFee = $Row['prospectus'];
        $pickdropFee = $Row['pickndrop'];
        $Discount = $Row['discount'];
        $bankCharges = $Row['bankfee'];
        $netPayable = $Row['grand_total'] + $bankCharges;
        $SchoolLoc = $Row['schoolLoc'];
        $CityName = $Row['cityName'];
        $CityExtras = $Row['cityExtras'];
        $voucherNo = $Row['vouchernumber'];
    } else {
        $error_msg = "Voucher number <strong>$voucherNo</strong> not found!";
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
                            <h1 class="m-0 text-dark">Duplicate Voucher</h1>
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
                        <div class="voucher-container">
                            <?php 
                            $copies = ["Bank Copy", "School Copy", "Student Copy"];
                            foreach ($copies as $copy_name): 
                            ?>
                            <div class="voucher-copy">
                                <img src="images/CTPF2.png" class="watermark" alt="CTP Watermark">
                                <div class="voucher-header">
                                    <h6>Driving School Traffic Police Punjab</h6>
                                    <strong style="font-size: larger;"><?php echo $SchoolLoc; ?> - <?php echo $CityName; ?></strong><br>
                                    <strong>Fee Challan</strong>
                                </div>
                                <div style="font-size: 9px; margin-bottom: 5px;"><?php echo $CityExtras; ?></div>
                                <table class="voucher-table">
                                    <tr><th>PSID / Voucher #</th><td><strong><?php echo $voucherNo; ?></strong></td></tr>
                                    <tr><th>Issue Date</th><td><?php echo date("d-m-Y", strtotime($Row['created_at'])); ?></td></tr>
                                    <tr><th>Due Date</th><td><?php echo date('d-m-Y', strtotime($Row['created_at'] . " +4 days")); ?></td></tr>
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
                        <div class="mt-3 no-print text-center">
                            <button onclick="window.print()" class="btn btn-success"><i class="fas fa-print"></i> Print Voucher</button>
                            <a href="viewVoucher.php" class="btn btn-primary">Back</a>
                        </div>

                    <?php else: ?>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header"><h3 class="card-title">Search Voucher</h3></div>
                                    <form role="form" method="post" action="viewVoucher.php">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Voucher Number / PSID</label>
                                                <input type="text" class="form-control" name="voucherno" placeholder="Enter Voucher Number" required autofocus>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="search_voucher" class="btn btn-primary">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <div class="no-print"><?php include('footer.php'); ?></div>
    </div>
    <?php include('footerPlugins.php'); ?>
</body>
</html>
