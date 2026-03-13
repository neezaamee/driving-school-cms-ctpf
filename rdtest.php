<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Driving Test System CTP Faisalabad</title>
	<link href="css/newcss.css" rel="stylesheet">
</head>

<body>
	<?php  include('files/header.php'); ?>
	<center>
	<?php  session_start(); echo "<h2>" . $_SESSION['innerHTMLmathNM'] . "</h2>"; ?>
	</center>
	<center><h3>Driving Licence Test System(DLTS)</h3></center>
	<div id="stylized" class="myform">
		
		<form id="form1" id="form1" action="rddata.php" method="POST">
		    <label>Token No
		        <span class="small">Add Token No 
		    </label>
			<input type="text" name="name" required><br />
			
			<label>Pass in Road Test</label>
		    <input type="radio" name="ans" value="ans1" required /><br />

			<label>Fail in Road Test</label>
		    <input type="radio" name="ans" value="ans2"  /><br />
			<br />
			<br />

		    <button type="submit" value="Send" style="margin-top:15px;">Submit</button>
		    
		<div class="spacer"></div>

		</form>

	</div> <!-- end of form class -->
	
</body>
</html>