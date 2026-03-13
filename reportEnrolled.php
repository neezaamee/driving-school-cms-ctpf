<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<!-- Only Admin Can View This Page-->
<?php
if (isDEO()){
    ?>
<script>
    setTimeout(function() {
        alert("you are not authorized to view this page");
        window.location.href = 'index.php';
    });

</script>
<?php
    }
?>
<!-- Only Admin Can View This Page-->
<!--/ PHP Code: Token Entery -->
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->

<head>
    <title>
        <?php echo "Students Enrolled in ".date("F");?>
    </title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
</head>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRow
                }
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
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
                            <h1 class="m-0 text-dark">Students Enrolled</h1>
                        </div>
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
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo "Students Enrolled in ".date("F");?></h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- Questions Div -->
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="View All Questions">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="card-body" style="overflow-x:auto;">
                                                    <table id="myTable" class="display" style="width:100%; text-align: center;">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <?php
                                                                if (isAdmin()){
                                                                    ?>
                                                                <th>School</th>

                                                                <?php
                                                                }
                                                                ?>
                                                                <th>Name</th>
                                                                <th>Guardian</th>
                                                                <th>CNIC</th>
                                                                <th>Registration</th>
                                                                <th>Course</th>
                                                                <th>Admission Date</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                    $Serial=0;
                                                                    $todayDate= date("Y-m-d");

                                                                    /*fetch passed candidates from database*/
                                                                    $currentMonth= date("m");
                                                                    $currentYear = date('Y');
                                                                    if(isAdmin()){
                                                                    $GetStockQ = "SELECT * FROM `admissions` WHERE MONTH(created_at) = '$currentMonth' AND YEAR(created_at)= '$currentYear'";
                                                                    }
                                                                    else{                                            

                                                                    $GetStockQ = "SELECT * FROM `admissions` WHERE MONTH(created_at) = '$currentMonth' AND YEAR(created_at)= '$currentYear' AND idschool = '$userSchoolID'";
                                                                    }

                                                                     $GetStockQR = mysqli_query($con,$GetStockQ);

                                                                     $GetStockNR = mysqli_num_rows($GetStockQR);

                     if($GetStockNR>0)
                     {
                         while($GetStockRow = mysqli_fetch_assoc($GetStockQR))
                         {

                             $Serial++;
                             $admissionID=$GetStockRow['id'];
                             $studentID=$GetStockRow['idstudent'];
                             $courseID = $GetStockRow['idcourse'];
                             $Course = courseByID($courseID);
                             $courseName = $Course->coursename;
                             $Registration = $GetStockRow['registration'];
                             $schoolID = $GetStockRow['idschool'];
                             $School = schoolByiD($schoolID);
                             $schoolName = $School->location;

                             $admissionDate = $GetStockRow['admissiondate'];
                             $startDate = $GetStockRow['startdate'];
                             $endDate = $GetStockRow['enddate'];

                             //function candidateByID defined in Functions.php
                            $Student = studentByID($studentID);
                            $name = $Student->fullname;
                            $fathername = $Student->fathername;
                            $cnic = $Student->cnic;
                        ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $Serial ?>
                                                                </td>
                                                                <?php
                                                                if(isAdmin()){
                                                                    ?>
                                                                <td>
                                                                    <?php echo $schoolName; ?>
                                                                </td>
                                                                <?php
                                                                }
                                                                ?>
                                                                <td>
                                                                    <?php echo $name ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $fathername; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $cnic; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $Registration; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $courseName; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $admissionDate; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $startDate; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $endDate; ?>
                                                                </td>

                                                            </tr>
                                                            <?php
                            }
                     }
                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No.</th>
                                                                <?php
                                                                if (isAdmin()){
                                                                    ?>
                                                                <th>School</th>

                                                                <?php
                                                                }
                                                                ?>
                                                                <th>Name</th>
                                                                <th>Guardian</th>
                                                                <th>CNIC</th>
                                                                <th>Registration</th>
                                                                <th>Course</th>
                                                                <th>Admission Date</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                                <!-- /.card -->
                                            </div>
                                        </div>
                                        <!--/tab-pane-->
                                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="Add New Question">
                                            <h3>Add New Question Place here</h3>
                                            <div>
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
                                                        <div class="form-row">
                                                            <div class="form-group col">
                                                                <label for="correctOption">Correct Image</label>
                                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                    <label class="btn btn-default text-center">
                                                                        <input type="radio" name="correctopt" value="opt1"> <span class="text-xl">1</span> </label>
                                                                    <label class="btn btn-default text-center">
                                                                        <input type="radio" name="correctopt" value="opt2"> <span class="text-xl">2</span> </label>
                                                                    <label class="btn btn-default text-center">
                                                                        <input type="radio" name="correctopt" value="opt3"> <span class="text-xl">3</span> </label>
                                                                    <label class="btn btn-default text-center active">
                                                                        <input type="radio" name="correctopt" value="opt4"> <span class="text-xl">4</span> </label>
                                                                </div>
                                                                <div class="invalid-feedback"> Please Select Correct Option </div>
                                                                <div class="valid-feedback"> Looks good! </div>
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
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
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
