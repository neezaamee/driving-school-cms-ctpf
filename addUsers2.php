<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
<!-- Only Admin Can Add User-->
<?php
if (!isAdmin()) {
    ?>
<script>
    alert('You are not authorized to view this page');

</script>
<?php header('Location: index.php'); exit; ?>
<?php
    }
?>
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
                                    <h3 class="card-title">Add Users</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" method="post" action="addUsers.php">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="InputRole">School</label>
                                            <select class="form-control" id="school" name="school" required>
                                                <?php
                                                    $Q2 = "SELECT * FROM schools";
                                                    $QR2 = mysqli_query($con,$Q2);
                                                     while($data = mysqli_fetch_array($QR2))
        {
            echo "<option value='". $data['idschools'] ."'>" .$data['location'] ."</option>";
        }	
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputEmail">User Name</label>
                                            <input type="text" class="form-control" id="InputEmail" placeholder="Enter User Name" name="email" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputFullName">First Name</label>
                                            <input type="text" class="form-control" id="InputFullName" placeholder="Enter email" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputFullName">Last Name</label>
                                            <input type="text" class="form-control" id="InputFullName" placeholder="Enter email" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputPassword">Password</label>
                                            <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputFullName">Rank</label>
                                            <input type="text" class="form-control" id="InputFullName" placeholder="Enter email" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputFullName">Belt</label>
                                            <input type="text" class="form-control" id="InputFullName" placeholder="Enter email" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputRole">Role</label>
                                            <select class="form-control" id="school" name="role" required>
                                                <?php
                                                    $Q2 = "SELECT * FROM usertypes limit 100 offset 1";
                                                    $QR2 = mysqli_query($con,$Q2);
                                                     while($data = mysqli_fetch_array($QR2))
        {
            echo "<option value='". $data['idusertypes'] ."'>" .$data['name'] ."</option>";
        }	
                                                    ?>
                                            </select>
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


<!-- PHP Code: add User -->
<?php
                        if(isset($_POST['submit']))
                        {
                            
                            $userName = CleanData($_POST['username']);	
                            $userFirstName = CleanData($_POST['firstname']);
                            $userLastName = CleanData($_POST['lastname']);
                            $userPassword = CleanData($_POST['password']);
                            $userRank = CleanData($_POST['rank']);
                            $userBelt = CleanData($_POST['belt']);
                            $userRole = CleanData($_POST['role']);
                            $userSchoolID = CleanData($_POST['schoolid']);
                        
                            $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
                            $regComplaintQ = "INSERT INTO users(username,firstname,lastname,password,rank,belt,role,idschool) VALUES('$userName','$userFirstName','$userLastName','$hashedPassword','$userRank','$userBelt','$userRole','$userSchoolID')";
                            $regComplaintQR = mysqli_query($con,$regComplaintQ);

                                if($regComplaintQR)
                                {       
                                    //echo "<center><h3>User Added <span style='color: green;'>Successfully</h3></center>";
                                    ?>

<script>
    alert('User Created Successfully');

</script>
<script>
    setTimeout(function() {
        window.location.href = 'viewUsers.php';
    }, 5000);

</script>
<?php
                                }
                                else
                                {
                                    echo mysqli_error($con);
                                    echo "<h3 class='text-center'>Try Again.</h3>";
                                }

                            }
                        ?>
<!--/ PHP Code: add User -->
