<?php session_start();
$pageTitle = "Monthly Income Report";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<?php
    if(isset($_POST['submit'])){
    $Month = CleanData($_POST['month']);
    $Month1 = date("F", mktime(0, 0, 0, $Month, 10));
    
} ?>
<!-- Only Admin Can View This Page-->
<?php
/*
if (!isAdmin()){
    ?>
<script>
    setTimeout(function() {
        alert("you are not authorized to view this page");
        window.location.href = 'index.php';
    });

</script>
<?php
    }*/
?>
<!-- Only Admin Can View This Page-->
<!--/ PHP Code: Token Entery -->
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    <style>
        @media print {
            * {
                text-align: center;
            }
        }

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
            dom: 'Bfrtip',
            buttons: [
                'copy', 'pdf', 'print'
            ]
        });
    });

</script>
<!--Body-->
<?php
    //Students Enrolled
    $userID = $_SESSION['loginUserID'];                                    
    $User = userByID($userID);
    $userSchoolID = $User->idschool;
    $currentMonth= date("m");
    $currentYear = date('Y');
    if(isAdmin()){
    $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear'";
    }
    else{
    $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND idschool = '$userSchoolID'";
    }
    $QR = mysqli_query($con,$Q);
    $studentEnrolled = mysqli_num_rows($QR);
    
    
    //Total Fee + Received Total
    if(isAdmin()){
    $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear'";
    }
    else{
    $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND idschool = '$userSchoolID'";
    }
    
    $QR = mysqli_query($con,$Q);
    $NR = mysqli_num_rows($QR);
    $totalFee = 0;
    $totalPaid = 0;
         if($NR>0)
         {
             while($Row = mysqli_fetch_assoc($QR))
             {
                $Fee = $Row['totalfee'];
                $totalFee = $totalFee + $Fee;
                $Paid = $Row['paidfee'];
                $totalPaid = $totalPaid + $Paid;
            }
         }
    
    
    // Zero Discount Students
    if(isAdmin()){
        $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND paidfee=0";
    }
    else
    {
        $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND paidfee=0 AND idschool = '$userSchoolID'";
    }
    $QR = mysqli_query($con,$Q);
    $fullDiscount = mysqli_num_rows($QR);
    
    //Full Discount Students
    if(isAdmin()){
        $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND totalfee/paidfee=1";
    }
    else{
       $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND totalfee/paidfee=1 AND idschool = '$userSchoolID'";
    }
    $QR = mysqli_query($con,$Q);
    $zeroDiscount = mysqli_num_rows($QR);
    
    //Half Discount Students
    if(isAdmin()){
    $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND totalfee/paidfee=2";
        
    }
    else
    {
$Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND totalfee/paidfee=2 AND idschool = '$userSchoolID'";
     
    }
    $QR = mysqli_query($con,$Q);
    $halfDiscount = mysqli_num_rows($QR);
    
    //Pick n Drop
    if(isAdmin()){
    $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND pickndrop=1000";
        
    }
    else{
        $Q = "SELECT * FROM `admissions` WHERE MONTH(admissiondate) = '$currentMonth' AND YEAR(admissiondate)= '$currentYear' AND pickndrop=1000 AND idschool = '$userSchoolID'";
    
    }
    $QR = mysqli_query($con,$Q);
    $pickdrop = mysqli_num_rows($QR);
    
    $Serial = 0;                              
	 
                    
    
                            ?>

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
                            <h1 class="m-0 text-dark">Monthly Income Report</h1>
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
                                    <h3 class="card-title">Income Report for the Month of <?php echo date("F"); ?></h3>
                                </div>
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
                                                                <th>Students Enrolled</th>
                                                                <th>Total Fee</th>
                                                                <th>Half Discount</th>
                                                                <th>Full Discount</th>
                                                                <th>Zero Discount</th>
                                                                <th>Pick n Drop</th>
                                                                <th>Total Income</th>
                                                                <!--<th data-priority="3" class="all">Final Result</th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>

                                                                <td><?php echo $studentEnrolled; ?></td>
                                                                <td><?php echo $totalFee; ?></td>
                                                                <td><?php echo $halfDiscount; ?></td>
                                                                <td><?php echo $fullDiscount; ?></td>
                                                                <td><?php echo $zeroDiscount; ?></td>
                                                                <td><?php echo $pickdrop; ?></td>
                                                                <td><?php echo $totalPaid; ?></td>

                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Students Enrolled</th>
                                                                <th>Total Fee</th>
                                                                <th>Half Discount</th>
                                                                <th>Full Discount</th>
                                                                <th>Zero Discount</th>
                                                                <th>Pick n Drop</th>
                                                                <th>Total Income</th>
                                                                <!--<th data-priority="3" class="all">Final Result</th>-->
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
