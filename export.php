<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Driving Test System CTP Faisalabad</title>
</head>

<body>

<?php  $dbhost = 'localhost'; $dbuser = 'root'; $dbpass = ''; $FileName='/backup/rsts_'.date('m-d-Y_hia').'.sql'; echo $FileName; $conn = mysql_connect($dbhost, $dbuser, $dbpass); if(! $conn ) { die('Could not connect: ' . mysql_error()); } $table_name = "candata"; $backup_file = $FileName; $sql = "SELECT * INTO OUTFILE '$backup_file' FROM $table_name"; mysql_select_db('rsts'); $retval = mysql_query( $sql, $conn ); if(! $retval ) { die('Could not take data backup: ' . mysql_error()); } echo "Backedup  data successfully\n"; mysql_close($conn); ?>

<?php  header('location:index.php'); ?>
</body>