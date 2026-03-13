<?php
require_once('connection.php');
require_once('Functions.php');

// Get the parameters from DataTables
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];
$firstDate = $_POST['firstDate'];
$secondDate = $_POST['secondDate'];

// Build the SQL query
$query = "SELECT * FROM admissions WHERE DATE(created_at) BETWEEN '$firstDate' AND '$secondDate'";

if ($searchValue) {
  $query .= " AND (registration LIKE '%$searchValue%' OR name LIKE '%$searchValue%')";
}

// Count total records
$result = mysqli_query($con, $query);
$totalRecords = mysqli_num_rows($result);

// Apply pagination
$query .= " LIMIT $start, $length";
$result = mysqli_query($con, $query);

// Fetch the data
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

// Prepare the response
$response = [
  "draw" => intval($draw),
  "recordsTotal" => $totalRecords,
  "recordsFiltered" => $totalRecords,
  "data" => $data
];

echo json_encode($response);
