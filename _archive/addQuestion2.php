<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php'); ?>
<!--/Head-->

<head>
    <style>
        label.btn.btn-default.text-center.focus.active {
            background: black !important;
            color: white !important;
        }

    </style>
    <!--<link rel="stylesheet" href="plugins/toastr/toastr.min.css">-->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
</head>
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
                            <h1 class="m-0 text-dark">Add New Question</h1>
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
                                    <h3 class="card-title">Add Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <div>
                                    <link href="styles.css" rel="stylesheet" type="text/css" />
                                    <script type="text/javascript">
                                        $(document).ready(function(e) {
                                            $("#uploadForm").on('submit', (function(e) {
                                                e.preventDefault();
                                                $.ajax({
                                                    url: "uploadQuestion.php",
                                                    type: "POST",
                                                    data: new FormData(this),
                                                    contentType: false,
                                                    cache: false,
                                                    processData: false,
                                                    success: function(data) {
                                                        //alert(data);
                                                        //document.getElementById("uploadForm").reset();
                                                        /*toastr.options = {
                                                            "closeButton": false,
                                                            "debug": false,
                                                            "newestOnTop": false,
                                                            "progressBar": false,
                                                            "positionClass": "toast-top-right",
                                                            "preventDuplicates": false,
                                                            "onclick": null,
                                                            "showDuration": "300",
                                                            "hideDuration": "1000",
                                                            "timeOut": "3000",
                                                            "extendedTimeOut": "1000",
                                                            "showEasing": "swing",
                                                            "hideEasing": "linear",
                                                            "showMethod": "fadeIn",
                                                            "hideMethod": "fadeOut"
                                                        }
                                                        toastr["success"]("Question Added", "Success");
                                                        */
                                                        const Toast = Swal.mixin({
                                                            toast: false,
                                                            position: 'center',
                                                            showConfirmButton: false,
                                                            timer: 3000,
                                                        })
                                                        Toast.fire({
                                                            type: 'success',
                                                            title: 'Your work has been saved'
                                                        })
                                                        setTimeout(location.reload.bind(location), 4000);

                                                        //location.reload();
                                                    },
                                                    error: function() {}
                                                });
                                            }));
                                        });

                                    </script>
                                    <!-- Upload Question Form -->
                                    <form class="needs-validation" id="uploadForm" role="form" method="post" action="uploadQuestion.php" enctype="multipart/form-data" novalidate>
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="questionImage">Question Image</label>
                                                    <input type="file" class="form-control" id="questionImage" placeholder="Question should be an image" name="questionImage" required> <small id="passwordHelpBlock" class="text-muted">
                                                        Question should be an image.
                                                    </small>
                                                    <div class="invalid-feedback"> Please Select Question Image </div>
                                                    <div class="valid-feedback"> Looks good! </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="Ans1">Answer 1 Image</label>
                                                    <input type="file" class="form-control" id="Ans1" name="Ans1" required> <small id="passwordHelpBlock" class="text-muted">
                                                        Answer should be an image.
                                                    </small>
                                                    <div class="invalid-feedback"> Answer should be an image. </div>
                                                    <div class="valid-feedback"> Looks good! </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="Ans2">Answer 2 Image</label>
                                                    <input type="file" class="form-control" id="Ans2" name="Ans2" required> <small id="passwordHelpBlock" class="text-muted">
                                                        Answer should be an image.
                                                    </small>
                                                    <div class="invalid-feedback"> Answer should be an image. </div>
                                                    <div class="valid-feedback"> Looks good! </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="Ans3">Answer 3 Image</label>
                                                    <input type="file" class="form-control" id="Ans3" name="Ans3" required> <small id="passwordHelpBlock" class="text-muted">
                                                        Answer should be an image.
                                                    </small>
                                                    <div class="invalid-feedback"> Answer should be an image. </div>
                                                    <div class="valid-feedback"> Looks good! </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="Ans4">Answer 4 Image</label>
                                                    <input type="file" class="form-control" id="Ans4" name="Ans4" required> <small id="passwordHelpBlock" class="text-muted">
                                                        Answer should be an image.
                                                    </small>
                                                    <div class="invalid-feedback"> Answer should be an image. </div>
                                                    <div class="valid-feedback"> Looks good! </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="Ans4">Audio</label>
                                                    <input type="file" class="form-control" id="audioQ" name="audio" required> <small id="passwordHelpBlock" class="text-muted">
                                                        Select Question Audio
                                                    </small>
                                                    <div class="invalid-feedback"> Its not correct file. </div>
                                                    <div class="valid-feedback"> Looks good! </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="CheckBox">CheckBox</label>
                                                    <input type="checkbox" class="form-control" id="checkbox" name="bike" value="bike" style="margin-left: -165px"> <small id="passwordHelpBlock" class="text-muted">
                                                        Check if the question is only for Bike
                                                    </small> </div>
                                            </div>
                                            <div id="radio">
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="correctOption">Correct Ans</label>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-default text-center">
                                                                <input type="radio" name="correctopt" value="opt1"> <span class="text-md">1</span> </label>
                                                            <label class="btn btn-default text-center">
                                                                <input type="radio" name="correctopt" value="opt2"> <span class="text-md">2</span> </label>
                                                            <label class="btn btn-default text-center">
                                                                <input type="radio" name="correctopt" value="opt3"> <span class="text-md">3</span> </label>
                                                            <label class="btn btn-default text-center active">
                                                                <input type="radio" name="correctopt" value="opt4"> <span class="text-md">4</span> </label>
                                                        </div>
                                                        <div class="invalid-feedback"> Please Select Correct Option </div>
                                                        <div class="valid-feedback"> Looks good! </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                        </div>
                                        <!--/.card-footer-->
                                    </form>
                                    <!--/ Upload Question Form -->

                                </div>
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
        <!--Footer Content-->
        <?php include ('footer.php')?>
        <!--/Footer Content-->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include ('footerPlugins.php')?>
    <!--<script src="plugins/toastr/toastr.min.js"></script>-->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
<!--/Body-->

</html>
