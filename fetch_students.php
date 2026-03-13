<?php
// --- Session Handling ---
if (isset($_POST['PHPSESSID'])) {
    session_id($_POST['PHPSESSID']);
}
session_start();
error_log("SESSION in fetch_students.php: " . print_r($_SESSION, true));

header('Content-Type: application/json; charset=utf-8');
// clear accidental output
if (ob_get_length()) { ob_end_clean(); }

require_once('connection.php');   // defines $con
require_once('Functions.php');    // should include isAdmin()

// --- Check login ---
if (!isset($_SESSION['loginUserID'])) {
    echo json_encode([
        "draw" => 0,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => [],
        "error" => "Not logged in"
    ]);
    exit;
}

// --- Debug session data ---
error_log("User School ID: " . ($_SESSION['school_id'] ?? 'NOT SET'));
error_log("User ID: " . ($_SESSION['loginUserID'] ?? 'NOT SET'));

// --- DataTables request ---
$request = $_POST + [];

// --- Better Admin Check ---
$isAdmin = false;
if (function_exists('isAdmin')) {
    $isAdmin = isAdmin();
    error_log("isAdmin() function result: " . ($isAdmin ? 'TRUE' : 'FALSE'));
} else {
    error_log("isAdmin() function NOT FOUND");
    // Fallback: check session for admin flag
    $isAdmin = ($_SESSION['loginRole'] ?? $_SESSION['loginRole'] ?? 'loginRole') === 1;
}

$User = userByID(getUserID());
$userSchoolID = $User->idschool ?? null;
error_log("Final isAdmin: " . ($isAdmin ? 'TRUE' : 'FALSE'));
error_log("User School ID: " . ($userSchoolID ?? 'NULL'));

// --- Column map (must match <thead>) ---
$orderColumns = [];
$orderColumns[] = 'a.id';                   // #
if ($isAdmin) { 
    $orderColumns[] = 's.location'; // School (admin only)
    error_log("Admin mode: School column included");
} else {
    error_log("Non-admin mode: School column excluded");
}
$orderColumns[] = 'a.registration';
$orderColumns[] = 'a.created_at';
$orderColumns[] = 'st.fullname';
$orderColumns[] = 'g.name'; // gender
$orderColumns[] = 'st.fathername';
$orderColumns[] = 'st.dob';
$orderColumns[] = 'st.cnic';
$orderColumns[] = 'st.address';
$orderColumns[] = 'st.phone';
$orderColumns[] = 'c.coursename';
$orderColumns[] = 'v.grand_total';
$orderColumns[] = 'v.discount';
$orderColumns[] = 'v.prospectus';
$orderColumns[] = 'a.pickndrop';
$orderColumns[] = 'st.cnic'; // for photo
$orderColumns[] = 'a.id';    // action button

// --- SELECT ---
$select = "SELECT a.id, a.registration, a.created_at, a.pickndrop,
                  st.fullname, st.fathername, st.dob, st.cnic, st.address, st.phone, st.gender,
                  g.name AS gender_name,
                  c.coursename, v.grand_total, v.discount, v.prospectus";
if ($isAdmin) {
    $select .= ", s.location AS school_location";
    error_log("SELECT includes school_location");
}

// --- FROM + JOINS ---
$from = " FROM admissions a
          JOIN students st ON a.idstudent = st.id
          JOIN courses c ON a.idcourse = c.id
          JOIN vouchers v ON a.idvoucher = v.id
          JOIN gender g ON st.gender = g.id";
if ($isAdmin) {
    $from .= " JOIN schools s ON a.idschool = s.id";
    error_log("FROM includes schools join");
} else {
    // Non-admin should still have school ID for filtering
    $from .= " JOIN schools s ON a.idschool = s.id";
    error_log("FROM includes schools join for non-admin (filtering)");
}

// --- WHERE ---
$where = " WHERE 1=1 ";
if (!$isAdmin && $userSchoolID) {
    $where .= " AND a.idschool = '" . mysqli_real_escape_string($con, $userSchoolID) . "' ";
    error_log("Non-admin WHERE clause applied: school_id = " . $userSchoolID);
} else if ($isAdmin) {
    error_log("Admin mode: No school filter applied");
} else {
    error_log("WARNING: Non-admin but no school_id found in session");
}

// --- Searching ---
$searchVal = trim($request['search']['value'] ?? '');
if ($searchVal !== '') {
    $s = mysqli_real_escape_string($con, $searchVal);
    $where .= " AND (
        a.registration LIKE '%$s%' OR
        st.fullname LIKE '%$s%' OR
        st.fathername LIKE '%$s%' OR
        st.cnic LIKE '%$s%' OR
        st.address LIKE '%$s%' OR
        st.phone LIKE '%$s%' OR
        c.coursename LIKE '%$s%'";
    if ($isAdmin) { 
        $where .= " OR s.location LIKE '%$s%'";
    }
    $where .= " ) ";
    error_log("Search applied: " . $searchVal);
}

