<?php session_start();
$pageTitle = "Road Test Results";
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php');?>
<!--/Head-->
<!-- PHP Code: Fetch Candidate Token Data -->
<?php
                        if(isset($_POST['submit']))
                        {
                            
                            $candidateToken = CleanData($_POST['tokenForRoadTest']);
                            $todayDate= date("Y-m-d");
                            //candidateByToken() is mentioned in Functions.php
                            $Candidate = candidateByToken($candidateToken, $todayDate);
                            
                            $candidateID = $Candidate->id;
                            $CNIC = $Candidate->cnic;
                            
                            $fetchCandidateDataQ = "SELECT a.id, a.token,a.entrydate,a.cnic,b.id, b.candidateid,b.testdate,b.signtest,b.roadtest,b.finalresult FROM candidates a,tests b WHERE a.id = b.candidateid AND a.token = '$candidateToken' AND a.entrydate = '$todayDate'";
                            $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);
	
	                       $fetchCandidateDataNum = mysqli_num_rows($fetchCandidateDataQR);
	
	                       if($fetchCandidateDataNum>0)
	                           {
                                   $candidateDataObject = mysqli_fetch_object($fetchCandidateDataQR);
                                   $testID = $candidateDataObject->id;
                                   $Token = $candidateDataObject->token;
                                   $CNIC = $candidateDataObject->cnic;
                                   $signTest = $candidateDataObject->signtest;
                                   $roadTest = $candidateDataObject->roadtest;
                                   $finalResult = $candidateDataObject->finalresult;
                               //checking if sign test is failed before
                               if($finalResult == "Fail"){
                                   ?>
<script>
    alert('Candidate is already Failed, Road Test Data can not be entered');
    window.location = 'tokenForRoadTest.php';

</script>
<?php
                               }else{
                               if($roadTest == "Pass" || $roadTest == "Fail" || $roadTest == "Absent"){
                                   ?>
<script>
    alert('Road Test Result Already Updated');
    window.location = 'tokenForRoadTest.php';

</script>
<?php
                               }else{
                                   //showing Candidate Record to update Road Test Result
                                 ?>
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
                            <h1 class="m-0 text-dark">Dashboard</h1>
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
                                    <h3 class="card-title">Enter Candidate Token #</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="needs-validation" role="form" method="post" action="roadTestData.php" novalidate>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="InputToken">Token #</label>
                                                <input type="number" class="form-control" name="candidateToken" id="InputToken" value="<?php echo $candidateToken;?>" readonly> </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="InputToken">CNIC #</label>
                                                <input type="text" class="form-control" name="cnic" id="InputToken" value="<?php echo $CNIC;?>" readonly> </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="InputToken">Sign Test Result</label>
                                                <input type="text" class="form-control" name="signResult" id="InputToken" value="<?php echo $signTest;?>" readonly>
                                                <input type="text" class="form-control" name="testid" id="InputToken" value="<?php echo $testID;?>" hidden> </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="InputResult">Pass / Fail</label>
                                                <select class="form-control" id="InputResult" name="roadResult" required>
                                                    <option value="Pass">Pass</option>
                                                    <option value="Fail">Fail</option>
                                                    <option value="Absent">Absent</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" name="roadTest">Submit</button>
                                    </div>
                                    <!--/.card-footer-->
                                </form>
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
<?php  
                               }
                                   
                               }
                                    
	                           }
	                           else
	                           {
                                   //showing Candidate Record to update Road Test Result
                                   ?>
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
                            <h1 class="m-0 text-dark">Dashboard</h1>
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
                                    <h3 class="card-title">Enter Candidate Token #</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="needs-validation" role="form" method="post" action="roadTestData.php" novalidate>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="InputToken">Token #</label>
                                                <input type="number" class="form-control" name="candidateToken" id="InputToken" value="<?php echo $candidateToken;?>" readonly>
                                                <input type="number" class="form-control" name="candidateID" value="<?php echo $candidateID;?>" hidden> </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="InputToken">CNIC #</label>
                                                <input type="text" class="form-control" name="cnic" id="InputToken" value="<?php echo $CNIC;?>" readonly> </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="InputResult">Pass / Fail</label>
                                                <select class="form-control" id="InputResult" name="roadResult" required>
                                                    <option value="Pass">Pass</option>
                                                    <option value="Fail">Fail</option>
                                                    <option value="Absent">Absent</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" name="submitRoadTest">Submit</button>
                                    </div>
                                    <!--/.card-footer-->
                                </form>
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

<?php
                                   
                                }
                            

                        }

                        ?>


</html>
