<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include_once('Head.php') ?>
<!--/Head-->
<!--Body-->

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include('topNav.php') ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include('sidebar.php') ?>
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
                  <h3 class="card-title">Edit User</h3>
                </div>
                <!-- /.card-header -->
                <!--Fetch User Data-->
                <?php
                if (isset($_GET['staffID'])) {
                  $staffID =  $_GET['staffID'];
                  $Staff = staffByID($staffID);
                  $schoolID = $Staff->idschool;
                  $firstName = $Staff->firstname;
                  $lastName = $Staff->lastname;
                  $Rank = $Staff->rank;
                  $Belt = $Staff->belt;
                  $IDtypeStaff = $Staff->idtypestaff;

                  $School = schoolByID($schoolID);
                  $schoolCode = $School->schoolcode;
                  $cityCode = cityByID($School->idcity)->shortcode;

                  //making username using combination
                  $userName = "{$cityCode}_{$schoolCode}_{$staffID}";
                  //Settig default Password
                  $Password =  password_generate(7);
                  $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

                  $Q = "INSERT INTO users(username,password,idusertype,status,idschool,idstaff) VALUES('$userName','$hashedPassword','3','active','$schoolID','$staffID')";
                  $QR = mysqli_query($con, $Q);

                  if ($QR) {
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
                  } else {
                    echo mysqli_error($con);
                    echo "<h3 class='text-center'>Try Again.</h3>";
                  }
                }

                ?>

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
    <?php include('footer.php') ?>
    <!--/Footer Content-->
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php include('footerPlugins.php') ?>
</body>
<!--/Body-->

</html>
