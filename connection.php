<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USERNAME'] ?? 'root';
$pass = $_ENV['DB_PASSWORD'] ?? '';
$db   = $_ENV['DB_DATABASE'] ?? 'ds_ctpfsd';
date_default_timezone_set('Asia/Karachi');
$con = mysqli_connect($host, $user, $pass, $db);
if(!$con)
{
	echo "Db Connection Error ".mysqli_error($con) ;
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
