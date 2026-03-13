<?php
require_once('connection.php');

$sql = "TRUNCATE TABLE `admissions`";
$sql1 = "TRUNCATE TABLE `expenses`";
$sql2 = "TRUNCATE TABLE `fee`";
$sql3 = "TRUNCATE TABLE `income`";
$sql4 = "TRUNCATE TABLE `students`";
$sql5 = "TRUNCATE TABLE `userlog`";
$sql6 = "TRUNCATE TABLE `usershistory`";
$sql7 = "CREATE TABLE IF NOT EXISTS fee2 (
id INT(200) AUTO_INCREMENT PRIMARY KEY,
`idadmission` int(200) NOT NULL,
  `coursefee` int(200) NOT NULL,
  `misc` int(200) NOT NULL,
  `discount` int(200) NOT NULL,
  `totalpayable` int(200) NOT NULL,
  `received` int(200) NOT NULL
)";
$sql8 = "ALTER TABLE `fee2` ADD email varchar(23)";


$con->query($sql);
$con->query($sql1);
$con->query($sql2);
$con->query($sql3);
$con->query($sql4);
$con->query($sql5);
$con->query($sql6);
$con->query($sql7);
$con->query($sql8);
            
?>
