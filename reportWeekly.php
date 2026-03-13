<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
    <!-- Only Admin Can View This Page-->
    <?php
if (!isAdmin()){
    ?>
        <script>
            setTimeout(function () {
                alert("you are not authorized to view this page");
                window.location.href = 'index.php';
            });
        </script>
        <?php
    }
?>
            <!-- Only Admin Can View This Page-->
            <!--calculation for last 1 week-->
            <?php

$date1 = date("j F Y");
$date=date_create($date1);
date_sub($date,date_interval_create_from_date_string("06 days"));
$date2 = date_format($date,"j-F-Y");
//echo "date 1 is ".$date1."<br /> date 2 is ".$date2;
?>
                <!--/calculation for last 1 week-->
                <!--/ PHP Code: Token Entery -->
                <!DOCTYPE html>
                <html>
                <!--Head-->
                <?php include('Head.php')?>
                    <!--/Head-->

                    <head>
                        <title>
                            <?php echo "Test Report for Last Week ".$date2." to ".$date1;?>
                        </title>
                        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
                        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
                        <style>
                            /*@media print { html, body { height: auto; } td { margin: 0; padding: 5px 5px; } }*/
                        </style>
                    </head>
                    <script>
                        $(document).ready(function () {
                            $('#myTable').DataTable({
                                responsive: {
                                    details: {
                                        display: $.fn.dataTable.Responsive.display.childRow
                                    }
                                }
                                , dom: 'Bfrtip'
                                , buttons: [
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
                                                        <h1 class="m-0 text-dark">Weekly Report</h1> </div>
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
                                                                <h3 class="card-title"><?php echo "Test Report for Last Week ".$date2." to ".$date1;?></h3> </div>
                                                            <!-- /.card-header -->
                                                            <!-- Questions Div -->
                                                            <div class="card-body">
                                                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                                                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="View All Questions">
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <div class="card-body" style="overflow-x:auto;">
                                                                                <table id="myTable" class="display" style="width:100%; text-align: center;" class="text-center">
                                                                                    <thead class="text-center">
                                                                                        <tr>
                                                                                            <th>No.</th>
                                                                                            <th data-priority="1" class="all">Name</th>
                                                                                            <th>Father/Husband Name</th>
                                                                                            <th data-priority="2" class="all">CNIC</th>
                                                                                            <th>Token #</th>
                                                                                            <th>License Category</th>
                                                                                            <th>Sign Test Result</th>
                                                                                            <th>Road Test Result</th>
                                                                                            <th data-priority="3" class="all">Final Result</th>
                                                                                            <th>Test Date</th>
                                                                                            <th>Testing Officer</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                    $Serial=0;
    $todayDate= date("Y-m-d");
	 
                    $GetStockQ = "SELECT * FROM tests WHERE DATE(testdate) BETWEEN ADDDATE(NOW(),-7) AND NOW()";

                                                                     $GetStockQR = mysqli_query($con,$GetStockQ);

                                                                     $GetStockNR = mysqli_num_rows($GetStockQR);

                     if($GetStockNR>0)
                     {
                         while($GetStockRow = mysqli_fetch_assoc($GetStockQR))
                         {

                             $Serial++;
                                                                             $testID=$GetStockRow['id'];
                                                                             $candidateID=$GetStockRow['candidateid'];
                                                                             $signTest = $GetStockRow['signtest'];
                                                                             $roadTest = $GetStockRow['roadtest'];
                                                                             $testDate = $GetStockRow['testdate'];
                                                                             $finalResult = $GetStockRow['finalresult'];
                                                                             $testingOfficer = $GetStockRow['testby'];
                                                                             $fetchCandidateDataQ = "SELECT * FROM candidates WHERE id='$candidateID'";
                                                                             $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);
                                                                             $candidateDataObject = mysqli_fetch_object($fetchCandidateDataQR);
                                                                            $name = $candidateDataObject->name;
                                                                            $fathername = $candidateDataObject->fathername;
                                                                            $token = $candidateDataObject->token;
                                                                            $cnic = $candidateDataObject->cnic;
                                                                            $LicenseCategory = $candidateDataObject->liccat;
                        ?>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <?php echo $Serial ?>
                                                                                                </td>
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
                                                                                                    <?php echo $token; ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <?php echo $LicenseCategory; ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <?php
                             if($signTest == "Pass"){
echo "<span class='btn btn-block btn-success active'>".$signTest."</span>";
}else{
echo "<span class='btn btn-block btn-danger active'>".$signTest."</span>";} ?> </td>
                                                                                                <td>
                                                                                                    <?php if($roadTest == "Pass"){ echo "<span class='btn btn-block btn-success active'>".$roadTest."</span>"; }elseif($roadTest == "Fail"){ echo "<span class='btn btn-block btn-danger active'>".$roadTest."</span>";}else{echo "Absent";} ?> </td>
                                                                                                <td>
                                                                                                    <?php if($finalResult == "Pass")
                             { echo "<span class='btn btn-block btn-success active'>".$finalResult."</span>"; }
                             elseif($finalResult == "Fail")
                             { echo "<span class='btn btn-block btn-danger active'>".$finalResult."</span>";}elseif(!$finalResult){echo "<span class='btn btn-block btn-danger active'>Fail</span>";} ?></td>
                                                                                                <td>
                                                                                                    <?php echo $testDate; ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <?php echo $testingOfficer; ?>
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
                                                                                            <th>Name</th>
                                                                                            <th>Father/Husband Name</th>
                                                                                            <th>CNIC</th>
                                                                                            <th>Token #</th>
                                                                                            <th>License Category</th>
                                                                                            <th>Sign Test Result</th>
                                                                                            <th>Road Test Result</th>
                                                                                            <th>Final Result</th>
                                                                                            <th>Test Date</th>
                                                                                            <th>Testing Officer</th>
                                                                                        </tr>
                                                                                    </tfoot>
                                                                                </table>
                                                                            </div>
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
                                    <!--custome validation-->
                                    <script>
                                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                                        (function () {
                                            'use strict';
                                            window.addEventListener('load', function () {
                                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                                var forms = document.getElementsByClassName('needs-validation');
                                                // Loop over them and prevent submission
                                                var validation = Array.prototype.filter.call(forms, function (form) {
                                                    form.addEventListener('submit', function (event) {
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