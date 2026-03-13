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
$firstDate = date('Y-m-d');
$secondDate = date('Y-m-d');

if (isset($_POST['submit'])) {
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
                    <div class="row mb-2"><div class="col-sm-6"><h1 class="m-0 text-dark">Gasoline Expense Report</h1></div></div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php if (!$show_report): ?>
                        <div class="card card-primary">
                            <div class="card-header"><h3 class="card-title">Gasoline Report (Two Dates)</h3></div>
                            <form role="form" method="post" action="RPTexpensePetrol2dates.php">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>From Date</label>
                                            <input type="date" class="form-control" name="firstdate" required value="<?php echo date('Y-m-01'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>To Date</label>
                                            <input type="date" class="form-control" name="seconddate" required value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"><button type="submit" name="submit" class="btn btn-primary">Generate Report</button></div>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Gasoline Expenses: <?php echo date("d-m-Y", strtotime($firstDate)) . " to " . date("d-m-Y", strtotime($secondDate)); ?></h3>
                                <div class="card-tools no-print">
                                    <button onclick="window.location.href='RPTexpensePetrol2dates.php'" class="btn btn-tool"><i class="fas fa-sync"></i> New Search</button>
                                </div>
                            </div>
                            <div class="card-body" style="overflow-x:auto;">
                                <table id="gasolineTable" class="table table-bordered table-striped text-center">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>#</th>
                                            <?php if(isAdmin()) echo "<th>School</th>"; ?>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Slip #</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $serial = 1;
                                        $grandTotal = 0;
                                        $schoolFilter = !isAdmin() ? " AND ep.idschool = $userSchoolID" : "";
                                        
                                        $sql = "SELECT ep.*, s.location as school_name 
                                                FROM expensepetrol ep
                                                JOIN schools s ON ep.idschool = s.id
                                                WHERE DATE(ep.date) >= ? AND DATE(ep.date) <= ? $schoolFilter 
                                                ORDER BY ep.date DESC";
                                        $stmt = mysqli_prepare($con, $sql);
                                        mysqli_stmt_bind_param($stmt, "ss", $firstDate, $secondDate);
                                        mysqli_stmt_execute($stmt);
                                        $res = mysqli_stmt_get_result($stmt);
                                        
                                        while($row = mysqli_fetch_assoc($res)) {
                                            echo "<tr>";
                                            echo "<td>$serial</td>";
                                            if(isAdmin()) echo "<td>" . $row['school_name'] . "</td>";
                                            echo "<td>" . date("d-m-Y", strtotime($row['date'])) . "</td>";
                                            echo "<td>" . strtoupper($row['type']) . "</td>";
                                            echo "<td>" . $row['slipno'] . "</td>";
                                            echo "<td>" . $row['quantity'] . "</td>";
                                            echo "<td>" . number_format($row['saleprice']) . "</td>";
                                            echo "<td>" . number_format($row['amount']) . "</td>";
                                            echo "<td>" . $row['description'] . "</td>";
                                            echo "</tr>";
                                            $grandTotal += $row['amount'];
                                            $serial++;
                                        }
                                        mysqli_stmt_close($stmt);
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #eee; font-weight: bold;">
                                            <td colspan="<?php echo isAdmin() ? 7 : 6; ?>">Grand Total</td>
                                            <td colspan="2"><?php echo number_format($grandTotal); ?></td>
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
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#gasolineTable').DataTable({ dom: 'Bfrtip', buttons: ['copy', 'excel', 'pdf', 'print'], pageLength: 25 });
        });
    </script>
</body>
</html>
