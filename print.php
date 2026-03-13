<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/demo.css" />
	<link rel="stylesheet" href="css/style.css" /> 

</head>
<body onload="self.print()">
<div class="content">
<?php
include('config.php');
$ids=$_REQUEST['id'];
$sg="SELECT * FROM chalan where id=".$ids;
$sq=mysql_query($sg);
$bcs=mysql_fetch_array($sq);

$t_o_vec=$bcs['type_of_vechicle'];
$V_d=$bcs['v_driver'];
$son=$bcs['son_of'];
$vech_no=$bcs['vehicle_no'];
$nic=$bcs['nic'];
$l_no=$bcs['licenses_no'];
$violence=$bcs['violence_list'];
$date=$bcs['date'];
$tim=$bcs['time'];

?>
<div class="chalanprint">
<p class="dat">Date:<?=$date?></p>
<p class="dat">Time:<?=$tim?></p>
<table class="hovertable">
<tr><th>Type of Vechicle</th><td><?=$t_o_vec?></td></tr>
<tr><th>Vechicle Driver</th><td><?=$V_d?></td></tr>
<tr><th>Son of</th><td><?=$son?></td></tr>
<tr><th>Vechicle No</th><td><?=$vech_no?></td></tr>
<tr><th>NIC</th><td><?=$nic?></td></tr>


<?php
$violence=explode(",",$violence);
$plus=0;
foreach ($violence as $value) {
   $op="Select * from infringement where id=".$value;
   $sbp=mysql_query($op);
   $ms=mysql_fetch_array($sbp);
   $vlist=$ms['infringement'];
   $jurmana=$ms[$t_o_vec];
   $plus+=$jurmana;
	if($jurmana >0)
	{
	?>
	<tr><th><?=$vlist?></th><td><?=$jurmana?></td></tr>
	<?php
	}
   }
  ?>
  
		<tr><th>Total Fees</th><td><?=$plus?></td></tr>
</table>
</div>

<a class="buttong" href="chalan_display.php"><< Back</a>
</div>
</body>
</html>