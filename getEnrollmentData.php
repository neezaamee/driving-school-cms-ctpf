
<?php
include 'connection.php'; // Your database connection file
include 'Functions.php';
function getMonthlyAdmissionsData($con, $year)
{
  $monthlyAdmissionsData = [];
  for ($month = 1; $month <= 12; $month++) {
    $admissions = totalAdmissions(null, $month, $year); // Assuming totalAdmissionsMonthYear takes month and year as parameters
    $monthlyAdmissionsData[] = $admissions;
  }
  return $monthlyAdmissionsData;
}

// Assuming you have a valid database connection $con
$currentYear = 2024;
$previousYear = 2023;

header('Content-Type: application/json');
echo json_encode([
  'currentYear' => getMonthlyAdmissionsData($con, $currentYear),
  'previousYear' => getMonthlyAdmissionsData($con, $previousYear)
]);
?>
