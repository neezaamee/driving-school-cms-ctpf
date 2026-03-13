<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Driving Test System CTP Faisalabad</title>
	<link href="css/newcss.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
</head>
<body>

<center>
	<?php  include('connection.php'); include('files/header.php'); session_start(); echo "<h2>" . $_SESSION['innerHTMLmathNM'] . "</h2>"; echo "<h2> Print Test For Licence Report </h2>"; ?>
	</center>
	<div id="stylized" class="myform">
	<center><h4> Daily Detail and Summery Report</h4></center>
	<div class="content">

	<form id="form1" action="report_page.php" method="POST" class="basic-grey">
	    <label>Start Date
	        <span class="small">Start Report Date 
	    </label>	
		<input type="date" name="start" required><br />
		<label>End Date
	        <span class="small">End Report Date /> 
	    </label>
		<input type="date" name="end" required><br />
		<label>Non Commercial  </label>
	    <input type="radio" name="ans" value="ans1" required /><br />
		<label>Commercial LTV</label>
	    <input type="radio" name="ans" value="ans2"  /><br />
	    <label>Commercial HTV</label>
	    <input type="radio" name="ans" value="ans3"  /><br />
		<br />
		<br />
	    <button type="submit" value="Send" style="margin-top:15px;">Submit</button>
		<div class="spacer"></div>
	</form>

	</div> <!-- end of form class -->
	</div>
</body>
</html>