<?php
session_start();
require_once('connection.php');
require_once('sessionSet.php');

if(!isset($_GET['student_id'])) {
    exit('No student ID provided.');
}

$student_id = mysqli_real_escape_string($con, $_GET['student_id']);

// Ensure we are using the merged database
mysqli_select_db($con, 'ds_ctpfsd_merged');

$query = "SELECT a.*, c.coursename, c.fee, s.location as schoolname, v.vouchernumber 
          FROM admissions a
          LEFT JOIN courses c ON a.idcourse = c.id
          LEFT JOIN schools s ON a.idschool = s.id
          LEFT JOIN vouchers v ON a.idvoucher = v.id
          WHERE a.idstudent = '$student_id'
          ORDER BY a.admission_date DESC";

$result = $con->query($query);

if($result->num_rows > 0) {
    echo '<table class="table table-sm table-info table-hover mt-2">';
    echo '<thead><tr><th>Reg No</th><th>Voucher</th><th>Date</th><th>School</th><th>Course</th><th>Fee</th><th>Source</th></tr></thead>';
    echo '<tbody>';
    while($row = $result->fetch_assoc()) {
        $source = ($row['id'] >= 1000000) ? '<span class="badge badge-secondary">Shared Hosting</span>' : '<span class="badge badge-primary">Local Database</span>';
        echo '<tr>';
        echo '<td>'.$row['registration'].'</td>';
        echo '<td>'.($row['vouchernumber'] ?? 'N/A').'</td>';
        echo '<td>'.($row['admission_date'] ? date('d-M-Y', strtotime($row['admission_date'])) : '---').'</td>';
        echo '<td>'.$row['schoolname'].'</td>';
        echo '<td>'.$row['coursename'].'</td>';
        echo '<td>'.$row['fee'].'</td>';
        echo '<td>'.$source.'</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p class="text-danger">No admissions found for this student.</p>';
}
?>
