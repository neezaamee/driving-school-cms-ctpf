<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

if (!isAdmin()) {
    echo "<script>alert('You are not authorized to view this page'); window.location.href = 'index.php';</script>";
    exit();
}

$show_report = false;
$schoolID = "";
$schoolName = "";

if (isset($_POST['submit_report'])) {
    $schoolID = CleanData($_POST['schoolid']);
    $School = schoolByID($schoolID);
    $schoolName = $School->location;
    $show_report = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
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
                    <div class="row mb-2"><div class="col-sm-6"><h1 class="m-0 text-dark">School Income Report</h1></div></div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php if (!$show_report): ?>
                        <div class="card card-primary">
                            <div class="card-header"><h3 class="card-title">Select School</h3></div>
                            <form role="form" method="post" action="RPTincomeSchool.php">
                                <div class="card-body">
                                    <div class="form-group col-md-4">
                                        <label>School Location</label>
                                        <select class="form-control" name="schoolid" required>
                                            <option value="">Select School</option>
                                            <?php echo schoolsList(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer"><button type="submit" name="submit_report" class="btn btn-primary">Generate Report</button></div>
                            </form>
                        </div>
                    <?php else: 
                        // Processing Logic (Secure)
                        $sql_enrolled = "SELECT COUNT(*) as total FROM admissions WHERE idschool = ?";
                        $stmt = mysqli_prepare($con, $sql_enrolled);
                        mysqli_stmt_bind_param($stmt, "i", $schoolID);
                        mysqli_stmt_execute($stmt);
                        $studentEnrolled = mysqli_stmt_get_result($stmt)->fetch_object()->total;
                        mysqli_stmt_close($stmt);

                        $sql_fees = "SELECT SUM(IFNULL(v.total, 0)) as total_fee, SUM(IFNULL(v.grand_total, 0)) as total_paid 
                                     FROM vouchers v 
                                     JOIN admissions ad ON ad.idvoucher = v.id 
                                     WHERE v.status = 1 AND ad.idschool = ?";
                        $stmt = mysqli_prepare($con, $sql_fees);
                        mysqli_stmt_bind_param($stmt, "i", $schoolID);
                        mysqli_stmt_execute($stmt);
                        $feeRow = mysqli_stmt_get_result($stmt)->fetch_object();
                        $totalFee = $feeRow->total_fee ?? 0;
                        $totalPaid = $feeRow->total_paid ?? 0;
                        mysqli_stmt_close($stmt);

                        $sql_pnd = "SELECT COUNT(*) as total FROM admissions WHERE pickndrop > 0 AND idschool = ?";
                        $stmt = mysqli_prepare($con, $sql_pnd);
                        mysqli_stmt_bind_param($stmt, "i", $schoolID);
                        mysqli_stmt_execute($stmt);
                        $pickdrop = mysqli_stmt_get_result($stmt)->fetch_object()->total;
                        mysqli_stmt_close($stmt);
                    ?>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Income Report: <?php echo $schoolName; ?></h3>
                                <div class="card-tools no-print">
                                    <button onclick="window.location.href='RPTincomeSchool.php'" class="btn btn-tool"><i class="fas fa-sync"></i> New Search</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="schoolTable" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Students Enrolled</th>
                                            <th>Total Fee</th>
                                            <th>Pick n Drop</th>
                                            <th>Total Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $studentEnrolled; ?></td>
                                            <td><?php echo number_format($totalFee); ?></td>
                                            <td><?php echo $pickdrop; ?></td>
                                            <td><strong><?php echo number_format($totalPaid); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <div class="no-print"><?php include('footer.php'); ?></div>
    </div>
    <?php include('footerPlugins.php'); ?>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#schoolTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print'],
                paging: false,
                ordering: false,
                info: false,
                searching: false
            });
        });
    </script>
</body>
</html>
