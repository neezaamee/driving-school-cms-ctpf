<?php session_start();
$pageTitle = "User Management";
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
<?php /*
if (isDEO()){
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
                            <h1 class="m-0 text-dark">User Management</h1>
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
                                    <h3 class="card-title">User Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- Questions Div -->
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="View All Questions">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="card-body" style="overflow-x:auto;">


                                                    <table id="usersTable" class="table text-center table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No.</th>
                                                                <th>School</th>
                                                                <th>Full Name</th>
                                                                <th>Username</th>
                                                                <th>Password</th>
                                                                <th>Role</th>
                                                                <th>Date Created</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                    $Serial=0;
                                                                    //select all users where role is not admin
                                                                    
                                                                    if(isAdmin()){
                                                                        $GetStockQ = "SELECT * FROM users WHERE idusertype <>'1'";
                                                                    }else{                                       $GetStockQ = "SELECT * FROM users WHERE idusertype <>'1' AND idusertype <>'2' AND idschool = '$userSchoolID' ";
                                                                    }
    

                                                                    $GetStockQR = mysqli_query($con,$GetStockQ);

                                                                     $GetStockNR = mysqli_num_rows($GetStockQR);

                                                                     if($GetStockNR>0)
                                                                     {
                                                                         while($GetStockRow = mysqli_fetch_assoc($GetStockQR))
                                                                         {

                                                                             $Serial++;
                                                                             $userID=$GetStockRow['id'];
                                                                             $userName=$GetStockRow['username'];
                                                                             $Password = $GetStockRow['password'];
                                                                             $Date = $GetStockRow['creationdate'];
                                                                             //get date from datetime stamp
                                                                             $date = new DateTime($Date);
                                                                             $Date = $date->format('d/m/Y');
                                                                             $IDuserType = $GetStockRow['idusertype'];
                                                                             
                                                                             
                                                                             $userTypes = userTypesByID($IDuserType);
                                                                             $userType= $userTypes->name;
                                                                             $Status = $GetStockRow['status'];
                                                                             $schoolID = $GetStockRow['idschool'];
                                                                             $School = schoolByID($schoolID);
                                                                             $schoolName =  $School->location;
                                                                             $staffID = $GetStockRow['idstaff'];
                                                                             $Staff = staffByID($staffID);
                                                                             $fullName = $Staff->fullname;

                                                                ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $Serial; ?>
                                                                </td>
                                                                <td><?php echo $schoolName; ?></td>
                                                                <td><?php echo $fullName; ?></td>
                                                                <td>
                                                                    <?php echo $userName; ?>
                                                                </td>

                                                                <td>
                                                                    <?php echo $Password; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo strtoupper($userType); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $Date; ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                        if ($Status == "active"){
                                                            
                                                         ?>
                                                                    <button class="btn btn-block btn-success" disabled><?php echo strtoupper($Status);?></button>
                                                                    <?php
                                                        }else{
                                                            ?>
                                                                    <button class="btn btn-block btn-danger" disabled><?php echo strtoupper($Status);?></button>
                                                                    <?php
                                                        }
                                                    ?>
                                                                </td>
                                                                <td> <a class="btn btn-block btn-outline-primary" href="editUser.php?userID=<?php echo $userID; ?>"> Edit</a> </td>
                                                                <td>
                                                                    <button class="btn btn-block btn-outline-danger" data-href="deleteUser.php?userID=<?php echo $userID; ?>" data-toggle="modal" data-target="#confirm-delete"> Delete</button>
                                                                </td>
                                                            </tr>
                                                            <?php
                            }//while loop ends here
                     }//if ends here
                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Sr No.</th>
                                                                <th>School</th>
                                                                <th>Full Name</th>
                                                                <th>Username</th>
                                                                <th>Password</th>
                                                                <th>Role</th>
                                                                <th>Date Created</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                                <th>Action</th>
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
