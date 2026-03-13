<?php
session_start();
require_once('connection.php');
include('Functions.php');

$userID = $_SESSION['loginUserID'];
$sessionID = session_id();

$userLog =  userLog($userID, $sessionID, 'logout');
//unset($_SESSION['loginEmail']);
// remove all session variables

session_unset();

// destroy the session
session_destroy();

?>
<script>
    window.location = "Login.php";

</script>
