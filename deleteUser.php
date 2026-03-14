<?php session_start();
    require_once('sessionSet.php');
    require_once('connection.php');
    include('Functions.php');
    include('Head.php');
?>
<!-- Only Admin Can Delete User-->
<?php
if (!isAdmin()){
    ?>
<?php header('Location: index.php'); exit; ?>
<?php
    }
?>
<!--deleteUser Php Code-->
<?php 
if(isset($_GET['userID']))
{
	$userID =  $_GET['userID'];
    if (!isset($_GET['csrf']) || !verify_csrf_token($_GET['csrf'])) {
        die("<h3 class='text-center text-danger'>Security Error: Invalid or missing CSRF token.</h3>");
    }

    if(deleteUser($userID)){
        log_audit_event($_SESSION['loginUserID'] ?? 0, 'DELETE', 'users', $userID, "Deleted user account");
        echo "<center><h3 class=\"text-center\">User Deleted Successfully</h3></center>";
		?>
<script>
    setTimeout(function() {
        window.location.href = 'viewUsers.php';
    }, 1000);

</script>
<?php
    }else{
    echo "<h3 class=\"text-center\">Try Again. </h3>".mysqli_error();
    }
	
	/*$Q = "DELETE from users where idusers='$complaintID';";
	
	$QR = mysqli_query($con,$Q);
	
	if($QR)
	{
		
		echo "<center><h3 class=\"text-center\">User Deleted Successfully</h3></center>";
		?>
<script>
    setTimeout(function() {
        window.location.href = 'viewUsers.php';
    }, 1000);

</script>
<?php
	}
	else
	{
		echo "<h3 class=\"text-center\">Try Again. </h3>".mysqli_error();;
	}*/
	
}?>
<!--/ delete User-->
