<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
?>
<!--Reply Massage-->
<?php
    if(isset($_POST['submit']))
    {
        $userID = CleanData($_POST['userid']);	
        $staffID = CleanData($_POST['staffid']);	
        $firstName = CleanData($_POST['firstname']);
        $Password = CleanData($_POST['password']);

        $QR = true; // Default success if we don't need to change password
        if (!empty($Password)) {
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
            $Q = "UPDATE users SET password='$hashedPassword' WHERE id='$userID'";
            $QR = mysqli_query($con, $Q);
        }
        
        $Q1 =    "UPDATE staff SET fullname='$firstName' WHERE id='$staffID'";
        $QR1 = mysqli_query($con,$Q1);

            if($QR && $QR1)
            {       
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
