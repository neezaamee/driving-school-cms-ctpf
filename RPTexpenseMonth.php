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

if (isset($_POST['submit'])) {
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
                    <div class="row mb-2"><div class="col-sm-6"><h1 class="m-0 text-dark">Monthly Expense Report</h1></div></div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php if (!$show_report): ?>
                        <div class="card card-primary">
                            <div class="card-header"><h3 class="card-title">Select Month & Year</h3></div>
                            <form role="form" method="post" action="RPTexpenseMonth.php">
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
                                <div class="card-footer"><button type="submit" name="submit" class="btn btn-primary">Generate Report</button></div>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Expense Summary: <?php echo $MonthName . " " . $Year; ?></h3>
                                <div class="card-tools no-print">
                                    <button onclick="window.location.href='RPTexpenseMonth.php'" class="btn btn-tool"><i class="fas fa-sync"></i> New Search</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="summaryTable" class="table table-bordered table-striped text-center">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Expense Category</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $serial = 1;
                                        $grandTotal = 0;
                                        $schoolFilter = !isAdmin() ? " AND idschool = $userSchoolID" : "";
                                        
                                        $types = mysqli_query($con, "SELECT id, type FROM expensetypes");
                                        while ($t = mysqli_fetch_assoc($types)) {
                                            $typeID = $t['id'];
                                            $sqlS = "SELECT SUM(amount) as total FROM expenses WHERE idexpensetype = ? AND MONTH(date) = ? AND YEAR(date) = ? $schoolFilter";
                                            $stmtS = mysqli_prepare($con, $sqlS);
                                            mysqli_stmt_bind_param($stmtS, "iii", $typeID, $Month, $Year);
                                            mysqli_stmt_execute($stmtS);
                                            $resS = mysqli_stmt_get_result($stmtS);
                                            $rowS = mysqli_fetch_assoc($resS);
                                            $catTotal = $rowS['total'] ?? 0;
                                            mysqli_stmt_close($stmtS);

                                            if ($catTotal > 0) {
                                                echo "<tr><td>$serial</td><td>{$t['type']}</td><td>" . number_format($catTotal) . "</td></tr>";
                                                $grandTotal += $catTotal;
                                                $serial++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #eee; font-weight: bold;">
                                            <td colspan="2">Grand Total</td>
                                            <td><?php echo number_format($grandTotal); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="card card-success mt-4">
                            <div class="card-header"><h3 class="card-title">Monthly Detailed Expense List</h3></div>
                            <div class="card-body" style="overflow-x:auto;">
                                <table id="detailedTable" class="table table-bordered table-sm text-center">
                                    <thead class="bg-success">
                                        <tr>
                                            <th>#</th>
                                            <?php if(isAdmin()) echo "<th>School</th>"; ?>
                                            <th>Date</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Payment</th>
                                            <th>Check #</th>
                                            <th>Payee</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqlDet = "SELECT e.*, et.type as category_name, s.location as school_name
                                                   FROM expenses e
                                                   JOIN expensetypes et ON e.idexpensetype = et.id
                                                   JOIN schools s ON e.idschool = s.id
                                                   WHERE MONTH(e.date) = ? AND YEAR(e.date) = ? " . (!isAdmin() ? " AND e.idschool = $userSchoolID" : "") . "
                                                   ORDER BY e.date DESC";
                                        $stmtDet = mysqli_prepare($con, $sqlDet);
                                        mysqli_stmt_bind_param($stmtDet, "ii", $Month, $Year);
                                        mysqli_stmt_execute($stmtDet);
                                        $resDet = mysqli_stmt_get_result($stmtDet);
                                        $serial = 1;
                                        while($row = mysqli_fetch_assoc($resDet)) {
                                            $paymentMethod = ($row['payment_method'] == 1) ? 'Cash' : 'Cheque';
                                            echo "<tr>";
                                            echo "<td>$serial</td>";
                                            if(isAdmin()) echo "<td>" . $row['school_name'] . "</td>";
                                            echo "<td>" . date("d-m-Y", strtotime($row['date'])) . "</td>";
                                            echo "<td>" . $row['category_name'] . "</td>";
                                            echo "<td>" . $row['description'] . "</td>";
                                            echo "<td>" . number_format($row['amount']) . "</td>";
                                            echo "<td>$paymentMethod</td>";
                                            echo "<td>" . $row['check_no'] . "</td>";
                                            echo "<td>" . $row['issue_to'] . "</td>";
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
