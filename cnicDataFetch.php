<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
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
                            <h1 class="m-0 text-dark">Duplicate Test Paper</h1>
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
                                    <h3 class="card-title">Duplicate Test Paper</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- Questions Div -->
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="View All Questions">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="card-body">
                                                    <!-- PHP Code: Fetch Candidate Token Data -->
                                                    <?php
                        if(isset($_POST['submit']))
                        {
                            
                            $candidateCNIC = CleanData($_POST['cnicData']);
                            //matching cnic for finding test record
                            $fetchCandidateDataQ = "SELECT * FROM candidates WHERE cnic = '$candidateCNIC'";
                            $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);
	
	                       $fetchCandidateDataNum = mysqli_num_rows($fetchCandidateDataQR);
                            $Serial = 0;
	                       
	                       if($fetchCandidateDataNum>0)
	                           {
                               ?>
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No.</th>
                                                                <th>Candidate Token</th>
                                                                <th>License Category</th>
                                                                <th>Total Questions</th>
                                                                <th>Not Answered</th>
                                                                <th>Right</th>
                                                                <th>Wrong</th>
                                                                <th>Entry Date</th>
                                                                <th>Sign Test</th>
                                                                <th>Road Test</th>
                                                                <th>Final Result</th>
                                                                <th>Testing Officer</th>
                                                                <th>Test Paper</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                               while($candidateDataObject = mysqli_fetch_object($fetchCandidateDataQR)){
                                   $Serial++;
                                   $candidateID = $candidateDataObject->id;
                                   $candidateToken = $candidateDataObject->token;
                                   $candidateLicenseCategory = $candidateDataObject->liccat;
                                   $candidateEntryDate = $candidateDataObject->entrydate;
                                   $fetchCandidateTestDataQ="SELECT * FROM tests WHERE candidateid = '$candidateID'";
                                $fetchCandidateTestDataQR = mysqli_query($con,$fetchCandidateTestDataQ);	
	                           $fetchCandidateTestDataNum = mysqli_num_rows($fetchCandidateTestDataQR);
	                       
	                       if($fetchCandidateTestDataNum>0){
                            $candidateTestDataObject = mysqli_fetch_object($fetchCandidateTestDataQR);
                               $sessionID = $candidateTestDataObject->session_id;
                               $totalQuestions = $candidateTestDataObject->totalquestions;
                               $notAnswered = $candidateTestDataObject->notanswered;
                               $Right = $candidateTestDataObject->totalright;
                               $Wrong = $candidateTestDataObject->totalwrong;
                               $testDate = $candidateTestDataObject->testdate;
                               $signTest = $candidateTestDataObject->signtest;
                               $roadTest = $candidateTestDataObject->roadtest;
                               $finalResult = $candidateTestDataObject->finalresult;
                               $testingOfficer = $candidateTestDataObject->testby;
                            
                           }else{
                               $sessionID="N/A";
                               $totalQuestions = "N/A";
                               $notAnswered = "N/A";
                               $Right = "N/A";
                               $Wrong = "N/A";
                               $testDate ="N/A";
                               $signTest = "N/A";
                               $roadTest = "N/A";
                               $finalResult = "N/A";
                               $testingOfficer = "N/A";
                           }
                               
                               
                                   /*$candidateDataObject = mysqli_fetch_object($fetchCandidateDataQR);
                                   $candidateID = $candidateDataObject->id;
                                //finding test record
                                //$fetchCandidateTestDataQ = "SELECT * FROM tests WHERE candidateid = '$candidateID' ORDER BY testdate DESC";
                                $fetchCandidateTestDataQ = "SELECT * FROM tests WHERE candidateid = '$candidateID'";
                                $fetchCandidateTestDataQR = mysqli_query($con,$fetchCandidateTestDataQ);	
	                           $fetchCandidateTestDataNum = mysqli_num_rows($fetchCandidateTestDataQR);
	                       
	                       if($fetchCandidateTestDataNum>0){
                            $candidateTestDataObject = mysqli_fetch_object($fetchCandidateTestDataQR);
                               $candidateTestDate = $candidateTestDataObject->testdate;*/

                           ?>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $Serial; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $candidateToken; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $candidateLicenseCategory; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $totalQuestions; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $notAnswered; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $Right; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $Wrong; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $candidateEntryDate; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $signTest; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $roadTest; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $finalResult; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $testingOfficer; ?>
                                                                </td>
                                                                <td> <a class="btn btn-block btn-outline-primary" href="duplicatePaper.php?sessionID=<?php echo $sessionID; ?>&candidateID=<?php echo $candidateID; ?>"> Click Here</a> </td>
                                                            </tr>
                                                        </tbody>
                                                        <!--/fetch all questions-->
                                                        <?php
                            }//while loop ends here
                                                                         ?>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Sr No.</th>
                                                                <th>Candidate Token</th>
                                                                <th>License Category</th>
                                                                <th>Total Questions</th>
                                                                <th>Not Answered</th>
                                                                <th>Right</th>
                                                                <th>Wrong</th>
                                                                <th>Entry Date</th>
                                                                <th>Sign Test</th>
                                                                <th>Road Test</th>
                                                                <th>Final Result</th>
                                                                <th>Testing Officer</th>
                                                                <th>Test Paper</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <?php
                           }//ends row finds
                            else
	                           {
		                          echo "No Record Found";
                                }
                            
		
	                           }//ends form submission IF
	                           
                        ?>
                                                </div>
                                                <!-- /.card-body -->
                                                <!-- /.card -->
                                            </div>
                                        </div>
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
