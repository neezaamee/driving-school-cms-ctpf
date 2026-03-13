<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
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
                            <h1 class="m-0 text-dark">Duplicate Receipt</h1>
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
                                    <h3 class="card-title">Duplicate Receipt Print Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- PHP Code: Fetch Candidate Token Data -->
                                <?php
                        if(isset($_POST['submit']))
                        {
                            
                            $Registration = CleanData($_POST['registration']);
                            $Admission = admissionByRegistration($Registration);
                            
	                       if($Admission)
	                           {
                               
                               $admissionID = $Admission->idadmission;
                               $admissionDate = $Admission->admissiondate;
                               $admissionDate = new DateTime($admissionDate);
                               $admissionDate = $admissionDate->format('d/m/Y');
                               $studentID = $Admission->idstudent;
                               $Student = studentByID($studentID);
                               $fullName = $Student->fullname;
                               $guardianName = $Student->fathername;
                               $DOB = $Student->dob;
                               $date = new DateTime($DOB);
                               $DOB = $date->format('d/m/Y');
                               $CNIC = $Student->cnic;
                               $Gender = $Student->gender;
                               $Phone = $Student->phone;
                               $Email = $Student->email;
                               $BloodGroup = $Student->blood;
                               $Time = $Student->time;
                               $feePaid = $Admission->paidfee;
                               $Address = $Student->address;
                               $courseID = $Admission->idcourse;
                            $Course = courseByID($courseID);
                            $courseName = $Course->coursename;
                            $pickndrop = $Admission->pickndrop;
                            $schoolID = $Admission->idschool;
                            $studentID = $Admission->idstudent;
                            $School = schoolByID($schoolID);
                            $schoolName = $School->location;
                            $Student = studentByID($studentID);
                            $studentName = $Student->fullname;
                            $studentFatherName = $Student->fathername;
                               
                                      ?>
                                <!--Token Table-->
                                <div class="printToken">
                                    <table class="table table-bordered">
                                        <th colspan="2" class="text-center">Fee Receipt - Student Copy<br><?php echo "Driving School ".$schoolName; ?> <br>City Traffic Police Faisalabad</th>
                                        <tr>
                                            <th>Admission Date:</th>
                                            <td>
                                                <?php echo $admissionDate; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Registration #:</th>
                                            <td>
                                                <?php echo $Registration;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Name:</th>
                                            <td>
                                                <?php echo $fullName;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Guardian Name:</th>
                                            <td>
                                                <?php echo $guardianName;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Course:</th>
                                            <td>
                                                <?php echo $courseName;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pick n Drop:</th>
                                            <td>
                                                <?php
        if ($pickndrop == 1000){
            $pickndrop = "Availed";
        }else{
            $pickndrop = "Not Availed";
        }
        echo $pickndrop;
        ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Fee Paid:</th>
                                            <td>
                                                <?php echo $feePaid;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-center" style="height: 90px;">Received By</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-center">Developed by: IT Branch CTPF</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">---------------------------------------------------------------------------</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center"></td>
                                        </tr>
                                        <th colspan="2" class="text-center">Fee Receipt - Office Copy<br><?php echo "Driving School ".$schoolName; ?> <br>City Traffic Police Faisalabad</th>
                                        <tr>
                                            <th>Admission Date:</th>
                                            <td>
                                                <?php echo $admissionDate; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Registration #:</th>
                                            <td>
                                                <?php echo $Registration;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Name:</th>
                                            <td>
                                                <?php echo $studentName;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Guardian Name:</th>
                                            <td>
                                                <?php echo $studentFatherName;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Course:</th>
                                            <td>
                                                <?php echo $courseName;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pick n Drop:</th>
                                            <td>
                                                <?php
        if ($pickndrop = 1000){
            $pickndrop = "Availed";
        }else{
            $pickndrop = "Not Availed";
        }
        echo $pickndrop;
        ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Fee Paid:</th>
                                            <td>
                                                <?php echo $feePaid;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-center" style="height: 90px;">Received By</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-center">Developed by: IT Branch CTPF</th>
                                        </tr>
                                    </table>
                                </div>
                                <!--/Token Table-->

                                <?php 
                                
	                           }
	                           else
	                           {
		                          ?>
                                <script>
                                    alert('Token Not Found for today');
                                    window.location = "editStudent.php";

                                </script>
                                <?php
                                }

                        }else{
                           ?>
                                <!-- form start -->
                                <form class="needs-validation" role="form" method="post" action="duplicateReceipt.php" novalidate>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="InputFullName">Registration #</label>
                                                <input type="text" class="form-control" id="InputFullName" name="registration">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                    </div>
                                    <!--/.card-footer-->
                                </form>
                                <?php 
                        }
                            
                        ?>
                                <!--/ PHP Code: Token Entery -->

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
</body>
<!--/Body-->

</html>
