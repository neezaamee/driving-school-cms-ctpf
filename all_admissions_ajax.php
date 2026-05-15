<?php
session_start();
require_once('connection.php');
require_once('sessionSet.php');

header('Content-Type: application/json');

// Ensure we are using the merged database
mysqli_select_db($con, 'ds_ctpfsd_merged');

// Parameters for DataTables
$draw = $_POST['draw'] ?? 1;
$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 10;
$searchValue = $_POST['search']['value'] ?? '';

// Columns for sorting
$columns = [
    0 => 'a.registration',
    1 => 'v.vouchernumber',
    2 => 's.fullname',
    3 => 's.cnic',
    4 => 'sch.location',
    5 => 'c.coursename',
    6 => 'a.admission_date',
    7 => 'c.fee',
    8 => 'a.id'
];

$orderColumnIndex = $_POST['order'][0]['column'] ?? 6;
$orderDir = $_POST['order'][0]['dir'] ?? 'desc';
$orderColumn = $columns[$orderColumnIndex] ?? 'a.admission_date';

// Search filter
$searchQuery = "";
if (!empty($searchValue)) {
    $searchQuery = " AND (s.fullname LIKE '%$searchValue%' 
                      OR s.cnic LIKE '%$searchValue%' 
                      OR a.registration LIKE '%$searchValue%' 
                      OR v.vouchernumber LIKE '%$searchValue%' 
                      OR sch.location LIKE '%$searchValue%') ";
}

// Total records without filtering
$totalQuery = "SELECT COUNT(*) as total FROM admissions";
$totalResult = $con->query($totalQuery);
$totalRecords = $totalResult->fetch_assoc()['total'];

// Total records with filtering for DUPLICATES ONLY
$filteredQuery = "SELECT COUNT(*) as total 
                  FROM admissions a 
                  INNER JOIN students s ON a.idstudent = s.id
                  LEFT JOIN vouchers v ON a.idvoucher = v.id
                  WHERE a.idstudent IN (SELECT idstudent FROM admissions GROUP BY idstudent HAVING COUNT(*) > 1)
                  $searchQuery";
$filteredResult = $con->query($filteredQuery);
$totalRecordsFiltered = $filteredResult->fetch_assoc()['total'];

// Main Query with Pagination - Filtered for students with > 1 admission
$mainQuery = "SELECT a.id, a.registration, a.admission_date, c.fee, 
                     s.fullname, s.cnic, 
                     sch.location as schoolname, 
                     c.coursename,
                     v.vouchernumber
              FROM admissions a
              INNER JOIN students s ON a.idstudent = s.id
              LEFT JOIN schools sch ON a.idschool = sch.id
              LEFT JOIN courses c ON a.idcourse = c.id
              LEFT JOIN vouchers v ON a.idvoucher = v.id
              WHERE a.idstudent IN (SELECT idstudent FROM admissions GROUP BY idstudent HAVING COUNT(*) > 1)
              $searchQuery
              ORDER BY s.cnic ASC, $orderColumn $orderDir
              LIMIT $start, $length";

$result = $con->query($mainQuery);

$data = [];
while ($row = $result->fetch_assoc()) {
    $source = ($row['id'] >= 1000000) ? 
        '<span class="badge badge-secondary">Shared Hosting</span>' : 
        '<span class="badge badge-primary">Local</span>';
    
    $data[] = [
        $row['registration'],
        $row['vouchernumber'] ?? 'N/A',
        $row['fullname'],
        $row['cnic'],
        $row['schoolname'],
        $row['coursename'],
        $row['admission_date'] ? date('d-M-Y', strtotime($row['admission_date'])) : '---',
        number_format($row['fee']),
        $source
    ];
}

$response = [
    "draw" => intval($draw),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalRecordsFiltered),
    "data" => $data
];

echo json_encode($response);
?>
