<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
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
                                    <h3 class="card-title">Road Test </h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- PHP Code: Fetch Candidate Token Data -->
                                <?php
                        
                    if(isset($_POST['roadTest']))
                        {
                            
                            $candidateToken = CleanData($_POST['candidateToken']);
                            $candidateRoadTestResult = CleanData($_POST['roadResult']);
                            
                        $testID = CleanData($_POST['testid']);                           
    
                        
                            $fetchCandidateDataQ = "SELECT * FROM tests WHERE id = '$testID'";
                            $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);
	
	                       $fetchCandidateDataNum = mysqli_num_rows($fetchCandidateDataQR);
	                       
	                       if($fetchCandidateDataNum>0)
	                           {
                                   $updateRoadTestResultQ = "UPDATE tests SET roadtest='$candidateRoadTestResult' WHERE id='$testID'";
                               $updateRoadTestResultQR = mysqli_query($con,$updateRoadTestResultQ);
                               if($updateRoadTestResultQR){
                                   $finalResultQ = "SELECT * FROM tests WHERE id = '$testID'";
                                   $finalResultQR = mysqli_query($con,$finalResultQ);
	
                               $finalResultDataObject = mysqli_fetch_object($finalResultQR);
                                   $signTestResult = $finalResultDataObject->signtest;
                                   $roadTestResult = $finalResultDataObject->roadtest;
                               if(($signTestResult == "Pass") && ($roadTestResult == "Pass"))
                               {
                                   $finalResult = "Pass";
                                   
                               }elseif($roadTestResult == "Fail")
                               {
                                   $finalResult = "Fail";
                               }
                               else{
                                   $finalResult = "Absent";
                               }
                               $updateFinalResultQ = "UPDATE tests SET finalresult='$finalResult' WHERE id='$testID'";
                               $updateFinalResultQR = mysqli_query($con,$updateFinalResultQ);
                               if($updateFinalResultQR){
                                   //echo "<center><h3>result update ho chuka hai</h3></center>";
                                  ?>
                                <script>
                                    alert("result update ho chuka hai");

                                </script>
                                <?php 
                               }
                           
                               }
                                  
                                ?>
                                <script>
                                    alert("Road Test Result Updated");
                                    window.location.href = 'printRoadTestResult.php';

                                </script>
                                <?php
		
	                           }
	                           else
	                           {
		                          ?>
                                <script>
                                    alert('Something Wrong: Try Again');

                                </script>
                                <?php
                                }

                        }
                        if(isset($_POST['submitRoadTest']))
                        {
                            
                            $candidateToken = CleanData($_POST['candidateToken']);
                            $candidateID = CleanData($_POST['candidateID']);
                            $roadTestResult = CleanData($_POST['roadResult']);
                            $signTestResult = "Fail";
                            $finalResult = "Fail";
                            if($roadTestResult == "Pass"){
                                $signTestResult = "Absent";
                                $finalResult = "Absent";

                            }                    
                            
                            $q = "insert into tests(candidateid,signtest,roadtest,finalresult) values ('$candidateID','$signTestResult','$roadTestResult','$finalResult')";
                            $result = mysqli_query($con,$q);
        if($result){
            ?>
                                <script>
                                    alert("Road Test Result Updated");
                                    window.location.href = 'printRoadTestResult.php';

                                </script>
                                <?php
        }else{
            echo "error";
        }

                        }
                            
                        ?>
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
