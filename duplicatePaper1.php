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
                            <h1 class="m-0 text-dark">Test Review</h1>
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
                                    <?php
    if(isset($_GET['sessionID']) && isset($_GET['candidateID']) )
                                    {
                                        $sessionID =  $_GET['sessionID'];
                                        $candidateID =  $_GET['candidateID'];
        echo $candidateID;
                                        $userDataQ = "select * from candidates where id='$candidateID'";
                                        $userDataQR = mysqli_query($con,$userDataQ);
                                        $userDataRow = mysqli_fetch_assoc($userDataQR);
                                        $candidateName=$userDataRow['name'];
                                        $candidateCNIC = $userDataRow['cnic'];
                                        $candidateTestDate = $userDataRow['entrydate'];
                                    }   
    //date_default_timezone_set("Asia/Karachi");
    //$todayDate= date("d-m-Y h:ia");
                                    ?>
                                    <h3 class="card-title"><?php echo "CNIC: <b>". $candidateCNIC. "</b> Name : <b>".$candidateName."</b> Token # : <b>".$candidateToken."</b> DateTime : <b>".$candidateTestDate."</b>" ;?></h3>
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


                                                                    $GetStockQ = "SELECT * FROM useranswers_permanent where sess_id='$sessionID'";

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
                                                            "no result found";
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
