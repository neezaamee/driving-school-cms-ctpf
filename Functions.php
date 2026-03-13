<?php
require_once('connection.php');
require_once('sessionSet.php');

date_default_timezone_set("Asia/Karachi");

function userLog($userID, $sessionID, $action)
{
    global $con;
    $sql = "INSERT INTO userlog (idusers, session, action) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $userID, $sessionID, $action);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//User Functions
function isAdmin()
{
  if (isset($_SESSION['loginRole']) && $_SESSION['loginRole'] == 1) {
    return true;
  } else {
    return false;
  }
}
function isIncharge()
{
  if (isset($_SESSION['loginRole']) && $_SESSION['loginRole'] == 2) {
    return true;
  } else {
    return false;
  }
}
function isDEO()
{
  if (isset($_SESSION['loginRole']) && $_SESSION['loginRole'] == 3) {
    return true;
  } else {
    return false;
  }
}
function getUserID()
{
  if (isset($_SESSION['loginUserID'])) {
    return $_SESSION['loginUserID'];
  } else {
    echo "session not set";
  }
}
function userByID($userID)
{
  global $con;
  $sql = "SELECT * FROM users WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $userID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $user;
}
function userByStaffID($staffID)
{
  global $con;
  $sql = "SELECT * FROM users WHERE idstaff = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $staffID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $numRows = mysqli_num_rows($Result);
  mysqli_stmt_close($stmt);
  return $numRows;
}
//School Functioins
function schoolByID($schoolID)
{
  global $con;
  $sql = "SELECT * FROM schools WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $schoolID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $school = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $school;
}

function cityByID($cityID)
{
  global $con;
  $sql = "SELECT * FROM cities WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $cityID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $city = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $city;
}
function feeByVoucherID($voucherID)
{
  global $con;
  $sql = "SELECT * FROM fee_payments WHERE idvoucher = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $voucherID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $FeePayment = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $FeePayment;
}
/* function schoolsList(){
    global $con;
    $Q2 = "SELECT * FROM schools WHERE id != 1";
    $QR2 = mysqli_query($con, $Q2);
    while ($data = mysqli_fetch_array($QR2)) {
        echo "<option value='" . $data['id'] . "'>" . $data['location'] . "</option>";
    }
} */

function studentByID($studentID)
{
  global $con;
  $sql = "SELECT * FROM students WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $studentID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $student = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $student;
}
function studentCategoryByID($studentCategoryID)
{
  global $con;
  $sql = "SELECT * FROM studentcategories WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $studentCategoryID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $studentCategory = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $studentCategory;
}
/*function students_copyByID($studentID){
    global $con;
    $sql = "SELECT * FROM students WHERE id = '$studentID'";
    $Result = mysqli_query($con,$sql);
    $student = mysqli_fetch_object($Result);
    return $student; 
}*/
//Student Functions
function studentsByCNIC($CNIC)
{
  global $con;
  $sql = "SELECT * FROM students WHERE cnic = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "s", $CNIC);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $student = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $student;
}
function findStudentByCNIC($CNIC)
{
  global $con;
  $sql = "SELECT * FROM students WHERE cnic = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "s", $CNIC);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $numRows = mysqli_num_rows($Result);
  mysqli_stmt_close($stmt);
  return $numRows;
}
function findAdmissionByStudentID($studentID)
{
  global $con;
  $sql = "SELECT * FROM admissions WHERE idstudent = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $studentID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $numRows = mysqli_num_rows($Result);
  mysqli_stmt_close($stmt);
  return $numRows;
}
function admissionByStudentID($studentID)
{
  global $con;
  $sql = "SELECT * FROM admissions WHERE idstudent = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $studentID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Admission = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $Admission;
}

function findAdmissionByVoucherID($voucherID)
{
  global $con;
  $sql = "SELECT * FROM admissions WHERE idvoucher = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $voucherID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $data = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $data;
}

function feePaymentByVoucherID($voucherID)
{
  global $con;
  $sql = "SELECT * FROM fee_payments WHERE idvoucher = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $voucherID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $data = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $data;
}
function admissionByRegistration($Registration)
{
  global $con;
  $sql = "SELECT * FROM admissions WHERE registration = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "s", $Registration);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Admission = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $Admission;
}
function bloodByID($ID)
{
  global $con;
  $sql = "SELECT * FROM blood WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $ID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $user;
}
function bankByID($ID)
{
  global $con;
  $sql = "SELECT * FROM banks WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $ID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Bank = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $Bank;
}
function expenseByID($expenseID)
{
  global $con;
  $sql = "SELECT * FROM expenses WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $expenseID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $expense = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $expense;
}
function expenseTypeByID($expenseID)
{
  global $con;
  $sql = "SELECT * FROM expensetypes WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $expenseID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $expense = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $expense;
}
function instructorBySchoolID($schoolID)
{
  global $con;
  $sql = "SELECT * FROM staff WHERE idschool = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $schoolID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Instructor = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $Instructor;
}
function admissionByID($admissionID)
{
  global $con;
  $sql = "SELECT * FROM admissions WHERE idadmission = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $admissionID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Admission = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $Admission;
}

function courseByID($courseID)
{
  global $con;
  $sql = "SELECT * FROM courses WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $courseID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Course = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $Course;
}
function userTypesByID($ID)
{
  global $con;
  $sql = "SELECT * FROM usertypes WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $ID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $userTypes = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $userTypes;
}
function staffByID($staffID)
{
  global $con;
  $sql = "SELECT * FROM staff WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $staffID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Staff = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $Staff;
}
function typeStaffByID($typeStaffID)
{
  global $con;
  $sql = "SELECT * FROM typestaff WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $typeStaffID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $typeStaff = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $typeStaff;
}
function voucherByID($voucherID)
{
  global $con;
  $sql = "SELECT * FROM vouchers WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $voucherID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Voucher = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $Voucher;
}

function voucherByNo($voucherNo)
{
  global $con;
  $sql = "SELECT * FROM vouchers WHERE vouchernumber = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "s", $voucherNo);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Voucher = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  if ($Voucher) {
    return $Voucher;
  } else {
    return false;
  }
}
function voucherByStudentID($studentID)
{
  global $con;
  $sql = "SELECT * FROM vouchers WHERE idstudent = ? AND status = 1 ORDER BY id DESC Limit 1";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $studentID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Voucher = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  if ($Voucher) {
    return $Voucher;
  } else {
    return false;
  }
}
function feePaymentByID($ID)
{
  global $con;
  $sql = "SELECT * FROM fee_payments WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $ID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $feePayment = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  return $feePayment;
}
function genderByID($genderID)
{
  global $con;
  $sql = "SELECT * FROM gender WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $genderID);
  mysqli_stmt_execute($stmt);
  $Result = mysqli_stmt_get_result($stmt);
  $Gender = mysqli_fetch_object($Result);
  mysqli_stmt_close($stmt);
  if ($Gender) {
    return $Gender;
  } else {
    return false;
  }
}
function schoolsList($defaultId = null, $condition = "WHERE status = 1 AND id != 1")
{
  global $con;
  // Construct the SQL query
  $query = "SELECT * FROM schools $condition";

  // Execute the query
  $result = mysqli_query($con, $query);

  // Check if query was successful
  if (!$result) {
    // Handle query error (you might want to improve error handling here)
    return "<option>Error fetching schools</option>";
  }

  // Initialize variable to store generated options
  $options = "";

  // Fetch data and generate <option> tags
  while ($data = mysqli_fetch_array($result)) {
    // Check if the current school's id matches the defaultId
    $selected = ($data['id'] == $defaultId) ? "selected" : "";
    $options .= "<option value='" . $data['id'] . "' $selected>" . $data['location'] . "</option>";
  }

  // Free result set
  mysqli_free_result($result);

  // Return the generated options
  return $options;
}
function studentCategoryList()
{
  global $con;
  // Construct the SQL query
  $query = "SELECT * FROM studentcategories";

  // Execute the query
  $result = mysqli_query($con, $query);

  // Check if query was successful
  if (!$result) {
    // Handle query error (you might want to improve error handling here)
    return "<option>Error fetching schools</option>";
  } else {
    $resultList = $result;
  }

  // Free result set
  mysqli_free_result($result);

  // Return the generated options
  return $resultList;
}
function expenseTypeList($defaultId = null, $condition = "WHERE status = 1")
{
  global $con;
  // Construct the SQL query
  $query = "SELECT * FROM expensetypes $condition";

  // Execute the query
  $result = mysqli_query($con, $query);

  // Check if query was successful
  if (!$result) {
    // Handle query error (you might want to improve error handling here)
    return "<option>Error fetching Expense Types</option>";
  }

  // Initialize variable to store generated options
  $options = "";

  // Fetch data and generate <option> tags
  while ($data = mysqli_fetch_array($result)) {
    // Check if the current school's id matches the defaultId
    $selected = ($data['id'] == $defaultId) ? "selected" : "";
    $options .= "<option value='" . $data['id'] . "' $selected>" . $data['type'] . "</option>";
  }

  // Free result set
  mysqli_free_result($result);

  // Return the generated options
  return $options;
}
function staffList($defaultId = null, $condition = "WHERE idtypestaff != 1")
{
  global $con;
  // Construct the SQL query
  $query = "SELECT * FROM staff $condition";

  // Execute the query
  $result = mysqli_query($con, $query);

  // Check if query was successful
  if (!$result) {
    // Handle query error (you might want to improve error handling here)
    return "<option>Error fetching Expense Types</option>";
  }

  // Initialize variable to store generated options
  $options = "";

  // Fetch data and generate <option> tags
  while ($data = mysqli_fetch_array($result)) {
    // Check if the current school's id matches the defaultId
    $selected = ($data['id'] == $defaultId) ? "selected" : "";
    $options .= "<option value='" . $data['id'] . "' $selected>" . $data['fullname'] . "</option>";
  }

  // Free result set
  mysqli_free_result($result);

  // Return the generated options
  return $options;
}
function vehicleList($defaultId = null, $condition = "WHERE status = 1")
{
  global $con;
  // Construct the SQL query
  $query = "SELECT * FROM vehicles $condition";

  // Execute the query
  $result = mysqli_query($con, $query);

  // Check if query was successful
  if (!$result) {
    // Handle query error (you might want to improve error handling here)
    return "<option>Error fetching Expense Types</option>";
  }

  // Initialize variable to store generated options
  $options = "";

  // Fetch data and generate <option> tags
  while ($data = mysqli_fetch_array($result)) {
    // Check if the current school's id matches the defaultId
    $selected = ($data['id'] == $defaultId) ? "selected" : "";
    $options .= "<option value='" . $data['id'] . "' $selected>" . $data['vehicleno'] . " | " . $data['vehicletype'] . "</option>";
  }

  // Free result set
  mysqli_free_result($result);

  // Return the generated options
  return $options;
}
function password_generate($chars)
{
  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($data), 0, $chars);
}
function addStudent($Name, $Guardian, $DOB, $Gender, $CNIC, $Phone, $Email, $Address, $Blood, $Timegroup)
{
  global $con;
  $sql = "INSERT INTO students(fullname, fathername, dob, gender, cnic, phone, email, address, idblood, timegroup) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "ssssssssis", $Name, $Guardian, $DOB, $Gender, $CNIC, $Phone, $Email, $Address, $Blood, $Timegroup);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    $inserted_id = mysqli_insert_id($con);
    mysqli_stmt_close($stmt);
    return $inserted_id;
  } else {
    mysqli_stmt_close($stmt);
    return false;
  }
}
function addStudentWithNull($Name, $Guardian, $Gender, $CNIC)
{
  global $con;
  $sql = "INSERT INTO students(fullname, fathername, gender, cnic) VALUES(?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "ssis", $Name, $Guardian, $Gender, $CNIC);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    $inserted_id = mysqli_insert_id($con);
    mysqli_stmt_close($stmt);
    return $inserted_id;
  } else {
    mysqli_stmt_close($stmt);
    return false;
  }
}
function addVoucher($voucherNumber, $admissionFee, $prospectusFee, $pickndrop, $Total, $Discount, $discountBy, $Remarks, $grandTotal, $studentID, $studentCategoryID, $courseID, $schoolID, $userID, $Status)
{
  global $con;
  $sql = "INSERT INTO vouchers(vouchernumber, admission, prospectus, pickndrop, total, discount, discountby, remarks, grand_total, idstudent, idstudentcategory, idcourse, idschool, iduser, status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "siiiiissiiiiiii", $voucherNumber, $admissionFee, $prospectusFee, $pickndrop, $Total, $Discount, $discountBy, $Remarks, $grandTotal, $studentID, $studentCategoryID, $courseID, $schoolID, $userID, $Status);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    $inserted_id = mysqli_insert_id($con);
    mysqli_stmt_close($stmt);
    return $inserted_id;
  } else {
    mysqli_stmt_close($stmt);
    return false;
  }
}
function addStudentCreateVoucher($schoolID, $CNIC, $Name, $fatherName, $Gender, $courseID, $pickndrop, $voucherNumber, $admissionFee, $prospectusFee, $pickDropFee, $Total, $Discount, $grandTotal)
{
  global $con;
  $sql1 = "INSERT INTO students(idschool, cnic, fullname, fathername, gender, idcourse, pickndrop) VALUES(?, ?, ?, ?, ?, ?, ?)";
  $stmt1 = mysqli_prepare($con, $sql1);
  mysqli_stmt_bind_param($stmt1, "isssiii", $schoolID, $CNIC, $Name, $fatherName, $Gender, $courseID, $pickndrop);
  $Result1 = mysqli_stmt_execute($stmt1);
  if ($Result1) {
    $last_id = mysqli_insert_id($con);
    mysqli_stmt_close($stmt1);
    
    $sql2 = "INSERT INTO vouchers(vouchernumber, admission, prospectus, pickndrop, total, discount, grand_total, idstudents_copy) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($con, $sql2);
    mysqli_stmt_bind_param($stmt2, "siiiiiii", $voucherNumber, $admissionFee, $prospectusFee, $pickndrop, $Total, $Discount, $grandTotal, $last_id);
    $Result2 = mysqli_stmt_execute($stmt2);
    if ($Result2) {
      mysqli_stmt_close($stmt2);
      return true;
    } else {
      mysqli_stmt_close($stmt2);
      return false;
    }
  } else {
    mysqli_stmt_close($stmt1);
    return false;
  }
}
function addDuplicateVoucher($voucherNumber, $admissionFee, $prospectusFee, $pickDropFee, $Total, $Discount, $grandTotal, $studentID)
{
  global $con;
  $sql = "INSERT INTO vouchers(vouchernumber, admission, prospectus, pickndrop, total, discount, grand_total, idstudents_copy) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "siiiiiii", $voucherNumber, $admissionFee, $prospectusFee, $pickDropFee, $Total, $Discount, $grandTotal, $studentID);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    mysqli_stmt_close($stmt);
    return true;
  } else {
    mysqli_stmt_close($stmt);
    return false;
  }
}


