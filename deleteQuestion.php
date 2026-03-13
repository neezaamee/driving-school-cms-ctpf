<?php session_start();
    require_once('sessionSet.php');
    require_once('connection.php');
    include('Functions.php');
    include('Head.php');
?>
<!--deleteUser Php Code-->
<?php 
if(isset($_GET['questionID']))
{
	$questionID =  $_GET['questionID'];
	
	$deleteQuestionQ = "DELETE from questions where id='$questionID';";
	
	$deleteQuestionQR = mysqli_query($con,$deleteQuestionQ);
	
	if($deleteQuestionQR)
	{
		
		echo "<center><h3 class=\"text-center\">Question Deleted Successfully</h3></center>";
		?>
<script>
    setTimeout(function() {
        window.location.href = 'Questions.php';
    }, 500);

</script>
<?php
	}
	else
	{
		echo "<h3 class=\"text-center\">Try Again. </h3>";
	}
	
}?>
<!--/ delete User-->
