<?php  date_default_timezone_set("Asia/Karachi"); $todayDate = date("d-m-Y"); $entrytime = date("h:i:s"); ?>
<?php  include('files/header.php'); include('connection.php'); $query = "SELECT id FROM candata ORDER BY id DESC LIMIT 1"; $result = mysql_query($query) or die(mysql_error()); $row = mysql_fetch_array($result); $id = $row['id']; $abtno = $id + 1; $adate = $todayDate; $acnic = $_POST['cnic']; $alpno = $_POST['lpno']; $alpdt = $_POST['lpdt']; $aname = $_POST['name']; $afh_name = $_POST['fh_name']; $aaddr = $_POST['addr']; $acity = $_POST['city']; $aphn = $_POST['phn']; $aemail = $_POST['email']; $abgrp = $_POST['bgrp']; $cost_tkt = $_POST['cost_tkt']; $subject = $_POST['subject']; $lttdate=date("Y-m-d", strtotime($alpdt)); $aadate=date("Y-m-d", strtotime($todayDate)); $subj=""; foreach($subject as $entry){ $subj .= $entry.","; } $sql = mysql_query("insert into candata(token, date, ent_time, name, fwdname, address, city, cnic, bgroup, phone, email, lpno, lpdate, tktcost, liccat) values ('$abtno', '$aadate', '$entrytime', '$aname', '$afh_name', '$aaddr', '$acity', '$acnic', '$abgrp', '$aphn', '$aemail', '$alpno', '$lttdate', '$cost_tkt', '$subj')"); ?>

<body>
<body onload="self.print()">
<center>
<div class="chalanprint"> <center>

<h3><p class="dat">City Traffic Police Faisalabad</p></h3>
<h3><p class="dat">Driving Test System </p></h3>
<h2><p class="dat">Token No:<?php echo $abtno?></p></h2>
<table class="hovertable">
	<tr><th>CNIC No : </th><td><?php echo $acnic?></td></tr>
	<tr><th>Date of Test : </th><td><?php echo $adate?></td></tr>
	<tr><th>Time of Test : </th><td><?php echo $entrytime?></td></tr>
	<tr><th>Candidate Name : </th><td><?php echo $aname?></td></tr>
	<tr><th>Father/Husband : </th><td><?php echo $afh_name?></td></tr>
	<tr><th>Cost of Tickets : </th><td><?php echo $cost_tkt?></td></tr>
</table>
<h4><p class="dat">Applied for :<?php echo $subj?></p></h4>
<table class="hovertable">
	<tr><th>Your Data is Entered Please </th><td></tr>
	<tr><th>GoTO Road Signs Test Counter </th><td></td></tr>
	<tr><th>For Verifaction GoTO </th><td></td></tr>
	<tr><th>http://dlims.punjab.gov.com</th><td></td></tr>
	<tr><th>Powered By:Computer Masters Pakistan</th><td></td></tr>
	<tr><th>http://www.ncml.pk http://ncml.pk</th><td></td></tr>
</center></table>

</div>

</body>

<script>
function myFunction() {
    window.print();
}
</script>

<?php  header('refresh: 5; url=new_candidate.php'); ?>