function newAdmission($Registration, $PicknDrop, $studentID, $courseID, $voucherID, $feePaymentID, $schoolID, $userID, $admissionDate)
{
  global $con;
  $sql = "INSERT INTO admissions(registration, pickndrop, idstudent, idcourse, idvoucher, idfee_payment, idschool, iduser, admission_date) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "ssiiiiiss", $Registration, $PicknDrop, $studentID, $courseID, $voucherID, $feePaymentID, $schoolID, $userID, $admissionDate);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    $inserted_id = mysqli_insert_id($con);
    mysqli_stmt_close($stmt);
    return $inserted_id;
  } else {
    mysqli_stmt_close($stmt);
    return false;
  }
}
function newFeePayment($voucherID, $studentID, $schoolID, $bankID, $paidDate, $userID)
{
  global $con;
  $sql = "INSERT INTO fee_payments(idvoucher, idstudent, idschool, idbank, paid_date, iduser) VALUES(?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "iiiisi", $voucherID, $studentID, $schoolID, $bankID, $paidDate, $userID);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    $inserted_id = mysqli_insert_id($con);
    mysqli_stmt_close($stmt);
    return $inserted_id;
  } else {
    mysqli_stmt_close($stmt);
    return false;
  }
}


function updateStudentDetails($studentID, $Email, $DOB, $Address, $Phone, $Group, $Blood)
{
  global $con;
  $sql = "UPDATE students SET email=?, dob=?, address=?, phone=?, timegroup=?, idblood=? WHERE id=?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "sssssii", $Email, $DOB, $Address, $Phone, $Group, $Blood, $studentID);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    mysqli_stmt_close($stmt);
    return true;
  } else {
    echo mysqli_error($con);
    echo "<h3 class='text-center'>Try Again.</h3>";
    mysqli_stmt_close($stmt);
    return false;
  }
}
function updateVoucherStatusToPaid($voucherID)
{
  global $con;
  $sql = "UPDATE vouchers SET status=true WHERE id=?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $voucherID);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    mysqli_stmt_close($stmt);
    return true;
  } else {
    echo mysqli_error($con);
    echo "<h3 class='text-center'>Try Again.</h3>";
    mysqli_stmt_close($stmt);
    return false;
  }
}


