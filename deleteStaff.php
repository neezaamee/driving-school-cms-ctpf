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
if(isset($_GET['staffID']))
{
	$staffID =  $_GET['staffID'];
	
	$Q = "DELETE from staff where id='$staffID';";
	
	$QR = mysqli_query($con,$Q);
	
	if($QR)
	{
		
		echo "<center><h3 class=\"text-center\">Staff Deleted Successfully</h3></center>";
        if (userByStaffID($staffID) > 0){
            $Q1 = "DELETE from users where idstaff='$staffID';";
	
	$QR1 = mysqli_query($con,$Q1);
	
	if($QR1)
    {
      echo "<center><h3 class=\"text-center\">User Deleted Successfully</h3></center>";   
    }
        }else{
            echo "";
        }
        
		?>
<script>
    setTimeout(function() {
        window.location.href = 'Staff.php';
    }, 1000);

</script>
<?php
	}
	else
	{
		echo "<h3 class=\"text-center\">Try Again. </h3>";
	}
	
}?>
<!--/ delete User-->
