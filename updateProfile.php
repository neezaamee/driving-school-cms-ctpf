<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
?>
<!--Reply Massage-->
<?php
    require_once('Functions.php');
    if(isset($_POST['submit']))
    {
        if (!isset($_POST['csrf']) || !verify_csrf_token($_POST['csrf'])) {
            die("<h3 class='text-center text-danger'>Security Error: Invalid or missing CSRF token.</h3>");
        }
        
        $userID = $_POST['userid'];	
        $staffID = $_POST['staffid'];	
        $firstName = $_POST['firstname'];
        $Password = $_POST['password'];

        $QR = true; // Default success if we don't need to change password
        if (!empty($Password)) {
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
            $Q = "UPDATE users SET password=? WHERE id=?";
            $stmt = mysqli_prepare($con, $Q);
            mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $userID);
            $QR = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        
        $Q1 = "UPDATE staff SET fullname=? WHERE id=?";
        $stmt1 = mysqli_prepare($con, $Q1);
        mysqli_stmt_bind_param($stmt1, "si", $firstName, $staffID);
        $QR1 = mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);

            if($QR && $QR1)
            {       
                log_audit_event($_SESSION['loginUserID'] ?? $userID, 'UPDATE', 'users_staff', $userID, "User updated their own profile.");
                echo "<center><h3>Details Updated <span style='color: green;'>Successfully</h3></center>";
                ?>
<?php header('Location: index.php'); exit; ?>
<?php
                    die();
            }
            else
            {
                echo mysqli_error($con);
                echo "<h3 class='text-center'>Try Again.</h3>";
            }

    }
?>