function newAdmissionTest($idStudent, $idCourse, $startDate, $endDate, $totalFee, $paidFee, $pendingDues, $admissionDate, $Discount, $pickndrop, $idSchool, $Registration, $userID)
{
  global $con;
  $sql = "INSERT INTO admissions(idstudent,idcourse,startdate,enddate,totalfee,paidfee,pendingdues,admissiondate,discount,pickndrop,idschool,registration,admissionbyuserid) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "iissiiissiiii", $idStudent, $idCourse, $startDate, $endDate, $totalFee, $paidFee, $pendingDues, $admissionDate, $Discount, $pickndrop, $idSchool, $Registration, $userID);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    mysqli_stmt_close($stmt);
    return true;
  } else {
    echo mysqli_error($con);
    mysqli_stmt_close($stmt);
    return false;
  }
}


function newExpense($idexpensetype, $idvehicle, $petrol_quantity, $idstaff, $amount, $description, $payment_method, $check_no, $issue_to, $status, $idschool, $idusers, $date)
{
  global $con;
  $sql = "INSERT INTO expenses(idexpensetype, idvehicle, petrol_quantity, idstaff, amount, description, payment_method, check_no, issue_to, status, idschool, idusers, date) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "iiidsssssiiss", $idexpensetype, $idvehicle, $petrol_quantity, $idstaff, $amount, $description, $payment_method, $check_no, $issue_to, $status, $idschool, $idusers, $date);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    mysqli_stmt_close($stmt);
    return true;
  } else {
    mysqli_stmt_close($stmt);
    return false;
  }
}
function insertData($tableName, $Data = array())
{
  global $con;
  if (empty($Data)) return false;
  
  $columns = array_keys($Data);
  $columnString = implode(',', $columns);
  $placeholders = implode(',', array_fill(0, count($Data), '?'));
  
  $types = "";
  $values = [];
  foreach ($Data as $val) {
    if (is_int($val)) $types .= "i";
    elseif (is_double($val)) $types .= "d";
    else $types .= "s";
    $values[] = $val;
  }
  
  $sql = "INSERT INTO $tableName ($columnString) VALUES ($placeholders)";
  $stmt = mysqli_prepare($con, $sql);
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, $types, ...$values);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
  }
  return false;
}
function newPetrolExpense($Type, $slipNo, $Quantity, $salePrice, $Amount, $Date, $Description, $schoolID, $userID)
{
  global $con;
  $sql = "INSERT INTO expensepetrol(type, slipno, quantity, saleprice, amount, date, description, idschool, idusers) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "ssdddssii", $Type, $slipNo, $Quantity, $salePrice, $Amount, $Date, $Description, $schoolID, $userID);
  $Result = mysqli_stmt_execute($stmt);
  if ($Result) {
    mysqli_stmt_close($stmt);
    return true;
  } else {
    mysqli_stmt_close($stmt);
    return false;
  }
}

