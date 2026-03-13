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
                        <div class="col-sm-6"><h1 class="m-0 text-dark">User Management</h1></div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header"><h3 class="card-title">Modify User</h3></div>
                                <div class="card-body">
                                <?php
                                if (isset($_POST['update_user'])) {
                                    // Handle the Update logic (from editUserRSP.php)
                                    $userID = CleanData($_POST['userid']);	
                                    $userName = CleanData($_POST['username']);
                                    $Password = CleanData($_POST['password']);
                                    $Status = CleanData($_POST['status']);
                                    $userType = CleanData($_POST['idusertype']);

                                    // Check if the input looks like a bcrypt hash already
                                    $hashedPassword = password_get_info($Password)['algo'] ? $Password : password_hash($Password, PASSWORD_DEFAULT);

                                    $sql = "UPDATE users SET username=?, password=?, idusertype=?, status=? WHERE idusers=?";
                                    $stmt = mysqli_prepare($con, $sql);
                                    mysqli_stmt_bind_param($stmt, "ssisi", $userName, $hashedPassword, $userType, $Status, $userID);
                                    
                                    if (mysqli_stmt_execute($stmt)) {
                                        echo "<div class='alert alert-success'>User details updated successfully.</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Error updating user: " . mysqli_error($con) . "</div>";
                                    }
                                    mysqli_stmt_close($stmt);
                                    echo "<script>setTimeout(function(){ window.location.href='viewUsers.php'; }, 2000);</script>";

                                } elseif (isset($_GET['userID'])) {
                                    // Handle the Edit Form (Step 2)
                                    $userID = CleanData($_GET['userID']);
                                    $sql = "SELECT * FROM users WHERE idusers = ?";
                                    $stmt = mysqli_prepare($con, $sql);
                                    mysqli_stmt_bind_param($stmt, "i", $userID);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    $Row = mysqli_fetch_assoc($result);
                                    mysqli_stmt_close($stmt);

                                    if ($Row) {
                                        $Staff = staffByID($Row['idstaff']);
                                        ?>
                                        <form role="form" method="post" action="editUser.php">
                                            <input type="hidden" name="userid" value="<?php echo $userID; ?>">
                                            <div class="form-group">
                                                <label>User Name</label>
                                                <input type="text" class="form-control" name="username" value="<?php echo $Row['username']; ?>" required>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6"><label>First Name</label><input type="text" class="form-control" value="<?php echo $Staff->fullname; ?>" readonly></div>
                                                <div class="form-group col-md-6"><label>Rank / Belt</label><input type="text" class="form-control" value="<?php echo $Staff->rank . ' ' . $Staff->belt; ?>" readonly></div>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="text" class="form-control" name="password" value="<?php echo $Row['password']; ?>" required>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>User Type</label>
                                                    <select class="form-control" name="idusertype" required>
                                                        <option value="1" <?php if($Row['idusertype'] == 1) echo 'selected'; ?>>Super Admin</option>
                                                        <option value="2" <?php if($Row['idusertype'] == 2) echo 'selected'; ?>>Incharge</option>
                                                        <option value="3" <?php if($Row['idusertype'] == 3) echo 'selected'; ?>>Data Entry Operator</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status" required>
                                                        <option value="active" <?php if($Row['status'] == 'active') echo 'selected'; ?>>Active</option>
                                                        <option value="deactive" <?php if($Row['status'] == 'deactive') echo 'selected'; ?>>Deactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                                        </form>
                                        <?php
                                    } else {
                                        echo "<div class='alert alert-danger'>User not found.</div>";
                                    }
                                } else {
                                    echo "<script>window.location.href='viewUsers.php';</script>";
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
