<?php session_start();
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

$show_report = false;
$Month = date('m');
$Year = date('Y');
$MonthName = "";

if (isset($_POST['submit_report'])) {
    $Month = CleanData($_POST['month']);
    $Year = CleanData($_POST['year']);
    $MonthName = date("F", mktime(0, 0, 0, $Month, 10));
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
                    <div class="row mb-2"><div class="col-sm-6"><h1 class="m-0 text-dark">Monthly Student Report</h1></div></div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php if (!$show_report): ?>
                        <div class="card card-primary">
                            <div class="card-header"><h3 class="card-title">Select Month & Year</h3></div>
                            <form role="form" method="post" action="RPTstudentMonth.php">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Month</label>
                                            <select class="form-control" name="month" required>
                                                <?php for($m=1; $m<=12; $m++): ?>
                                                    <option value="<?php echo $m; ?>" <?php if($m == date('n')) echo 'selected'; ?>><?php echo date('F', mktime(0,0,0,$m, 10)); ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Year</label>
                                            <select class="form-control" name="year" required>
                                                <?php for($y=date('Y'); $y>=2020; $y--): ?>
                                                    <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"><button type="submit" name="submit_report" class="btn btn-primary">Generate Report</button></div>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Student Summary: <?php echo $MonthName . " " . $Year; ?></h3>
                                <div class="card-tools no-print">
                                    <button onclick="window.location.href='RPTstudentMonth.php'" class="btn btn-tool"><i class="fas fa-sync"></i> New Search</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="summaryTable" class="table table-bordered table-striped text-center">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Course</th>
                                            <th>Male</th>
                                            <th>Female</th>
                                            <th>Transgender</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $serial = 1;
                                        $grandM = 0; $grandF = 0; $grandT = 0; $grandTotal = 0;
                                        $schoolFilter = !isAdmin() ? " AND ad.idschool = $userSchoolID" : "";
                                        
                                        $courses = mysqli_query($con, "SELECT id, coursename, duration FROM courses");
                                        while ($course = mysqli_fetch_assoc($courses)) {
                                            $courseID = $course['id'];
                                            
                                            $sqlG = "SELECT s.gender, COUNT(*) as count 
                                                     FROM admissions ad 
                                                     JOIN students s ON ad.idstudent = s.id 
                                                     WHERE ad.idcourse = ? AND MONTH(ad.admission_date) = ? AND YEAR(ad.admission_date) = ? $schoolFilter 
                                                     GROUP BY s.gender";
                                            $stmtG = mysqli_prepare($con, $sqlG);
                                            mysqli_stmt_bind_param($stmtG, "iii", $courseID, $Month, $Year);
                                            mysqli_stmt_execute($stmtG);
                                            $resG = mysqli_stmt_get_result($stmtG);
                                            
                                            $counts = [1 => 0, 2 => 0, 3 => 0];
                                            while($gRow = mysqli_fetch_assoc($resG)) {
                                                $counts[$gRow['gender']] = $gRow['count'];
                                            }
                                            mysqli_stmt_close($stmtG);
                                            
                                            $rowTotal = array_sum($counts);
                                            if ($rowTotal > 0) {
                                                echo "<tr>";
                                                echo "<td>$serial</td>";
                                                echo "<td>" . $course['coursename'] . "<br><small>" . $course['duration'] . "</small></td>";
                                                echo "<td>" . $counts[1] . "</td>";
                                                echo "<td>" . $counts[2] . "</td>";
                                                echo "<td>" . $counts[3] . "</td>";
                                                echo "<td><strong>$rowTotal</strong></td>";
                                                echo "</tr>";
                                                $grandM += $counts[1]; $grandF += $counts[2]; $grandT += $counts[3]; $grandTotal += $rowTotal;
                                                $serial++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #eee; font-weight: bold;">
                                            <td colspan="2">Grand Totals</td>
                                            <td><?php echo $grandM; ?></td>
                                            <td><?php echo $grandF; ?></td>
                                            <td><?php echo $grandT; ?></td>
                                            <td><?php echo $grandTotal; ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="card card-success mt-4">
                            <div class="card-header"><h3 class="card-title">Monthly Detailed Student List</h3></div>
                            <div class="card-body" style="overflow-x:auto;">
                                <table id="detailedTable" class="table table-bordered table-sm text-center">
                                    <thead class="bg-success">
                                        <tr>
                                            <th>#</th>
                                            <?php if(isAdmin()) echo "<th>School</th>"; ?>
                                            <th>Reg #</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>CNIC</th>
                                            <th>Course</th>
                                            <th>Paid Amt</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqlDet = "SELECT ad.*, s.fullname, s.cnic, c.coursename, v.grand_total as paid_amt, sc.location as school_name
                                                   FROM admissions ad 
                                                   JOIN students s ON ad.idstudent = s.id 
                                                   JOIN courses c ON ad.idcourse = c.id 
                                                   JOIN vouchers v ON ad.idvoucher = v.id 
                                                   JOIN schools sc ON ad.idschool = sc.id
                                                   WHERE MONTH(ad.admission_date) = ? AND YEAR(ad.admission_date) = ? $schoolFilter
                                                   ORDER BY ad.admission_date DESC";
                                        $stmtDet = mysqli_prepare($con, $sqlDet);
                                        mysqli_stmt_bind_param($stmtDet, "ii", $Month, $Year);
                                        mysqli_stmt_execute($stmtDet);
                                        $resDet = mysqli_stmt_get_result($stmtDet);
                                        $serial = 1;
                                        while($row = mysqli_fetch_assoc($resDet)) {
                                            echo "<tr>";
                                            echo "<td>$serial</td>";
                                            if(isAdmin()) echo "<td>" . $row['school_name'] . "</td>";
                                            echo "<td>" . $row['registration'] . "</td>";
                                            echo "<td>" . date("d-m-Y", strtotime($row['admission_date'])) . "</td>";
                                            echo "<td>" . $row['fullname'] . "</td>";
                                            echo "<td>" . $row['cnic'] . "</td>";
                                            echo "<td>" . $row['coursename'] . "</td>";
                                            echo "<td>" . number_format($row['paid_amt']) . "</td>";
                                            echo "<td><span class='badge badge-success'>Admitted</span></td>";
                                            echo "</tr>";
                                            $serial++;
                                        }
                                        mysqli_stmt_close($stmtDet);
                                        ?>
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
            $('#summaryTable').DataTable({ dom: 'Bfrtip', buttons: ['copy', 'excel', 'pdf', 'print'], paging: false, info: false });
            $('#detailedTable').DataTable({ dom: 'Bfrtip', buttons: ['copy', 'excel', 'pdf', 'print'], pageLength: 25 });
        });
    </script>
</body>
</html>