function deleteUser($userID)
{
  global $con;
  $Q = "DELETE from users where idusers=?";
  $stmt = mysqli_prepare($con, $Q);
  mysqli_stmt_bind_param($stmt, "i", $userID);
  $QR = mysqli_stmt_execute($stmt);

  if ($QR) {
    mysqli_stmt_close($stmt);
    return True;
  } else {
    mysqli_stmt_close($stmt);
    return False;
  }
}

/* function currentMonthAdmissions(){
    global $con;
        
    $userID = $_SESSION['loginUserID'];
    $User = userByID( $userID );
    $userSchoolID = $User->idschool;
    $currentMonth = date("m");
    $currentYear = date( 'Y' );
    if ( isAdmin() )
    {
        $Q = "SELECT * FROM `admissions` WHERE MONTH(created_at) = '$currentMonth' AND YEAR(created_at)= '$currentYear'";
    }
    else
    {
        $Q = "SELECT * FROM `admissions` WHERE MONTH(created_at) = '$currentMonth' AND YEAR(created_at)= '$currentYear' AND idschool = '$userSchoolID'";
    }
    $QR = mysqli_query($con, $Q);
    $NR = mysqli_num_rows($QR);
    if($NR > 0){
        return $NR;
    }else{
        return 0;
    }

} */
function currentMonthAdmissions($male = null, $female = null, $transgender = null)
{
  global $con;

  $userID = $_SESSION['loginUserID'];
  $User = userByID($userID);
  $userSchoolID = $User->idschool;
  $currentMonth = date("m");
  $currentYear = date('Y');

  // Base query to get admissions for the current month and year
  if (isAdmin()) {
    $Q = "SELECT admissions.*
              FROM admissions
              INNER JOIN students ON admissions.idstudent = students.id
              WHERE MONTH(admissions.created_at) = ?
              AND YEAR(admissions.created_at) = ?";
    $bindParams = [$currentMonth, $currentYear];
    $types = "ss";
  } else {
    $Q = "SELECT admissions.*
              FROM admissions
              INNER JOIN students ON admissions.idstudent = students.id
              WHERE MONTH(admissions.created_at) = ?
              AND YEAR(admissions.created_at) = ?
              AND admissions.idschool = ?";
    $bindParams = [$currentMonth, $currentYear, $userSchoolID];
    $types = "ssi";
  }

  // Append gender filters if any of the gender parameters are provided
  if ($male !== null || $female !== null || $transgender !== null) {
    $conditions = [];
    if ($male !== null) {
      $conditions[] = "students.gender = 1";
    }
    if ($female !== null) {
      $conditions[] = "students.gender = 2";
    }
    if ($transgender !== null) {
      $conditions[] = "students.gender = 3";
    }
    $Q .= " AND (" . implode(" OR ", $conditions) . ")";
  }

  $stmt = mysqli_prepare($con, $Q);
  mysqli_stmt_bind_param($stmt, $types, ...$bindParams);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $NR = mysqli_num_rows($result);
  mysqli_stmt_close($stmt);

  return $NR;
}
function totalAdmissions($active = null, $currentMonth = null, $currentYear = null, $schoolID = null)
{
  global $con;
  $userID = $_SESSION['loginUserID'];
  $User = userByID($userID);
  $userSchoolID = $User->idschool;

  // Base query to get admissions
  $Q = "SELECT admissions.*
        FROM admissions
        INNER JOIN students ON admissions.idstudent = students.id";

  $conditions = [];
  $bindParams = [];

  if ($schoolID !== null) {
    $conditions[] = "admissions.idschool = ?";
    $bindParams[] = $schoolID;
  } elseif (!isAdmin()) {
    $conditions[] = "admissions.idschool = ?";
    $bindParams[] = $userSchoolID;
  }

  if ($active !== null) {
    $conditions[] = "admissions.status = ?";
    $bindParams[] = $active;
  }

  if ($currentMonth !== null) {
    $conditions[] = "MONTH(admissions.admission_date) = ?";
    $bindParams[] = $currentMonth;
  }

  if ($currentYear !== null) {
    $conditions[] = "YEAR(admissions.admission_date) = ?";
    $bindParams[] = $currentYear;
  }

  if (!empty($conditions)) {
    $Q .= " WHERE " . implode(" AND ", $conditions);
  }

  $stmt = mysqli_prepare($con, $Q);

  if (!empty($bindParams)) {
    $types = str_repeat('i', count($bindParams)); // Assuming all params are integers
    mysqli_stmt_bind_param($stmt, $types, ...$bindParams);
  }

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $NR = mysqli_num_rows($result);

  mysqli_stmt_close($stmt);

  return $NR;
}