// --- Record counts ---
$totalSql = "SELECT COUNT(*) AS cnt FROM admissions a";
$totalWhere = "";
if (!$isAdmin && $userSchoolID) {
    $totalWhere = " WHERE a.idschool = '" . mysqli_real_escape_string($con, $userSchoolID) . "'";
}
$totalSql .= $totalWhere;
error_log("Total SQL: " . $totalSql);

$totalRes = mysqli_query($con, $totalSql);
$totalData = ($totalRes && $r = mysqli_fetch_assoc($totalRes)) ? intval($r['cnt']) : 0;
error_log("Total records: " . $totalData);

$countSql = "SELECT COUNT(*) AS cnt " . $from . $where;
error_log("Filtered count SQL: " . $countSql);
$countRes = mysqli_query($con, $countSql);
$totalFiltered = ($countRes && $r = mysqli_fetch_assoc($countRes)) ? intval($r['cnt']) : 0;
error_log("Filtered records: " . $totalFiltered);

// --- Ordering ---
$orderColIndex = intval($request['order'][0]['column'] ?? 0);
$orderDir = ($request['order'][0]['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';
$orderCol = $orderColumns[$orderColIndex] ?? 'a.id';
error_log("Order by: " . $orderCol . " " . $orderDir);

// --- Paging ---
$start  = max(0, intval($request['start'] ?? 0));
$length = intval($request['length'] ?? 10);
if ($length <= 0) { $length = 10; }
error_log("Paging: start=" . $start . ", length=" . $length);

// --- Final query ---
$dataSql = $select . $from . $where . " ORDER BY $orderCol $orderDir LIMIT $start, $length";
error_log("Final data SQL: " . $dataSql);
$dataRes = mysqli_query($con, $dataSql);

if (!$dataRes) {
    error_log("SQL Error: " . mysqli_error($con));
    echo json_encode([
        "draw" => intval($request['draw'] ?? 0),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => [],
        "error" => "Database error: " . mysqli_error($con)
    ]);
    exit;
}

// --- Build data rows ---
$data = [];
$serial = $start + 1;
while ($r = mysqli_fetch_assoc($dataRes)) {
    $row = [];
    $row[] = $serial++; // serial #
    if ($isAdmin) {
        $row[] = $r['school_location'] ?? '';
    }
    $row[] = $r['registration'] ?? '';
    $row[] = !empty($r['created_at']) ? date('d/m/Y', strtotime($r['created_at'])) : '';
    $row[] = $r['fullname'] ?? '';
    $row[] = $r['gender_name'] ?? '';
    $row[] = $r['fathername'] ?? '';
    $row[] = $r['dob'] ?? '';
    $row[] = $r['cnic'] ?? '';
    $row[] = $r['address'] ?? '';
    $row[] = "0" . ($r['phone'] ?? '');
    $row[] = $r['coursename'] ?? '';
    $row[] = $r['grand_total'] ?? '';
    $row[] = $r['discount'] ?? '';
    $row[] = $r['prospectus'] ?? '';
    $row[] = ($r['pickndrop'] == '1000') ? 'Yes' : 'No';

    // Photo
    $cnic_for_img = $r['cnic'] ?? 'no-photo';
    $basePath = "StudentImages/{$cnic_for_img}";
    $imgPath = "";

    // Try jpg first, then jpeg
    if (file_exists("{$basePath}.jpg")) {
        $imgPath = "{$basePath}.jpg";
    } elseif (file_exists("{$basePath}.jpeg")) {
        $imgPath = "{$basePath}.jpeg";
    } elseif (file_exists("{$basePath}.JPG")) {
        $imgPath = "{$basePath}.JPG";
    }

    // Gender-based fallback
    $defaultAvatar = ($r['gender'] == 2) ? 'dist/img/avatar2.png' : 'dist/img/avatar5.png';
    
    if (empty($imgPath)) {
        $imgPath = $defaultAvatar;
    }

    $row[] = '<img src="'.$imgPath.'" width="60" class="img-thumbnail" alt="photo" onerror="this.src=\''.$defaultAvatar.'\'">';

    // action
    $row[] = '<button class="btn btn-outline-danger btn-sm" data-href="deleteStudent.php?admissionID='.$r['id'].'" data-toggle="modal" data-target="#confirm-delete">Delete</button>';

    $data[] = $row;
}

error_log("Returning " . count($data) . " records");
// --- Final JSON output ---
echo json_encode([
    "draw"            => intval($request['draw'] ?? 0),
    "recordsTotal"    => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data"            => $data
]);
exit;
