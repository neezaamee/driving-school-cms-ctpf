<!DOCTYPE html> 
<head> 
	<title>Driving Test System CTP Faisalabad</title> 
</head> 
<body> 

	<?php  include('files/header.php'); date_default_timezone_set("Asia/Karachi"); $todayDate = date("d-m-Y"); $entrytime = date("h:i:s"); $answer = $_POST['ans']; if ($answer == "ans1") { $rdts = 'Pass'; } else { $rdts = 'Fail'; } $name = $_POST['name']; $id=$_REQUEST['name']; include('connection.php'); $aks="SELECT * from candata where id=".$id; $ag=mysql_query($aks); $ask=mysql_fetch_array($ag); $tkn=$ask['token']; $result = $name; $rdtst =$ask['rdtest']; $finl = $ask['fnlres']; if ($result == $tkn and (empty($rdtst))) { $dte=$ask['date']; $nm=$ask['name']; $s_o=$ask['fwdname']; $nic=$ask['cnic']; $lcat=$ask['liccat']; $rdtst =$ask['rdtest']; $finl = $ask['fnlres']; } else { echo "<p align='center'> <font color=blue size='6pt'>. .  .  .  .Already Feeded or Record not Found Token No:</font> <font color=red size='6pt'>$name</font></p>"; goto a; header('refresh: 5; url=duplicate.php'); } ?>

</body>

<body>
<body onload="self.print()">
	<center>
	<div> 
		<h3>City Traffic Police Faisalabad </h3>
 		<h4> Driving Licence Test System(DLTS)</h4> 
 	
	</div> 
	<div id="test"></div> 
	<?php  echo "<h3>Token No...: ".$tkn."</h3>"; echo "Date...",$todayDate; echo "...Time...",$entrytime; echo nl2br(".\n.",false); echo "Name...",$nm; echo nl2br(".\n.",false); echo "Father/Husband Name...", $s_o; echo nl2br(".\n.",false); echo "CNIC...",$nic; echo nl2br(".\n.",false); echo "Applied For...", $lcat; echo nl2br(".\n.",false); if($rdts == 'Pass') { $sql="update candata set rdtest='$rdts', rd_time='$entrytime', fnlres='PASS' where id=".$id; $rep=mysql_query($sql)or die(mysql_error()); Echo "================================"; Echo '<h3>PASSED</h3> in the Final Road Test'; Echo nl2br(".\n.",false); Echo 'for further information about Licence GO TO'; Echo nl2br(".\n.",false); Echo 'http://dlims.punjab.gov.com'; } else { $reap_dt = date("d-m-Y",time()+86400*42); $sql="update candata set rdtest='$rdts', rd_time='$entrytime', 42days='$reap_dt', fnlres='FAIL' where id=".$id; $rep=mysql_query($sql)or die(mysql_error()); Echo "================================"; Echo '<h3>FAILED</h3>','in the Road Test and'; Echo nl2br(".\n.",false); Echo 'eligibal to reapare after 42 days..  ',$reap_dt; } ?>
	<h4>Software By:Computer Masters Pakistan </h4>
	<h4>http://www.ncml.pk </h4>
	<!-- <a href='rdtest.php' style='text-decoration:none;color:#ff0099;'> New Test</a>"; 
	<a href='index.php' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
		<center> -->

<?php a: header('refresh: 5; url=rdtest.php'); ?>

</body>