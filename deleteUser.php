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
    if(deleteUser($userID)){
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
