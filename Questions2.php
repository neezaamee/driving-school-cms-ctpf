<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
extract($_POST);
extract($_GET);
extract($_SESSION);
?>
    <!-- Only Admin Can Add User-->
    <?php
if ($_SESSION['loginRole'] !== 'Admin') {
    ?>
        <script>
            setTimeout(function () {
                window.location.href = 'index.php';
            });
        </script>
        <?php
    }
?>
            <?php
if ($_SESSION['loginRole'] == 'DEO') {
    ?>
                <script>
                    function myFunction() {
                        var x = document.getElementsByClassName("DEOHIDE");
                        var i;
                        for (i = 0; i < x.length; i++) {
                            x[i].style.display = "none";
                        }
                    }
                </script>
                <?php
    }
?>
                    <?php
if ($_SESSION['loginRole'] == 'Sign Tester') {
    ?>
                        <script>
                            function myFunction() {
                                var x = document.getElementsByClassName("SIGNTESTERHIDE");
                                var i;
                                for (i = 0; i < x.length; i++) {
                                    x[i].style.display = "none";
                                }
                            }
                        </script>
                        <?php
    }
?>
                            <!--/ PHP Code: Token Entery -->
                            <!DOCTYPE html>
                            <html>
                            <!--Head-->
                            <?php include('Head.php')?>
                                <style>
                                    img {
                                        width: 100%;
                                        height: 150px;
                                    }
                                    
                                    .qans {
                                        width: 100%;
                                        height: 75px;
                                    }
                                </style>
                                <!--/Head-->
                                <script>
                                    $(function () {
                                        $("#radio").buttonset();
                                    });
                                </script>
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
                                                                    <h1 class="m-0 text-dark">Dashboard</h1> </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                        <!-- /.container-fluid -->
                                                    </div>
                                                    <!-- /.content-header -->
                                                    <!-- Main content -->
                                                    <a href="https://ctpfsd.gop.pk/Signal/PDF/Highway_Code_Book.pdf"></a>
                                                    <section class="content">
                                                        <div class="container-fluid">
                                                            <!-- Small boxes (Stat box) -->
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <!-- general form elements -->
                                                                    <div class="card card-primary">
                                                                        <div class="card-header p-0 pt-1">
                                                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                                                <li class="nav-item"> <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">View All</a> </li>
                                                                                <li class="nav-item"> <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Add New</a> </li>
                                                                            </ul>
                                                                        </div>
                                                                        <!-- /.card-header -->
                                                                        <!-- Questions Div -->
                                                                        <div class="card-body">
                                                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                                                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="View All Questions">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                        <table id="example1" class="table table-bordered table-striped">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sr No.</th>
                                                                                                    <th>Question</th>
                                                                                                    <th>Option 1</th>
                                                                                                    <th>Option 2</th>
                                                                                                    <th>Option 3</th>
                                                                                                    <th>Option 4</th>
                                                                                                    <th>Correct Option</th>
                                                                                                    <th>Action</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <!--fetch all questions-->
                                                                                                <?php
                                                                    $Serial=0;

                                                                    $GetStockQ = "SELECT * FROM questions";

                                                                     $GetStockQR = mysqli_query($con,$GetStockQ);

                                                                     $GetStockNR = mysqli_num_rows($GetStockQR);

                                                                     if($GetStockNR>0)
                                                                     {
                                                                         while($GetStockRow = mysqli_fetch_assoc($GetStockQR))
                                                                         {

                                                                             $Serial++;
                                                                             $questionID=$GetStockRow['id'];
                                                                             $questionText=$GetStockRow['questiontext'];
                                                                             $opt1 = $GetStockRow['opt1'];
                                                                             $opt2 = $GetStockRow['opt2'];
                                                                             $opt3 = $GetStockRow['opt3'];
                                                                             $opt4 = $GetStockRow['opt4'];
                                                                             $correctOpt = $GetStockRow['correctopt'];

                                                                ?>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <?php echo $Serial ?>
                                                                                                        </td>
                                                                                                        <td> <img src="<?php echo $questionText; ?>" alt="" width="100%"> </td>
                                                                                                        <td> <img class="qans" src="<?php echo $opt1; ?>" alt="" width="100%"> </td>
                                                                                                        <td> <img class="qans" src="<?php echo $opt2; ?>" alt="" width="100%"> </td>
                                                                                                        <td> <img class="qans" src="<?php echo $opt3; ?>" alt="" width="100%"> </td>
                                                                                                        <td> <img class="qans" src="<?php echo $opt4; ?>" alt="" width="100%"> </td>
                                                                                                        <td>
                                                                                                            <?php echo $correctOpt; ?>
                                                                                                        </td>
                                                                                                        <!--td> <a class="btn btn-block btn-outline-primary" href="editUser.php?userID=<?php/* echo $questionID;*/ ?>"> Edit</a> </td-->
                                                                                                        <td>
                                                                                                            <button class="btn btn-block btn-outline-danger" data-href="deleteUser.php?userID=<?php echo $userID; ?>" data-toggle="modal" data-target="#confirm-delete"> Delete</button>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <?php
                            }//while loop ends here
                     }//if ends here
                                
                            ?>
                                                                                            </tbody>
                                                                                            <!--/fetch all questions-->
                                                                                            <tfoot>
                                                                                                <tr>
                                                                                                    <th>Sr No.</th>
                                                                                                    <th>Question</th>
                                                                                                    <th>Option 1</th>
                                                                                                    <th>Option 2</th>
                                                                                                    <th>Option 3</th>
                                                                                                    <th>Option 4</th>
                                                                                                    <th>Correct Option</th>
                                                                                                    <th>Action</th>
                                                                                                </tr>
                                                                                            </tfoot>
                                                                                        </table>
                                                                                        <!-- /.card-body -->
                                                                                        <!-- /.card -->
                                                                                    </div>
                                                                                </div>
                                                                                <!--/tab-pane-->
                                                                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="Add New Question">
                                                                                    <h3>Add New Question Place here</h3>
                                                                                    <div>
                                                                                        <link href="styles.css" rel="stylesheet" type="text/css" />
                                                                                        <script type="text/javascript">
                                                                                            $(document).ready(function (e) {
                                                                                                $("#uploadForm").on('submit', (function (e) {
                                                                                                    e.preventDefault();
                                                                                                    $.ajax({
                                                                                                        url: "upload.php"
                                                                                                        , type: "POST"
                                                                                                        , data: new FormData(this)
                                                                                                        , contentType: false
                                                                                                        , cache: false
                                                                                                        , processData: false
                                                                                                        , success: function (data) {
                                                                                                            alert(data);
                                                                                                            //document.getElementById("uploadForm").reset();
                                                                                                            location.reload();
                                                                                                        }
                                                                                                        , error: function () {}
                                                                                                    });
                                                                                                }));
                                                                                            });
                                                                                        </script>
                                                                                        <!-- Upload Question Form -->
                                                                                        <form class="needs-validation" id="uploadForm" role="form" method="post" action="upload.php" enctype="multipart/form-data" novalidate>
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
                                                                                                </div>
                                                                                                <div id="radio">
                                                                                                    <div class="form-row">
                                                                                                        <div class="form-group col">
                                                                                                            <label for="correctOption">Correct Image</label>
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
                                                                                        <!--Upload Question Form-->
                                                                                        <!--<form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                                                    <div id="uploadFormLayer">
                                                        <label>Question</label>
                                                        <input name="qImage" type="file" class="inputFile" />
                                                        <br />
                                                        <label for="">Ans1</label>
                                                        <input name="ans1" type="file" class="inputFile" />
                                                        <br />
                                                        <label for="">A2</label>
                                                        <input name="ans2" type="file" class="inputFile" />
                                                        <br />
                                                        <label for="">A3</label>
                                                        <input name="ans3" type="file" class="inputFile" />
                                                        <br />
                                                        <label for="">Correct</label>
                                                        <input name="ans4" type="file" class="inputFile" />
                                                        <br />
                                                        <input type="radio" name="correct" value="opt1"> 1
                                                        <input type="radio" name="correct" value="opt2"> 2
                                                        <input type="radio" name="correct" value="opt3"> 3
                                                        <input type="radio" name="correct" value="opt4"> 4
                                                        <br />
                                                        <input type="submit" name="submit" value="Submit" class="btnSubmit" /> </div>
                                                </form>-->
                                                                                        <!--/ Upload Question Form-->
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
                                                <script>
                                                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                                                    (function () {
                                                        'use strict';
                                                        window.addEventListener('load', function () {
                                                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                                            var forms = document.getElementsByClassName('needs-validation');
                                                            // Loop over them and prevent submission
                                                            var validation = Array.prototype.filter.call(forms, function (form) {
                                                                form.addEventListener('submit', function (event) {
                                                                    if (form.checkValidity() === false) {
                                                                        event.preventDefault();
                                                                        event.stopPropagation();
                                                                    }
                                                                    form.classList.add('was-validated');
                                                                }, false);
                                                            });
                                                        }, false);
                                                    })();
                                                </script>
                                                <!--/validation-->
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
                                </body>
                                <!--/Body-->

                            </html>