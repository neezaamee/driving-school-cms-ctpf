<?php session_start();
$pageTitle = "All Admissions Detailed Report";
require_once('connection.php');
require_once('sessionSet.php');
?>
<!DOCTYPE html>
<html>
<?php include('Head.php'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include('topNav.php') ?>
        <?php include('sidebar.php') ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Duplicate Admissions Review</h1>
                            <p class="text-muted">Listing individual admission records only for students with more than one entry.</p>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-copy mr-1"></i> Conflict Review List</h3>
                            <div class="card-tools">
                                <span class="badge badge-warning">Audit Mode Active</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-striped table-hover" id="allAdmissionsTable">
                                <thead>
                                    <tr>
                                        <th>Reg No</th>
                                        <th>Voucher No</th>
                                        <th>Student Name</th>
                                        <th>CNIC</th>
                                        <th>School Branch</th>
                                        <th>Course</th>
                                        <th>Adm. Date</th>
                                        <th>Fee (PKR)</th>
                                        <th>Database Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include('footer.php') ?>
    </div>

    <?php include('footerPlugins.php') ?>
    <!-- Ensure DataTables is loaded -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#allAdmissionsTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "all_admissions_ajax.php",
                    "type": "POST"
                },
                "columns": [
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "12%" },
                    { "width": "12%" },
                    { "width": "12%" },
                    { "width": "12%" },
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "12%" }
                ],
                "order": [[5, "desc"]], // Default sort by date
                "pageLength": 25,
                "responsive": true,
                "language": {
                    "processing": "<div class='overlay'><i class='fas fa-2x fa-sync-alt fa-spin'></i></div>"
                }
            });
        });
    </script>
    <style>
        .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
        #allAdmissionsTable_processing {
            background: none;
            border: none;
            box-shadow: none;
        }
    </style>
</body>
</html>
