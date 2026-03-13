<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
extract($_GET);

?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php')?>
<style>
    .qans {
        padding-top: 15px;
    }

</style>
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
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card">
                                <div class="card-header">
                                    <?php
                                if(isset($_GET['sessionID']) && isset($_GET['candidateID']) )
                                    {
                                        $sessionID =  $_GET['sessionID'];
                                        $candidateID =  $_GET['candidateID'];
                                        //getting Candidate Data against Candidat ID
                                        $Candidate = candidateByID($candidateID);
                                        $candidateName = $Candidate->name;
                                        $candidateCNIC = $Candidate->cnic;
                                        $candidateTestDate = $Candidate->entrydate;
                                        $candidateToken = $Candidate->token;

                                        //getting test data against Candidate ID
                                        $Test = testByCandidateID($candidateID);
                                        $SignTest = $Test['signtest']; 
                                        $RoadTest = $Test['roadtest']; 
                                        $FinalResult = $Test['finalresult']; 
                                        $TotalQuestions = $Test['totalquestions']; 
                                        $NotAnswered = $Test['notanswered']; 
                                        $Right = $Test['totalright']; 
                                        $Wrong = $Test['totalwrong']; 
                                        $TestingOfficer = $Test['testby']; 
                                        $Type = $Test['type'];
                                    }

                                    ?>
                                    <h3 class="card-title"><?php echo "CNIC: <b>". $candidateCNIC. "</b> Name : <b>".$candidateName."</b> Token # : <b>".$candidateToken."</b> DateTime : <b>".$candidateTestDate."</b> Sign Test: <b>".$SignTest."</b> Road Test: <b>".$RoadTest."</b>Test Type: <b>".$Type."</b> Testing Officer: <b>".$TestingOfficer."</b> <br /> Total Questions: <b>".$TotalQuestions."</b> Not Answered: <b>".$NotAnswered."</b> Correct: <b>".$Right."</b> Incorrect: <b>".$Wrong ;?></h3>
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
                                                            <th>User Ans</th>
                                                            <th>Correct Ans</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!--fetch all questions-->
                                                        <?php
                                                                    $Serial=0;
                                                                    $todayDate= date("Y-m-d");


                                                                    $GetStockQ = "SELECT * FROM useranswers_permanent where sess_id='$sessionID' AND candidateid= '$candidateID'";

                                                                     $GetStockQR = mysqli_query($con,$GetStockQ);

                                                                     $GetStockNR = mysqli_num_rows($GetStockQR);

                                                                     if($GetStockNR>0)
                                                                     {
                                                                         while($GetStockRow = mysqli_fetch_assoc($GetStockQR))
                                                                         {

                                                                             $Serial++;
                                                                             $questionID=$GetStockRow['id'];
                                                                             $questionText=$GetStockRow['que_des'];
                                                                             $opt1 = $GetStockRow['ans1'];
                                                                             $opt2 = $GetStockRow['ans2'];
                                                                             $opt3 = $GetStockRow['ans3'];
                                                                             $opt4 = $GetStockRow['ans4'];
                                                                             $userOpt = $GetStockRow['useropt'];
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
                                                                <?php echo $userOpt; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $correctOpt; ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                                    }//while loop ends here
                                                                }//if ends here
                                                        else{
                                                            "No Result Found";
                                                            }
                                
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
                                                            <th>User Ans</th>
                                                            <th>Correct Ans</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
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
