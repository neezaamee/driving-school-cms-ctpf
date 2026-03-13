<?php
/* $con = mysqli_connect('localhost', 'ctpfsdgop_driving_school_user', 'Nizami@1915', 'ctpfsdgop_driving_school_db');
if (!$con) {
  echo "Db Connection Error " . mysqli_error($con);
} else {
  echo "";
} */


$con = mysqli_connect('localhost','root','','ds_ctpfsd');
if(!$con)
{
	echo "Db Connection Error ".mysqli_error($con) ;
}
else
{
	echo "";
}
/* Set Pakistan timezone */
$con->query("SET time_zone = '+05:00'");
function CleanData($Data)
{
  global $con;
  $Data = trim($Data);
  // Ensure we safely escape data for basic database queries
  $Data = mysqli_real_escape_string($con, $Data);
  return $Data;
}
