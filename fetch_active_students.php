<?php
if (isset($_POST['PHPSESSID'])) {
    session_id($_POST['PHPSESSID']);
}
session_start();

header('Content-Type: application/json; charset=utf-8');
if (ob_get_length()) { ob_end_clean(); }

require_once('connection.php');
require_once('Functions.php');

if (!isset($_SESSION['loginUserID'])) {
    echo json_encode(["draw" => 0, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => [], "error" => "Not logged in"]);
    exit;
}

$User = userByID($_SESSION['loginUserID']);
$userSchoolID = $User->idschool;
$isAdmin = isAdmin();

$request = $_POST;

// --- Column map (must match <thead> in activeStudents.php) ---
$columns = [];
$columns[] = 'a.id'; // 0: #
if ($isAdmin) { $columns[] = 'sc.location'; } // 1: School
$columns[] = 'a.registration'; // 2: Registration
$columns[] = 'a.created_at'; // 3: Admission Date
$columns[] = 's.fullname'; // 4: Name
$columns[] = 'g.name'; // 5: Gender
$columns[] = 's.fathername'; // 6: Guardian
$columns[] = 's.dob'; // 7: DOB
$columns[] = 's.cnic'; // 8: CNIC
$columns[] = 's.address'; // 9: Address
$columns[] = 's.phone'; // 10: Phone
$columns[] = 'c.coursename'; // 11: Course
$columns[] = 'v.discount'; // 12: Discount
$columns[] = 'v.grand_total'; // 13: Fee Collected
$columns[] = 'f.paid_date'; // 14: Paid Date
$columns[] = 'a.pickndrop'; // 15: Pick n Drop
$columns[] = 's.cnic'; // 16: Photo
$columns[] = 'a.id'; // 17: Action

// --- SELECT ---
$select = "SELECT 
            a.id as admissionID, a.registration, a.pickndrop, a.idstudent, a.idcourse, 
            a.idvoucher, a.idschool, a.created_at as admission_ts,
            s.fullname, s.fathername, s.dob, s.cnic, s.address, s.phone, s.gender,
            g.name as gender_name,
            c.coursename,
            v.discount, v.grand_total,
            f.paid_date,
            sc.location as schoolLocation";

// --- FROM + JOINS ---
$from = " FROM admissions a
          INNER JOIN students s ON a.idstudent = s.id
          INNER JOIN courses c ON a.idcourse = c.id
          INNER JOIN vouchers v ON a.idvoucher = v.id
          INNER JOIN fee_payments f ON a.idvoucher = f.idvoucher
          INNER JOIN schools sc ON a.idschool = sc.id
          INNER JOIN gender g ON s.gender = g.id";

// --- WHERE ---
$where = " WHERE a.status = 0";
if (!$isAdmin) {
    $where .= " AND a.idschool = " . (int)$userSchoolID;
}

// --- Searching ---
$searchVal = trim($request['search']['value'] ?? '');
if ($searchVal !== '') {
    $s = mysqli_real_escape_string($con, $searchVal);
    $where .= " AND (
        a.registration LIKE '%$s%' OR
        s.fullname LIKE '%$s%' OR
        s.fathername LIKE '%$s%' OR
        s.cnic LIKE '%$s%' OR
        s.address LIKE '%$s%' OR
        s.phone LIKE '%$s%' OR
        c.coursename LIKE '%$s%' OR
        sc.location LIKE '%$s%'
    )";
}

// --- Total counts ---
$totalRes = mysqli_query($con, "SELECT COUNT(*) as cnt " . $from . " WHERE a.status = 0" . (!$isAdmin ? " AND a.idschool = " . (int)$userSchoolID : ""));
$totalData = mysqli_fetch_assoc($totalRes)['cnt'];

$filteredRes = mysqli_query($con, "SELECT COUNT(*) as cnt " . $from . $where);
$totalFiltered = mysqli_fetch_assoc($filteredRes)['cnt'];

// --- Ordering ---
$orderColIndex = intval($request['order'][0]['column'] ?? 0);
$orderDir = ($request['order'][0]['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';
$orderCol = $columns[$orderColIndex] ?? 'a.id';

// --- Paging ---
$start = intval($request['start'] ?? 0);
$length = intval($request['length'] ?? 10);

// --- Final Query ---
$sql = $select . $from . $where . " ORDER BY $orderCol $orderDir LIMIT $start, $length";
$res = mysqli_query($con, $sql);

$data = [];
$serial = $start + 1;

while ($Row = mysqli_fetch_assoc($res)) {
    $sub = [];
    $sub[] = $serial++;
    if ($isAdmin) {
        $sub[] = $Row['schoolLocation'];
    }
    $sub[] = "<strong>" . $Row['registration'] . "</strong>";
    $sub[] = date('d/m/Y', strtotime($Row['admission_ts']));
    $sub[] = strtoupper($Row['fullname']);
    $sub[] = $Row['gender_name'];
    $sub[] = $Row['fathername'];
    $sub[] = date('d-M-Y', strtotime($Row['dob']));
    $sub[] = $Row['cnic'];
    $sub[] = $Row['address'];
    $sub[] = $Row['phone'];
    $sub[] = '<span class="badge badge-info">' . $Row['coursename'] . '</span>';
    $sub[] = number_format($Row['discount']);
    $sub[] = number_format($Row['grand_total']);
    $sub[] = ($Row['paid_date']) ? date('d-m-Y', strtotime($Row['paid_date'])) : 'N/A';
    $sub[] = ($Row['pickndrop'] == '1000') ? "Yes" : "No";

    // Photo
    $photoPath = 'StudentImages/' . $Row['cnic'] . '.jpeg';
    if (!file_exists($photoPath)) { $photoPath = 'StudentImages/' . $Row['cnic'] . '.JPG'; }
    
    // Gender-blind fallback
    $defaultAvatar = ($Row['gender'] == 2) ? 'dist/img/avatar2.png' : 'dist/img/avatar5.png';
    
    if (!file_exists($photoPath)) { $photoPath = $defaultAvatar; }
    $sub[] = '<img width="60px" class="img-thumbnail" src="'.$photoPath.'" onerror="this.src=\''.$defaultAvatar.'\'">';

    // Action
    $action = '
    <div class="btn-group">
        <form method="post" action="updateStudentStatus.php" onsubmit="return confirm(\'Are you sure you want to mark this student as Passed Out?\');">
          <input type="hidden" name="studentID" value="'.$Row['idstudent'].'">
          <button type="submit" name="status" value="1" class="btn btn-success btn-xs" title="Passed Out">
            <i class="fas fa-check-circle"></i>
          </button>
        </form>
        <a href="viewStudent.php?id='.$Row['idstudent'].'" class="btn btn-info btn-xs ml-1" title="View Profile">
          <i class="fas fa-eye"></i>
        </a>
        <a href="#" class="btn btn-danger btn-xs ml-1" title="Delete" data-href="deleteStudent.php?admissionID='.$Row['idstudent'].'&csrf='.generate_csrf_token().'" data-toggle="modal" data-target="#confirm-delete">
          <i class="fas fa-trash"></i>
        </a>
    </div>';
    $sub[] = $action;

    $data[] = $sub;
}

echo json_encode([
    "draw" => intval($request['draw'] ?? 0),
    "recordsTotal" => (int)$totalData,
    "recordsFiltered" => (int)$totalFiltered,
    "data" => $data
]);
exit;