function totalIncome($con, $studentCategory = null, $currentMonth = null, $currentYear = null, $schoolID = null)
{
  $userID = $_SESSION['loginUserID'];
  $User = userByID($userID);
  $userSchoolID = $User->idschool;

  // Base query to get total income with status = 1
  $Q = "SELECT SUM(IFNULL(v.grand_total, 0)) AS totalIncome
        FROM admissions ad
        JOIN vouchers v ON ad.idvoucher = v.id
        WHERE v.status = 1";

  $conditions = [];
  $bindParams = [];

  if ($schoolID !== null) {
    $conditions[] = "ad.idschool = ?";
    $bindParams[] = $schoolID;
  } elseif (!isAdmin()) {
    $conditions[] = "ad.idschool = ?";
    $bindParams[] = $userSchoolID;
  }

  if ($studentCategory !== null) {
    $conditions[] = "v.idstudentcategory = ?";
    $bindParams[] = $studentCategory;
  }
  if ($currentMonth !== null) {
    $conditions[] = "MONTH(ad.admission_date) = ?";
    $bindParams[] = $currentMonth;
  }

  if ($currentYear !== null) {
    $conditions[] = "YEAR(ad.admission_date) = ?";
    $bindParams[] = $currentYear;
  }

  if (!empty($conditions)) {
    $Q .= " AND " . implode(" AND ", $conditions);
  }

  $stmt = mysqli_prepare($con, $Q);

  if (!empty($bindParams)) {
    $types = str_repeat('i', count($bindParams)); // Assuming all params are integers
    mysqli_stmt_bind_param($stmt, $types, ...$bindParams);
  }

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $totalIncome = mysqli_fetch_object($result)->totalIncome;

  mysqli_stmt_close($stmt);
  return $totalIncome;
}

