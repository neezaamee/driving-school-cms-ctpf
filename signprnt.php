<!DOCTYPE html> 
<head> 
	<title>Driving Licence Test System CTP Faisalabad</title> 
</head> 
<body> 
	<body onload="self.print()">
	<center>
	
	<?php  include('files/header.php'); include('connection.php'); date_default_timezone_set("Asia/Karachi"); $todayDate = date("d-m-Y"); $entrytime = date("h:i:s"); $reap_dt = date("y-m-d",time()+86400*42); $corrans = $_GET['correct']; $incorrans = $_GET['incorrect']; $totalq = 10; $resu = $corrans."/".$incorrans."/" .$totalq; session_start(); echo "<h3>" . $_SESSION['innerHTMLmathNM'] . "</h3>"; echo "<h3> Driving Licence Test System(DLTS)</h3>"; echo "Date...",$todayDate; echo "....Time...", $entrytime; echo "<h3>Token No...: " . $_SESSION["ctoken"] . "</h3>"; echo "Candidate Name  :" . $_SESSION["cname"] . ".<br>"; echo "Father/Husband Name :" . $_SESSION["fhname"] . ".<br>"; echo "NIC No # :" . $_SESSION["ccnic"] . ".<br>"; echo "Licence Catagory :" . $_SESSION["clcat"] . ".<br>"; if ($corrans >= 7) { Echo "<h3>PASSED</h3> in the Traffic Road Signs test"; echo nl2br(".\n.",false); Echo ' Please now GOTO Road Test track '; $sql="update candata set sgntst='PASS', stnres='$resu', sgn_time='$entrytime' where id=".$_SESSION["ctoken"]; $rep=mysql_query($sql)or die(mysql_error()); } else { Echo "<h3>FAILED</h3>" , 'in the Traffic Road Signs Test and'; echo nl2br(".\n.",false); Echo 'eligibal to reapare after 42 days for test'; $sql="update candata set sgntst='FAIL', stnres='$resu', sgn_time='$entrytime', 42days='$reap_dt', fnlres='FAIL' where id=".$_SESSION["ctoken"]; $rep=mysql_query($sql)or die(mysql_error()); } ?>

		<h4>Software Designed By</h4>
		<h4>Computer Masters Pakistan </h4>
		<h4>http://ncml.pk</h4>
		<!-- <a href='signstest.php' style='text-decoration:none;color:#ff0099;'> New Test</a>"; 
		<a href='index.php' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
		-->
		
		</center>
<?php  header('refresh: 5; url=signstest.php'); ?>
</body> 
</html>