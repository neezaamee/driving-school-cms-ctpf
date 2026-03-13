<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
<!-- PHP Code: Fetch Candidate Token Data -->
<?php
                        if(isset($_POST['submit']))
                        {
                            
                            $candidateToken = CleanData($_POST['tokenfortest']);
                            $todayDate= date("Y-m-d");
                        
                            $fetchCandidateDataQ = "SELECT * FROM candidates WHERE token='$candidateToken' AND DATE(entrydate)='$todayDate'";
                            $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);
	
	                       $fetchCandidateDataNum = mysqli_num_rows($fetchCandidateDataQR);
	
	                       if($fetchCandidateDataNum>0)
	                           {
		                          $candidateDataObject = mysqli_fetch_object($fetchCandidateDataQR);

                                    
                                    $candidateID = $candidateDataObject->id;
                                    $fetchCandidateTestDataQ = "SELECT * FROM tests WHERE candidateid='$candidateID' AND DATE(testdate)='$todayDate'";
                                    $fetchCandidateTestDataQR = mysqli_query($con,$fetchCandidateTestDataQ);
                                    $fetchCandidateTestDataNum = mysqli_num_rows($fetchCandidateTestDataQR);
                               
                                    if($fetchCandidateTestDataNum > 0){
                                        ?>
<script>
    alert("duplicate data found");
    window.location.href = 'tokenfortest.php';

</script>
<?php
                                    }
                               else{
                                   
                               
	
                                    $_SESSION['candidateID'] = $candidateDataObject->id;
                                    $_SESSION['candidateName'] = $candidateDataObject->name;
                                    $_SESSION['candidateToken'] = $candidateDataObject->token;
                                    $_SESSION['candidateCNIC'] = $candidateDataObject->cnic;
                                    $_SESSION['candidateLearnerPermitNo'] = $candidateDataObject->lpdate;
                                    $_SESSION['candidateLicenseCategory'] = $candidateDataObject->liccat;
                                    $_SESSION['candidateIsCommercial'] = $candidateDataObject->iscommercial;
                                   }
                                ?>
<script>
    window.location.href = 'takeExam.php';

</script>
<?php
		
	                           }
	                           else
	                           {
		                          ?>
<script>
    alert('Token Not Found for today');

</script>
<?php
                                }

                        }
                            
                        ?>
<!--/ PHP Code: Token Entery -->
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
                                <form class="needs-validation" role="form" method="post" action="reportMonthlyData.php" novalidate>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label for="Month">Select Month</label>
                                                <select class="form-control" id="month" name="month" required>
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">Augast</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
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

</html>
