<?php
require_once('connection.php');

if(!isset($_SESSION['loginUsername']))
{
	if (!isset($_SESSION['user_id'])) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        // AJAX request → return JSON error
        header('Content-Type: application/json');
        echo json_encode([
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => [],
            "error" => "Not logged in"
        ]);
    } else {
        // Normal page load
        // Avoid infinite loop if already on Login.php
        if (basename($_SERVER['PHP_SELF']) != 'Login.php') {
            header("Location: Login.php");
            exit;
        }
    }
}

}

?>
