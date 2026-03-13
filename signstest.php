<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Driving Licence Test System CTP Faisalabad</title>
	<link href="css/newcss.css" rel="stylesheet">
</head>

<body>
	<center>
		<?php  include('files/header.php'); session_start(); echo "<h2>" . $_SESSION['innerHTMLmathNM'] . "</h2>"; ?>
		<center><h3>Driving Licence Test System(DLTS)</h3></center>
	</center>

	<div id="stylized" class="myform">
	<center>
		<h3> Traffic Road Signs Test... </h3>;
	</center>
	<form id="form1" id="form1" action="signdata.php" method="POST">

    	<label>Token No
        	<span class="small">Add Token No 
    	</label>
		<input type="text" name="name" required>
   		<br />
		<br />

	    <button type="submit" value="Send" style="margin-top:15px;">Submit</button>
	   <!-- <a href='index.php' style='text-decoration:none;color:#ff0099;'>Home</a>"; -->
	    <div class="spacer"></div>
	</form>

</div> <!-- end of form class -->
<center>
<img src='files/test-proces.jpg' border='0' height='300' width='500'>;
</center>
<?php ?>
</body>
</html>