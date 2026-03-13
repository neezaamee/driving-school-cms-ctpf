<?php
// Include necessary files and start session if needed
require 'connection.php';
require 'Functions.php';
require 'sessionSet.php';

// Define columns for sorting
$columns = array(
    0 => 'id',
    1=> 'idschool',
    2 => 'registration',
    3 => 'admission_date',
    // Add more columns as needed
);

// Prepare base query
if (!isAdmin()) {
    $query = "SELECT * FROM admissions WHERE idschool = '$userSchoolID'";
} else {
    $query = "SELECT * FROM admissions";
}

// Implement searching
if (!empty($searchValue)) {
    $query .= " AND (registration LIKE '%$searchValue%' OR ... )"; // Add relevant columns for search
}

// Implement ordering
$query .= " ORDER BY " . $columns[$orderColumn] . " " . $orderDir;

// Fetch filtered records
$result = mysqli_query($con, $query);
$totalData = mysqli_num_rows($result);

// Fetch records for current page
$query .= " LIMIT $start, $length";
$result = mysqli_query($con, $query);

$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Prepare data in JSON format expected by DataTables
        $subArray = array();
        $subArray[] = ++$start; // Incremental index
        if (isAdmin()) {
            $subArray[] = schoolByID($row['idschool'])->location; // Example of additional data fetching
        }
        $subArray[] = $row['registration'];
        $subArray[] = date('d/m/Y', strtotime($row['admission_date'])); // Format date
        // Add more columns as per your table structure
        $data[] = $subArray;
    }
}

// Prepare JSON response
$json_data = array(
    "draw" => intval($_POST['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalData),
    "data" => $data
);

echo json_encode($json_data);