function totalExpenses($con, $category = null, $currentMonth = null, $currentYear = null, $schoolID = null)
{
  $userID = $_SESSION['loginUserID'];
  $User = userByID($userID);
  $userSchoolID = $User->idschool;

  // Base query to get total expenses with status = 1
  $Q = "SELECT SUM(amount) AS totalExpenses
        FROM expenses
        WHERE status = 1";

  $conditions = [];
  $bindParams = [];

  if ($schoolID !== null) {
    $conditions[] = "idschool = ?";
    $bindParams[] = $schoolID;
  } elseif (!isAdmin()) {
    $conditions[] = "idschool = ?";
    $bindParams[] = $userSchoolID;
  }

  if ($category !== null) {
    $conditions[] = "idexpensetype = ?";
    $bindParams[] = $category;
  }

  if ($currentMonth !== null) {
    $conditions[] = "MONTH(date) = ?";
    $bindParams[] = $currentMonth;
  }

  if ($currentYear !== null) {
    $conditions[] = "YEAR(date) = ?";
    $bindParams[] = $currentYear;
  }

  if (!empty($conditions)) {
    $Q .= " AND " . implode(" AND ", $conditions);
  }

  $stmt = mysqli_prepare($con, $Q);

  if (!empty($bindParams)) {
    $types = str_repeat('i', count($bindParams)); // Assuming all params are integers
    mysqli_stmt_bind_param($stmt, $types, ...$bindParams);
  }

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $totalExpenses = mysqli_fetch_object($result)->totalExpenses;

  mysqli_stmt_close($stmt);

  return $totalExpenses;
}

