<?php session_start();
$pageTitle = "Add New Staff";
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');

$userName = $_SESSION['loginUsername'];
$userID = $_SESSION['loginUserID'];

$User = userByID($userID);
$userSchoolID = $User->idschool;
?>
<!-- Only Admin Can Add User-->
<?php
if (!isAdmin()) {
?>
    <script>
        //alert('You are not authorized to view this page');
    </script>
    <script>
        /* setTimeout(function() {
 window.location.href = 'index.php';
 });*/
    </script>
<?php
}
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php') ?>
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
                            <h1 class="m-0 text-dark">Add New Staff</h1>
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

                                <!-- PHP Code: add User -->
                                <?php
                                if (isset($_POST['submit'])) {

                                    $schoolID = CleanData($_POST['school']);
                                    $fullName = CleanData($_POST['fullname']);
                                    $Rank = CleanData($_POST['rank']);
                                    $Belt = CleanData($_POST['belt']);
                                    $Designation = CleanData($_POST['designation']);

                                    $addStaffQ = "INSERT INTO staff(fullname,`rank`,belt,idschool,idtypestaff,addedbyuser) VALUES('$fullName','$Rank','$Belt',$schoolID,$Designation, $userID)";
                                    $addStaffQR = mysqli_query($con, $addStaffQ);

                                    if ($addStaffQR) {
                                        echo "<center><h3>User Added <span style='color: green;'>Successfully</h3></center>";
                                ?>
                                    <?php
                                    } else {
                                        echo mysqli_error($con);
                                        echo "<h3 class='text-center'>Try Again.</h3>";
                                    }
                                } else {

                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title">Add Staff Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form role="form" method="post" action="addStaff.php">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="InputRole">School</label>
                                                <?php
                                                if (isAdmin()) {
                                                ?>
                                                    <select class="form-control" id="school" name="school">
                                                        <?php
                                                        $Q2 = "SELECT * FROM schools WHERE id != 1";
                                                        $QR2 = mysqli_query($con, $Q2);
                                                        while ($data = mysqli_fetch_array($QR2)) {
                                                            echo "<option value='" . $data['id'] . "'>".cityByID($data['idcity'])->shortcode.'-'.$data['location']. "</option>";
                                                        }
                                                        ?>
                                                    </select>

                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" class="form-control" id="schoolid" value="<?= schoolByID($userSchoolID)->location; ?>" readonly>
                                                    <input type="hidden" class="form-control" id="stschoolid" name="stschoolid" value="<?= $schoolID; ?>">
                                                <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="form-group">
                                                <label for="InputRole">Employee Type</label>
                                                <select class="form-control" id="emptype" name="emptype" required>
                                                    <option value="12">Government</option>
                                                    <option value="13">Private</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="rankField">
                                                <label for="InputFullName">Rank</label>
                                                <input type="text" class="form-control" id="rank" placeholder="Enter Rank" name="rank">
                                            </div>
                                            <div class="form-group" id="beltField">
                                                <label for="InputFullName">Belt</label>
                                                <input type="text" class="form-control" id="belt" placeholder="Belt" name="belt">
                                            </div>
                                            <div class="form-group">
                                                <label for="InputRole">Designation</label>
                                                <select class="form-control" id="designation" name="designation" required>
                                                    <?php
                                                    if (isAdmin()) {
                                                        $Q2 = "SELECT * FROM typestaff WHERE id != '1'";
                                                        $QR2 = mysqli_query($con, $Q2);
                                                        while ($data = mysqli_fetch_array($QR2)) {
                                                            echo "<option value='" . $data['id'] . "'>" . $data['name'] . "</option>";
                                                        }
                                                    } else {
                                                        $Q2 = "SELECT * FROM typestaff WHERE id != '1' AND idtypestaff !='10'";
                                                        $QR2 = mysqli_query($con, $Q2);
                                                        while ($data = mysqli_fetch_array($QR2)) {
                                                            echo "<option value='" . $data['id'] . "'>" . $data['name'] . "</option>";
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="InputFullName">Full Name</label>
                                                <input type="text" class="form-control" id="fullname" placeholder="Full Name" name="fullname">
                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                        </div>
                                        <!--/.card-footer-->
                                    </form>
                                <?php
                                }
                                ?>
                                <!--/ PHP Code: add User -->
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
    <script>
        $(document).ready(function() {
            $('#emptype').change(function() {
                if ($(this).val() == '12') { // Government selected
                    $('#rankField').show();
                    $('#beltField').show();
                } else { // Private selected
                    $('#rankField').hide();
                    $('#beltField').hide();
                }
            });

            // Trigger change event initially to set initial state
            $('#emptype').trigger('change');
        });
    </script>
    <?php include('footerPlugins.php') ?>
</body>
<!--/Body-->

</html>
