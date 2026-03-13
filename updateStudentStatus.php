<?php
session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $studentID = $_POST['studentID'];
  $status = $_POST['status'];

  // Update the student's status
  $updateQuery = "UPDATE admissions SET status = $status WHERE idstudent = $studentID";
  if (mysqli_query($con, $updateQuery)) {
    $_SESSION['success'] = "Student status updated successfully.";
  } else {
    $_SESSION['error'] = "Failed to update student status.";
  }

  header('Location: activeStudents.php');
  exit();
}
