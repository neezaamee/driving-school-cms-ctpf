<?php session_start();
$pageTitle = "Student Directory";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<?php
if (isset($_POST['submit'])) {
    $Month = CleanData($_POST['month']);
    $Month1 = date("F", mktime(0, 0, 0, $Month, 10));
} ?>
<!-- Only Admin Can View This Page-->
<?php
/*
if (!isAdmin()){
    ?>
<script>
    setTimeout(function() {
        alert("you are not authorized to view this page");
        window.location.href = 'index.php';
    });

</script>
<?php
    }*/
?>
<!-- Only Admin Can View This Page-->
<!--/ PHP Code: Token Entery -->
<!DOCTYPE html>
<html>
<!--Head-->
    <style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    <style>
        @media print {
            * {
                text-align: center;
            }
        }
    </style>
</head>
<!-- <script>
    var exportOptions = {
        columns: ':visible:not(.not-exported)'
    }
    $(document).ready(function() {
        $('#myTable').DataTable({

            fixedHeader: true,

            pagingType: 'full_numbers',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            dom: 'Bflrtip',
            buttons: [{
                    extend: 'collection',
                    text: 'Options',
                    buttons: [{
                            extend: 'excel',
                            exportOptions: exportOptions
                        },
                        {
                            extend: 'copy',
                            exportOptions: exportOptions
                        },
                        {
                            extend: 'csv',
                            exportOptions: exportOptions
                        },
                        {
                            extend: 'pdf',
                            exportOptions: exportOptions

                        },
                        {
                            extend: 'print',
                            exportOptions: exportOptions
                        }
                    ]

                }, 'colvis'

            ],
            exportOptions: {
                columns: ':visible'
            },
            fade: true,
            export: true,

            columnDefs: [{
                targets: 0,
                visible: true
            }],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRow
                }
            }
        });
    });
</script> -->

<!--Body-->


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('topNav.php') ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include('sidebar.php') ?>
        <!--/ Main Sidebar Container-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Student Directory</h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Students Table</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- Questions Div -->
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="View All Questions">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="card-body">
                                                    <table id="myTable" class="display" style="text-align: center;" class="text-center">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th width="05%">#</th>
                                                                <?php
                                                                if (isAdmin()) {
                                                                ?><th>School</th><?php

                                                                                }
                                                                                    ?>
                                                                <th>Registration</th>
                                                                <th>Admission Date</th>
                                                                <th>Name</th>
                                                                <th>Gender</th>
                                                                <th>Guardian</th>
                                                                <th>DOB</th>
                                                                <th>CNIC</th>
                                                                <th>Address</th>
                                                                <th>Phone</th>
                                                                <th>Course</th>
                                                                <th>Admission Fee</th>
                                                                <th>Fee Concession</th>
                                                                <th>Course Book Fee</th>
                                                                <th>Pick n Drop</th>
                                                                <th>Photo</th>
                                                                <th>Action</th>
                                                                <!--<th data-priority="3" class="all">Final Result</th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                                <!-- /.card -->
                                            </div>
                                        </div>
                                        <!--/tab-pane-->
                                    </div>
                                    <!--/tab-content-->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!--custome validation-->
        <!--/validation-->

        <!--Model for Delete User-->
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"> CTP Faisalabad </div>
                    <div class="modal-body"> want to delete ? </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <a class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Model for Delete User-->
        <!--Footer Content-->
        <?php include('footer.php') ?>
        <!--/Footer Content-->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include('footerPlugins.php') ?>
</body>
<!--/Body-->
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "server_processing.php", // Replace with your server-side processing script URL
                "type": "POST"
            },
            "columns": [{
                    "data": "0"
                }, // Incremental index
                <?php if (isAdmin()) : ?> {
                        "data": "1"
                    }, // School name
                <?php endif; ?> {
                    "data": "2"
                }, // Registration
                {
                    "data": "3"
                }, // Admission date
                // Add more columns as per your table structure
            ],
            // Add other DataTables options as needed
        });
    });
</script>
<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

</html>