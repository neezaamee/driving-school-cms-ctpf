<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 ">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Driving Licence Test System CTP Faisalabad</title>
	<link href="css/newcss.css" rel="stylesheet">
</head>

<body>
	<center>
	<?php  include('files/header.php'); session_start(); echo "<h2>" . $_SESSION['innerHTMLmathNM'] . "</h2>"; echo "<h2> Print Duplicate Token </h2>"; ?>
	</center>
	<div id="stylized" class="myform">

	<form id="form1" id="form1" action="dup-prnt.php" method="POST">

	    <label>Token No
	        <span class="small">For Duplicate Print
	    </label>
		<input type="text" name="name" required><br />
		<br />
		<br />

	    <button type="submit" value="Send" style="margin-top:15px;">Submit</button><br>

		<center><a href='index.php' style='text-decoration:none;color:#ff0099;'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Return To Home</a></center>

		<div class="spacer"></div>

	</form>

	</div> <!-- end of form class -->

			
	<?php  ?>
	
</body>
</html>