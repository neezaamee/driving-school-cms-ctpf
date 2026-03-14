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
                                <form role="form" method="post" action="addUsers2.php">
                                    <input type="hidden" name="csrf" value="<?php echo generate_csrf_token(); ?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="InputSchool">School</label>
                                            <select class="form-control" id="school" name="schoolid" required>
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
                                            <label for="InputUserName">User Name</label>
                                            <input type="text" class="form-control" id="InputUserName" placeholder="Enter User Name" name="username" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputFirstName">First Name</label>
                                            <input type="text" class="form-control" id="InputFirstName" placeholder="Enter First Name" name="firstname">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputLastName">Last Name</label>
                                            <input type="text" class="form-control" id="InputLastName" placeholder="Enter Last Name" name="lastname">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputPassword">Password</label>
                                            <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputRank">Rank</label>
                                            <input type="text" class="form-control" id="InputRank" placeholder="Enter Rank" name="rank">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputBelt">Belt</label>
                                            <input type="text" class="form-control" id="InputBelt" placeholder="Enter Belt" name="belt">
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
                            if (!isset($_POST['csrf']) || !verify_csrf_token($_POST['csrf'])) {
                                die("<h3 class='text-center text-danger'>Security Error: Invalid or missing CSRF token.</h3>");
                            }
                            
                            $userName = $_POST['username'];	
                            $userFirstName = $_POST['firstname'];
                            $userLastName = $_POST['lastname'];
                            $userPassword = $_POST['password'];
                            $userRank = $_POST['rank'];
                            $userBelt = $_POST['belt'];
                            $userRole = $_POST['role'];
                            $userSchoolID = $_POST['schoolid'];
                        
                            $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
                            $regComplaintQ = "INSERT INTO users(username,firstname,lastname,password,rank,belt,role,idschool) VALUES(?,?,?,?,?,?,?,?)";
                            $stmt = mysqli_prepare($con, $regComplaintQ);
                            mysqli_stmt_bind_param($stmt, "sssssssi", $userName, $userFirstName, $userLastName, $hashedPassword, $userRank, $userBelt, $userRole, $userSchoolID);
                            
                            if(mysqli_stmt_execute($stmt))
                            {       
                                log_audit_event($_SESSION['loginUserID'] ?? 0, 'CREATE', 'users', mysqli_insert_id($con), "Created new user: $userName");
                                mysqli_stmt_close($stmt);
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
