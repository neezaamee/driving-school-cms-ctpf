<?php session_start();
$pageTitle = "My Profile";
require_once('connection.php');
require_once('sessionSet.php');
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include_once('Head.php')?>
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
                            <h1 class="m-0 text-dark">My Profile</h1>
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
                                    <h3 class="card-title">View/Edit Profile Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <!--Fetch User Data-->
                                <?php
if(isset($_SESSION['loginUserID'])) 
{
	$userID = $_SESSION['loginUserID'];
    
    $User = userByID($userID);    
    $Username = $User->username;
    $Password = $User->password;
    $userSchoolID = $User->idschool;
    $staffID = $User->idstaff;
    $Staff = staffByID($staffID);
    $userFirstname = $Staff->fullname;
    $userRank = $Staff->rank;
    $userBelt = $Staff->belt;
    $IDuserType = $User->idusertype;
    $userTypes = userTypesByID($IDuserType);
    $userType = $userTypes->name;
    $userDetail = ucwords($userFirstname)." ".strtoupper($userRank)."/".$userBelt;

    
    
    /*$Rank = $User->rank;
    $Belt = $User->belt;
    $Role = $User->role;
    $firstName = $User->firstname;
    $lastName = $User->lastname;
    $Password = $User->password;*/

    /*$complaintDataQ = "select * from users where email='$userEmailSession'";
    $complaintDataQR = mysqli_query($con,$complaintDataQ);
    $complaintDataRow = mysqli_fetch_assoc($complaintDataQR);
    $userID=$complaintDataRow['id'];
    $userFullName=$complaintDataRow['username'];
    $userEmail = $complaintDataRow['email'];
    $userPassword = $complaintDataRow['password'];
    $userRole = $complaintDataRow['role'];*/
}

?>
                                <!-- form start -->
                                <form role="form" method="post" action="updateProfile.php">
                                    <input type="hidden" name="csrf" value="<?php echo generate_csrf_token(); ?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="InputEmail">User Name</label>
                                            <input type="hidden" class="form-control" id="InputUserID" name="userid" value="<?php echo e($userID); ?>">
                                            <input type="hidden" class="form-control" id="InputStaffID" name="staffid" value="<?php echo e($staffID); ?>">
                                            <input type="text" class="form-control" id="InputEmail" placeholder="Enter User Name" name="email" value="<?php echo e($Username); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputFullName">First Name</label>
                                            <input type="text" class="form-control" id="InputFullName" placeholder="Enter First Name" name="firstname" value="<?php echo e($userFirstname); ?>">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="InputPassword">Password</label>
                                            <input type="password" class="form-control" id="InputPassword" placeholder="Leave blank to keep current password" name="password" value="">
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
