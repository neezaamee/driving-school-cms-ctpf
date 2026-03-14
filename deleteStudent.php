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
if(isset($_GET['admissionID']))
{
    if (!isset($_GET['csrf']) || !verify_csrf_token($_GET['csrf'])) {
        die("<h3 class='text-center text-danger'>Security Error: Invalid or missing CSRF token.</h3>");
    }

	$admissionID =  $_GET['admissionID'];
	
	$Q = "DELETE from admissions where id=?";
    $stmt = mysqli_prepare($con, $Q);
    mysqli_stmt_bind_param($stmt, "i", $admissionID);
    $QR = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
	
	if($QR)
	{
		log_audit_event($_SESSION['loginUserID'] ?? 0, 'DELETE', 'admissions', $admissionID, "Admin deleted student admission record");
		echo "<center><h3 class=\"text-center\">Student Deleted Successfully</h3></center>";
        
        
		?>
<script>
    setTimeout(function() {
        window.location.href = 'tableStudentsAjax.php';
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
