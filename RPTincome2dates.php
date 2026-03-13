<?php session_start();
$pageTitle = "Income Report (Date Range)";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

if (isDEO()) {
    echo "<script>alert('You are not authorized to view this page'); window.location.href = 'index.php';</script>";
    exit();
}

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;
$School = schoolByID($userSchoolID);
$schoolName = $School->location;

$show_report = false;
$firstDate = "";
$secondDate = "";

if (isset($_POST['submit_report'])) {
    $firstDate = CleanData($_POST['firstdate']);
    $secondDate = CleanData($_POST['seconddate']);
    $show_report = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            @page { size: landscape; }
            body { text-align: center; }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="no-print">
            <?php include('topNav.php'); ?>
            <?php include('sidebar.php'); ?>
        </div>

                    <div class="row mb-2"><div class="col-sm-6"><h1 class="m-0 text-dark">Income Report (Date Range)</h1></div></div>

            <section class="content">
                <div class="container-fluid">
                    <?php if (!$show_report): ?>
                        <div class="card card-primary">
                            <div class="card-header"><h3 class="card-title">Select Date Range</h3></div>
                            <form role="form" method="post" action="RPTincome2dates.php">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>First Date</label>
                                            <input type="date" class="form-control" name="firstdate" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Second Date</label>
                                            <input type="date" class="form-control" name="seconddate" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"><button type="submit" name="submit_report" class="btn btn-primary">Generate Report</button></div>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Income Report: <?php echo date("d-M-Y", strtotime($firstDate)); ?> to <?php echo date("d-M-Y", strtotime($secondDate)); ?></h3>
                                <div class="card-tools no-print">
                                    <button onclick="window.location.href='RPTincome2dates.php'" class="btn btn-tool"><i class="fas fa-sync"></i> New Search</button>
                                </div>
                            </div>
                            <div class="card-body" style="overflow-x:auto;">
                                <table id="incomeTable" class="display cell-border" style="width:100%; text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>Sr #</th>
                                            <th>Course Name</th>
                                            <?php
                                            $catQ = "SELECT * FROM studentcategories WHERE status = 1";
                                            $catR = mysqli_query($con, $catQ);
                                            $categories = [];
                                            while ($row = mysqli_fetch_assoc($catR)) {
                                                $categories[] = $row;
                                                echo "<th>" . $row['name'] . "</th>";
                                            }
                                            ?>
                                            <th>Total Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $serial = 1;
                                        $grandTotals = array_fill_keys(array_column($categories, 'id'), 0);
                                        $totalIncomeOverall = 0;

                                        // Prepare queries for sub-counts
                                        $schoolFilter = !isAdmin() ? " AND ad.idschool = $userSchoolID" : "";
                                        
                                        $courses = mysqli_query($con, "SELECT id, coursename, duration FROM courses");
                                        while ($course = mysqli_fetch_assoc($courses)) {
                                            $courseID = $course['id'];
                                            $rowTotal = 0;
                                            echo "<tr>";
                                            echo "<td>$serial</td>";
                                            echo "<td>" . $course['coursename'] . "<br><small>" . $course['duration'] . "</small></td>";
                                            
                                            foreach ($categories as $cat) {
                                                $catID = $cat['id'];
                                                $sql = "SELECT IFNULL(SUM(v.grand_total), 0) as total 
                                                        FROM vouchers v 
                                                        JOIN admissions ad ON ad.idvoucher = v.id
                                                        WHERE v.status = 1 AND v.idcourse = ? AND v.idstudentcategory = ? 
                                                        AND ad.admission_date BETWEEN ? AND ? $schoolFilter";
                                                $stmt = mysqli_prepare($con, $sql);
                                                mysqli_stmt_bind_param($stmt, "iiss", $courseID, $catID, $firstDate, $secondDate);
                                                mysqli_stmt_execute($stmt);
                                                $res = mysqli_stmt_get_result($stmt);
                                                $amount = mysqli_fetch_object($res)->total;
                                                mysqli_stmt_close($stmt);

                                                echo "<td>" . number_format($amount) . "</td>";
                                                $grandTotals[$catID] += $amount;
                                                $rowTotal += $amount;
                                            }
                                            
                                            echo "<td><strong>" . number_format($rowTotal) . "</strong></td>";
                                            $totalIncomeOverall += $rowTotal;
                                            echo "</tr>";
                                            $serial++;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #f4f4f4; font-weight: bold;">
                                            <td></td>
                                            <td>Grand Totals</td>
                                            <?php foreach ($grandTotals as $gt): ?>
                                                <td><?php echo number_format($gt); ?></td>
                                            <?php endforeach; ?>
                                            <td><?php echo number_format($totalIncomeOverall); ?></td>
                                        </tr>
                                    </tfoot>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#incomeTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Income Report (<?php echo $firstDate; ?> to <?php echo $secondDate; ?>)'
                    },
                    {
                        extend: 'print',
                        title: 'Income Report (<?php echo $firstDate; ?> to <?php echo $secondDate; ?>)'
                    }
                ],
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false
            });
        });
    </script>
</body>
</html>
