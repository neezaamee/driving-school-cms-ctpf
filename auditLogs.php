<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');

if (!isAdmin()) {
    header("Location: index.php");
    exit;
}

$pageTitle = "System Audit Logs";
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->
<!--Body-->
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('topNav.php') ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include ('sidebar.php')?>
        <!--/ Main Sidebar Container-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">System Audit Logs</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Recent Activity</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="auditTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date/Time</th>
                                                    <th>User</th>
                                                    <th>Action</th>
                                                    <th>Target Table</th>
                                                    <th>Target ID</th>
                                                    <th>IP Address</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                use App\Models\AuditLog;
                                                $logs = AuditLog::latestWithUsers(500);
                                                
                                                if (!empty($logs)) {
                                                    foreach ($logs as $row) {
                                                        $userName = $row->username ? e($row->firstname . ' ' . $row->lastname . ' (' . $row->username . ')') : 'Unknown User (' . e($row->user_id) . ')';
                                                        echo "<tr>";
                                                        echo "<td>" . e($row->id) . "</td>";
                                                        echo "<td>" . e(date('d-m-Y H:i:s', strtotime($row->created_at))) . "</td>";
                                                        echo "<td>" . $userName . "</td>";
                                                        echo "<td><span class='badge bg-info'>" . e($row->action) . "</span></td>";
                                                        echo "<td>" . e($row->target_table) . "</td>";
                                                        echo "<td>" . e($row->target_id) . "</td>";
                                                        echo "<td>" . e($row->ip_address) . "</td>";
                                                        echo "<td>" . e($row->details) . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='8' class='text-center text-muted'>No audit logs found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!--Footer Content-->
        <?php include ('footer.php')?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
    <!-- ./wrapper -->
    <?php include ('footerPlugins.php')?>
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#auditTable')) {
                $('#auditTable').DataTable().destroy();
            }
            $('#auditTable').DataTable({
                "pageLength": 50,
                "order": [[0, "desc"]]
            });
        });
    </script>
</body>
</html>
