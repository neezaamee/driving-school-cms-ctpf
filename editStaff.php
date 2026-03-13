<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include('topNav.php') ?>
        <?php include('sidebar.php') ?>
        
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"><h1 class="m-0 text-dark">Staff Management</h1></div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header"><h3 class="card-title">Edit Staff Member</h3></div>
                                <div class="card-body">
                                <?php
                                if (isset($_POST['update_staff'])) {
                                    // Handle the Update logic (from editStaffRSP.php)
                                    $staffID = CleanData($_POST['idstaff']);	
                                    $schoolID = CleanData($_POST['school']);
                                    $fullName = CleanData($_POST['firstname']);
                                    $Rank = CleanData($_POST['rank']);
                                    $Belt = CleanData($_POST['belt']);
                                    $Designation = CleanData($_POST['designation']);

                                    $sql = "UPDATE staff SET idschool=?, fullname=?, rank=?, belt=?, idtypestaff=? WHERE id=?";
                                    $stmt = mysqli_prepare($con, $sql);
                                    mysqli_stmt_bind_param($stmt, "isssii", $schoolID, $fullName, $Rank, $Belt, $Designation, $staffID);
                                    
                                    if (mysqli_stmt_execute($stmt)) {
                                        echo "<div class='alert alert-success'>Staff details updated successfully.</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Error updating staff: " . mysqli_error($con) . "</div>";
                                    }
                                    mysqli_stmt_close($stmt);
                                    echo "<script>setTimeout(function(){ window.location.href='Staff.php'; }, 2000);</script>";

                                } elseif (isset($_GET['staffID'])) {
                                    // Handle the Edit Form (Step 2)
                                    $staffID = CleanData($_GET['staffID']);
                                    $Staff = staffByID($staffID);
                                    if ($Staff) {
                                        ?>
                                        <form role="form" method="post" action="editStaff.php">
                                            <input type="hidden" name="idstaff" value="<?php echo $staffID; ?>">
                                            <div class="form-group">
                                                <label>School</label>
                                                <select class="form-control" name="school" <?php echo !isAdmin() ? 'readonly' : ''; ?>>
                                                    <?php
                                                    $schools_sql = isAdmin() ? "SELECT * FROM schools WHERE id != 1" : "SELECT * FROM schools WHERE id = '{$User->idschool}'";
                                                    $schools_res = mysqli_query($con, $schools_sql);
                                                    while($s = mysqli_fetch_array($schools_res)) {
                                                        $sel = ($s['id'] == $Staff->idschool) ? 'selected' : '';
                                                        echo "<option value='{$s['id']}' $sel>{$s['location']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" class="form-control" name="firstname" value="<?php echo $Staff->fullname; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Rank</label>
                                                <input type="text" class="form-control" name="rank" value="<?php echo $Staff->rank; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Belt</label>
                                                <input type="text" class="form-control" name="belt" value="<?php echo $Staff->belt; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <select class="form-control" name="designation" required>
                                                    <?php
                                                    $types_sql = isAdmin() ? "SELECT * FROM typestaff WHERE id != '1'" : "SELECT * FROM typestaff WHERE id != '1' AND id != '10'";
                                                    $types_res = mysqli_query($con, $types_sql);
                                                    while($t = mysqli_fetch_array($types_res)) {
                                                        $sel = ($t['id'] == $Staff->idtypestaff) ? 'selected' : '';
                                                        echo "<option value='{$t['id']}' $sel>{$t['name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button type="submit" name="update_staff" class="btn btn-primary">Update Staff Member</button>
                                        </form>
                                        <?php
                                    } else {
                                        echo "<div class='alert alert-danger'>Staff member not found.</div>";
                                    }
                                } else {
                                    echo "<script>window.location.href='Staff.php';</script>";
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include('footer.php') ?>
    </div>
    <?php include('footerPlugins.php') ?>
</body>
</html>