/* function studentCategories()
{
    global $con;
    $Q2 = "SELECT * FROM studentcategories WHERE status = 1";
    $QR2 = mysqli_query($con, $Q2);
    while ($data = mysqli_fetch_array($QR2)) {
        echo "<option value='" . $data['id'] . "'>" . $data['name'] . "</option>";
    }
} */
/* function authoritiesList()
{
    global $con;
    $Q2 = "SELECT * FROM authorities WHERE status = 1";
    $QR2 = mysqli_query($con, $Q2);
    while ($data = mysqli_fetch_array($QR2)) {
        echo "<option value='" . $data['id'] . "'>" . $data['name'] . "</option>";
    }
} */
function studentCategories($defaultId = null, $condition = "WHERE status = 1")
{
  global $con;
  // Construct the SQL query
  $query = "SELECT * FROM studentcategories $condition";

  // Execute the query
  $result = mysqli_query($con, $query);

  // Check if query was successful
  if (!$result) {
    // Handle query error (you might want to improve error handling here)
    return "<option>Error fetching student categories</option>";
  }

  // Initialize variable to store generated options
  $options = "";

  // Fetch data and generate <option> tags
  while ($data = mysqli_fetch_array($result)) {
    // Check if the current school's id matches the defaultId
    $selected = ($data['id'] == $defaultId) ? "selected" : "";
    $options .= "<option value='" . $data['id'] . "' $selected>" . $data['name'] . "</option>";
  }

  // Free result set
  mysqli_free_result($result);

  // Return the generated options
  return $options;
}
function authoritiesList($defaultId = null, $condition = "WHERE status = 1")
{
  global $con;
  // Construct the SQL query
  $query = "SELECT * FROM authorities $condition";

  // Execute the query
  $result = mysqli_query($con, $query);

  // Check if query was successful
  if (!$result) {
    // Handle query error (you might want to improve error handling here)
    return "<option>Error fetching schools</option>";
  }

  // Initialize variable to store generated options
  $options = "";

  // Fetch data and generate <option> tags
  while ($data = mysqli_fetch_array($result)) {
    // Check if the current school's id matches the defaultId
    $selected = ($data['id'] == $defaultId) ? "selected" : "";
    $options .= "<option value='" . $data['id'] . "' $selected>" . $data['name'] . "</option>";
  }

  // Free result set
  mysqli_free_result($result);

  // Return the generated options
  return $options;
}
function coursesList($defaultId = null, $condition = "WHERE status = 1")
{
  global $con;
  // Construct the SQL query
  $query = "SELECT * FROM courses $condition";

  // Execute the query
  $result = mysqli_query($con, $query);

  // Check if query was successful
  if (!$result) {
    // Handle query error (you might want to improve error handling here)
    return "<option>Error fetching courses</option>";
  }

  // Initialize variable to store generated options
  $options = "";

  // Fetch data and generate <option> tags
  while ($data = mysqli_fetch_array($result)) {
    // Check if the current school's id matches the defaultId
    $selected = ($data['id'] == $defaultId) ? "selected" : "";
    $options .= "<option value='" . $data['id'] . "' $selected>" . $data['coursename'] . ' - ' . $data['duration'] . "</option>";
  }

  // Free result set
  mysqli_free_result($result);

  // Return the generated options
  return $options;
}
function schoolCounter($schoolID = null, $Year = null)
{
  global $con;
  // Base query to get total income with status = 1
  $Q = "SELECT total_admissions
        FROM school_counters
        WHERE idschool = '$schoolID' AND year = '$Year'";

  $stmt = mysqli_prepare($con, $Q);

  if (!empty($bindParams)) {
    $types = str_repeat('i', count($bindParams)); // Assuming all params are integers
    mysqli_stmt_bind_param($stmt, $types, ...$bindParams);
  }

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $totalAdmissions = mysqli_fetch_object($result)->total_admissions;

  mysqli_stmt_close($stmt);
  return $totalAdmissions;
}
