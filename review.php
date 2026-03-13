<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
extract($_POST);
extract($_GET);
extract($_SESSION);
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php')?>

<head>
    <title> Test Review </title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    <style>
        /*@media print { html, body { height: auto; } td { margin: 0; padding: 5px 5px; } }*/

    </style>
</head>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRow
                }
            },
            "paging": false,
            "searching": false
        });
    });

</script>
<style>
    td {
        vertical-align: middle !important;
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
            <a href="https://ctpfsd.gop.pk/Signal/PDF/Highway_Code_Book.pdf"></a>
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <?php 
    date_default_timezone_set("Asia/Karachi");
    $todayDate= date("d-m-Y h:ia");
                                    ?>
                                    <h3 class="card-title"><?php echo "CNIC: <b>". $candidateCNIC. "</b> Name : <b>".$candidateName."</b> Token # : <b>".$candidateToken."</b> DateTime : <b>".$todayDate."</b> Testing Officer :<b> ".$_SESSION['loginUserName']."</b>" ;?></h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- Questions Div -->
                                <div class="card-body">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <table id="myTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center class=" text-center "">No.</th>
                                                    <th class="text-center class=" text-center "">Question</th>
                                                    <th class="text-center class=" text-center "">Opt 1</th>
                                                    <th class="text-center class=" text-center "">Opt 2</th>
                                                    <th class="text-center class=" text-center "">Opt 3</th>
                                                    <th class="text-center class=" text-center "">Opt 4</th>
                                                    <th class="text-center class=" text-center "">Candidate Ans</th>
                                                    <th class="text-center class=" text-center "">Correct</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--fetch all questions-->
                                                <?php
                                                                    $Serial=0;
                                                                    $todayDate= date("Y-m-d");


                                                                    $GetStockQ = "SELECT * FROM useranswers where candidateid='$candidateID'";

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
                                                    <td class="text-center">
                                                        <?php echo $Serial ?>
                                                    </td>
                                                    <td> <img src="<?php echo $questionText; ?>" alt="" width="100%"> </td>
                                                    <td> <img class="qans" src="<?php echo $opt1; ?>" alt="" width="100%"> </td>
                                                    <td> <img class="qans" src="<?php echo $opt2; ?>" alt="" width="100%"> </td>
                                                    <td> <img class="qans" src="<?php echo $opt3; ?>" alt="" width="100%"> </td>
                                                    <td> <img class="qans" src="<?php echo $opt4; ?>" alt="" width="100%"> </td>
                                                    <td class="text-center">
                                                        <?php echo $userOpt; ?>
                                                    </td>
                                                    <td class="text-center">
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
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Question</th>
                                                    <th class="text-center">Opt 1</th>
                                                    <th class="text-center">Opt 2</th>
                                                    <th class="text-center">Opt 3</th>
                                                    <th class="text-center">Opt 4</th>
                                                    <th class="text-center">Candidate Ans</th>
                                                    <th class="text-center">Correct</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <!-- /.card-body -->
                                        <!-- /.card -->
                                    </div>
                                    <!--/tab-pane-->
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
