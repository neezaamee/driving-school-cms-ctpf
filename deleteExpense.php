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
if(isset($_GET['expenseID']))
{
	$expenseID =  $_GET['expenseID'];
	
	$Q = "DELETE from expenses where idexpenses='$expenseID';";
	
	$QR = mysqli_query($con,$Q);
	
	if($QR)
	{
		
		echo "<center><h3 class=\"text-center\">Expense Deleted Successfully</h3></center>";
        
        
		?>
<script>
    setTimeout(function() {
        window.location.href = 'tableExpenses.php';
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
