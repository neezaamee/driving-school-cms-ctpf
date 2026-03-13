<?php session_start();
$pageTitle = "Question Bank";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
extract($_POST);
extract($_GET);
extract($_SESSION);
?>
<!-- Only Admin View This Page-->
<?php
if (!isAdmin()){
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
<!--/ PHP Code: Token Entery -->
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php')?>
<style>
    td {
        vertical-align: middle !important;
    }

</style>
<!--/Head-->
<script>
    $(function() {
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
                            <h1 class="m-0 text-dark">Question Bank</h1>
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
                                    <h3 class="card-title">Questions Management</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- Questions Div -->
                                <div class="card-body">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <!--fetch all questions-->
                                        <?php
                                                                    $Serial=0;

                                                                    $GetStockQ = "SELECT * FROM questions";

                                                                     $GetStockQR = mysqli_query($con,$GetStockQ);

                                                                     $GetStockNR = mysqli_num_rows($GetStockQR);

                                                                     if($GetStockNR>0)
                                                                     {
                                                                         ?>
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Question</th>
                                                    <th class="text-center">Opt 1</th>
                                                    <th class="text-center">Opt 2</th>
                                                    <th class="text-center">Opt 3</th>
                                                    <th class="text-center">Opt 4</th>
                                                    <th class="text-center">Correct</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <?php
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
                                            <tbody>
                                                <tr>
                                                    <td id="srno"> <b><?php echo $Serial ?></b> </td>
                                                    <td> <img src="<?php echo $questionText; ?>" alt="" width="100%"> </td>
                                                    <td> <img class="qans" src="<?php echo $opt1; ?>" alt="" width="100%"> </td>
                                                    <td> <img class="qans" src="<?php echo $opt2; ?>" alt="" width="100%"> </td>
                                                    <td> <img class="qans" src="<?php echo $opt3; ?>" alt="" width="100%"> </td>
                                                    <td> <img class="qans" src="<?php echo $opt4; ?>" alt="" width="100%"> </td>
                                                    <td id="correctopt"> <b><?php echo strtoupper($correctOpt); ?></b> </td>
                                                    <td id="dltbtn">
                                                        <button class="btn btn-block btn-outline-danger" data-href="deleteQuestion.php?questionID=<?php echo $questionID ; ?>" data-toggle="modal" data-target="#confirm-delete"> Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <?php
                            }//while loop ends here
                                                                         ?>
                                            <!--/fetch all questions-->
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Question</th>
                                                    <th class="text-center">Opt 1</th>
                                                    <th class="text-center">Opt 2</th>
                                                    <th class="text-center">Opt 3</th>
                                                    <th class="text-center">Opt 4</th>
                                                    <th class="text-center">Correct</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <!-- /.card-body -->
                                        <?php }//if ends here
    else{
        echo "<h1>No Record Found</h1>";
    }?>
                                        <!-- /.card -->
                                    </div>
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
    <!--Model for Delete User-->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"> CTP Faisalabad </div>
                <div class="modal-body"> want to delete ? </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <a class="btn btn-danger btn-ok">Delete</a> </div>
            </div>
        </div>
    </div>
    <!--/ Model for Delete User-->
    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

    </script>
</body>
<!--/Body-->

</html>
