<!DOCTYPE html> 
<head> 
	<title>Driving Licence Test System CTP Faisalabad</title> 
</head> 
<body> 

	<?php  include('files/header.php'); date_default_timezone_set("Asia/Karachi"); $name = $_POST['name']; $id=$_REQUEST['name']; include('connection.php'); $aks="SELECT * from candata where id=".$id; $ag=mysql_query($aks); $ask=mysql_fetch_array($ag); $tkn=$ask['token']; $result = $name; if ($result == $tkn) { $dte=$ask['date']; $e_time=$ask['ent_time']; $nm=$ask['name']; $s_o=$ask['fwdname']; $nic=$ask['cnic']; $lcat=$ask['liccat']; } else { echo "<p align='center'> <font color=blue size='6pt'>. .  .  Record not Found about Token No:</font> <font color=red size='6pt'>$name</font></p>"; goto a; header('refresh: 5; url=duplicate.php'); } ?>
	
</body>

<body>
<body onload="self.print()">
	<center>
	<div> 
		<h3>City Traffic Police Faisalabad </h3>
 		<h3> Driving Licence Test System (DLTS)</h3> 
 		<h3> Duplicate Token Print</h3>
 	
	</div> 
	<div id="test"></div> 
	<?php  echo "<h3>Token No...: ".$tkn."</h3>"; echo "Date...",$dte; echo nl2br(".\n.",false); echo "Time...",$e_time; echo nl2br(".\n.",false); echo "Name...",$nm; echo nl2br(".\n.",false); echo "Father/Husband Name...", $s_o; echo nl2br(".\n.",false); echo "CNIC...",$nic; echo "<h3>Applied For...".$lcat."</h3>"; Echo "================================"; ?>
	<h3> Powered By:Computer Masters Pakistan </h3>
	<h3> http://www.ncml.pk </h3>
	</center>
	<!-- 
	<a href='duplicate.php' style='text-decoration:none;color:#ff0099;'> New Test</a>"; 
	<a href='index.php' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
	-->
		
<?php a: header('refresh: 5; url=duplicate.php'); ?>

</body>