<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Driving Test System CTP Faisalabad</title>
	<link href="css/newcss.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
</head>
<body>
<body onload="self.print()">
	<?php  include('connection.php'); $id=0; if(isset($_REQUEST['start'])) { $strt=$_REQUEST['start']; $end=$_REQUEST['end']; $answer = $_POST['ans']; if ($answer == "ans1") { $rdts = 'Pass'; } else { $rdts = 'Fail'; } $todayDate = date("d-m-Y"); $repo_time = date("h:i:s"); $pass_tot = 0; $fail_tot = 0; $absc_tot = 0; Echo "<center><h1> City Traffic Police Faisalabad</h1></center>"; Echo "<center><h2> Daily Report of Test for Driving Licence </h2></center>"; echo "<center>Date... : " , $todayDate, ".....................Report Time... : " .$repo_time. "</center>"; ?>
	<table class="hovertable">
	<tr>
		<th>Sr</th>
		<th>Token</th>
		<th>Name</th>
		<th>Father/Husband </th>
		<th>Applied for </th>
		<!--<th>Ticket Cost </th> -->
		<th>Signs Test </th>
		<th>Road Test </th>
		<th>Result  </th>
	</tr>
	<?php  $rec_limit = 10; $sql = "SELECT count(id) FROM candata "; $retval = mysql_query( $sql ); $row = mysql_fetch_array($retval, MYSQL_NUM ); $rec_count = $row[0]; if( isset($_GET['page'] ) ) { $page = $_GET['page']; $offset = $rec_limit * $page ; } else { $page = 0; $offset = 0; } $left_rec = $rec_count - ($page * $rec_limit); $sql="SELECT * from candata where date BETWEEN '".$strt."' AND '".$end."' ORDER BY token ASC "; $abs=mysql_query($sql); while($asp=mysql_fetch_array($abs)) { $id = $id+1; $tkno=$asp['token']; $nme=$asp['name']; $fhnam=$asp['fwdname']; $lic_cat=$asp['liccat']; $tkts=$asp['tktcost']; $sgn_tst=$asp['sgntst']; $rd_tst=$asp['rdtest']; $f_res =$asp['fnlres']; ?>
	<tr>

		<td><?php echo $id?></td>
		<td><?php echo $tkno?></td>
		<td><?php echo $nme?></td>
		<td><?php echo $fhnam?></td>
		<td><?php echo $lic_cat?></td>
		<!--<td>&nbsp&nbsp<?php echo $tkts?></td> -->
		<td><?php echo $sgn_tst?></td>
		<td><?php echo $rd_tst?></td>
		<td><?php echo $f_res?></td>
	<?php  $avf = $f_res; if($avf == "PASS") { $pass_tot = $pass_tot+1; } elseif ($avf == "FAIL") { $fail_tot = $fail_tot+1; } else { $absc_tot = $absc_tot+1; } ?>

	</tr>

	<?php  } ?>

	</table>

	</font>
	<div class="pagi">
	<?php  if($rec_count > $rec_limit) { if($page > 0) { if($left_rec <= $rec_limit) { $last = $page - 1; } else { $last = $page - 1; $page=$page+1; } } else if($page == 0) { $page=$page+1; } } } ?>
	<tr>
	<h2>
		<td>============== Summary Of Test Report ================</td><br>
		<td>Total Fail : <?php echo $fail_tot?></td><br>
		<td>Total Pass : <?php echo $pass_tot?></td><br>
		<td>Total Abscent  :<?php echo $absc_tot?></td><br>
		<td>Total Appear For Test  : <?php echo $id?></td>
	</h2>

	</div>
	<?php  header('refresh: 5; url=report.php'); ?>
</body>
</html>