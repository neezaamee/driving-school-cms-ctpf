<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;
$School = schoolByID($userSchoolID);
$schoolName = $School->location;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('Head.php'); ?>
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            @page { margin: 10px; }
            body { font-size: 12px; }
            .wrapper { background: none !important; }
            .content-wrapper { margin-left: 0 !important; }
        }
        .print-only { display: none; }
        table { border: 1px solid black !important; border-collapse: collapse !important; }
        th, td { border: 1px solid black !important; padding: 5px !important; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="no-print">
            <?php include('topNav.php'); ?>
            <?php include('sidebar.php'); ?>
        </div>

        <div class="content-wrapper">
            <div class="content-header no-print">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"><h1 class="m-0 text-dark">Admission Test Flow - <?php echo $schoolName; ?></h1></div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php
                    if (isset($_POST['submit_test_admission'])) {
                        $admissionDate = CleanData($_POST['admissiondate']);
                        $Name = CleanData($_POST['fullname']);
                        $fatherName = CleanData($_POST['fathername']);
                        $Gender = CleanData($_POST['gender']);
                        $Email = CleanData($_POST['email']);
                        $Blood = CleanData($_POST['bloodgroup']);
                        $CNIC = CleanData($_POST['cnic']);
                        $schoolID = CleanData($_POST['schoolid']);
                        $DOB = CleanData($_POST['dob']);
                        $Address = CleanData($_POST['address']);
                        $Phone = CleanData($_POST['phone']);
                        $pickndrop = CleanData($_POST['pickndrop']);
                        $courseID = CleanData($_POST['course']);
                        $courseFee = CleanData($_POST['coursefee']);
                        $Time = CleanData($_POST['time']);
                        $feePayable = CleanData($_POST['feepayable']);
                        $feePaid = CleanData($_POST['feepaid']);
                        $Discount = CleanData($_POST['discount']);
                        $Prospectus = CleanData($_POST['prospectus']);
                        $pendingDues = $feePayable - $feePaid;

                        $addStudent = addStudent($Name, $fatherName, $Gender, $Email, $Blood, $CNIC, $DOB, $Address, $Phone, $pickndrop, $schoolID, $courseID, '', '', $Time);
                        if ($addStudent) {
                            $lastStudentID = $con->insert_id;
                            $Registration = date("Y") . "CTPF" . $schoolID . $lastStudentID;
                            
                            if (newAdmissionTest($lastStudentID, $courseID, $admissionDate, $admissionDate, $feePayable, $feePaid, $pendingDues, $admissionDate, $Discount, $pickndrop, $schoolID, $Registration, $userID)) {
                                $lastAdmissionID = $con->insert_id;
                                
                                // Update student
                                $stmt_upd = mysqli_prepare($con, "UPDATE students SET idadmission=? WHERE id=?");
                                mysqli_stmt_bind_param($stmt_upd, "ii", $lastAdmissionID, $lastStudentID);
                                mysqli_stmt_execute($stmt_upd);
                                
                                // Insert fee details
                                $stmt_fee = mysqli_prepare($con, "INSERT INTO fee(idadmission, coursefee, misc, discount, totalpayable, received) VALUES(?, ?, ?, ?, ?, ?)");
                                mysqli_stmt_bind_param($stmt_fee, "iiiiii", $lastAdmissionID, $courseFee, $Prospectus, $Discount, $feePayable, $feePaid);
                                mysqli_stmt_execute($stmt_fee);
                                
                                ?>
                                <div class="alert alert-success no-print">Admission Test Recorded! <button onclick="window.print()" class="btn btn-sm btn-dark ml-2">Print Receipt</button></div>
                                <div class="print-area" style="width: 400px; margin: auto;">
                                    <table class="table table-bordered">
                                        <tr><th colspan="2" class="text-center">Fee Receipt - Test Copy<br><?php echo "Driving School " . $schoolName; ?></th></tr>
                                        <tr><th>Admission Date</th><td><?php echo $admissionDate; ?></td></tr>
                                        <tr><th>Registration #</th><td><?php echo $Registration; ?></td></tr>
                                        <tr><th>Name</th><td><?php echo $Name; ?></td></tr>
                                        <tr><th>Guardian</th><td><?php echo $fatherName; ?></td></tr>
                                        <tr><th>Course</th><td><?php echo courseByID($courseID)->coursename; ?></td></tr>
                                        <tr><th>Pick n Drop</th><td><?php echo ($pickndrop > 0 ? "Availed" : "Not Availed"); ?></td></tr>
                                        <tr><th>Fee Paid</th><td><?php echo $feePaid; ?>/-</td></tr>
                                        <tr><th colspan="2" class="text-center" style="height: 60px; vertical-align: bottom;">Received By</th></tr>
                                    </table>
                                </div>
                                <?php
                            } else {
                                echo "<div class='alert alert-danger no-print'>Error recording admission test.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger no-print'>Error adding student.</div>";
                        }
                    } else {
                        ?>
                        <div class="card card-primary no-print">
                            <div class="card-header"><h3 class="card-title">Admission Test Form</h3></div>
                            <form role="form" method="post" action="newAdmissionTest.php">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-3"><label>Admission Date</label><input type="date" class="form-control" name="admissiondate" value="<?php echo date("Y-m-d"); ?>" required></div>
                                        <?php if (isAdmin()) { ?>
                                        <div class="form-group col-md-4">
                                            <label>School</label>
                                            <select class="form-control" name="schoolid">
                                                <?php $s_res = mysqli_query($con, "SELECT * FROM schools WHERE id != 1"); while($s = mysqli_fetch_array($s_res)) echo "<option value='{$s['id']}'>{$s['location']}</option>"; ?>
                                            </select>
                                        </div>
                                        <?php } else { ?><input type="hidden" name="schoolid" value="<?php echo $userSchoolID; ?>"><?php } ?>
                                    </div>
                                    <!-- Rest of the form fields (Name, CNIC, etc.) -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6"><label>Full Name</label><input type="text" class="form-control" name="fullname" required></div>
                                        <div class="form-group col-md-6"><label>Guardian Name</label><input type="text" class="form-control" name="fathername" required></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4"><label>CNIC</label><input type="number" class="form-control" name="cnic" required></div>
                                        <div class="form-group col-md-4"><label>Date of Birth</label><input type="date" class="form-control" name="dob" required></div>
                                        <div class="form-group col-md-4"><label>Gender</label><select class="form-control" name="gender"><option value="1">Male</option><option value="2">Female</option><option value="3">Other</option></select></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4"><label>Phone</label><input type="number" class="form-control" name="phone" required></div>
                                        <div class="form-group col-md-4"><label>Email</label><input type="email" class="form-control" name="email"></div>
                                        <div class="form-group col-md-4"><label>Blood Group</label><select class="form-control" name="bloodgroup"><?php $b_res = mysqli_query($con, "SELECT * FROM bloods"); while($b = mysqli_fetch_array($b_res)) echo "<option value='{$b['id']}'>{$b['name']}</option>"; ?></select></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-2"><label>Course</label><select class="form-control" name="course" id="course_select"><?php $c_res = mysqli_query($con, "SELECT * FROM courses"); while($c = mysqli_fetch_array($c_res)) echo "<option value='{$c['id']}' data-fee='{$c['fee']}'>{$c['coursename']}</option>"; ?></select></div>
                                        <div class="form-group col-md-2"><label>Time</label><select class="form-control" name="time"><option value="morning">Morning</option><option value="evening">Evening</option></select></div>
                                        <div class="form-group col-md-2"><label>Pick n Drop</label><select class="form-control" name="pickndrop" id="pickdrop_select"><option value="0">No</option><option value="1000">Yes (1000/-)</option></select></div>
                                        <div class="form-group col-md-2"><label>Prospectus</label><select class="form-control" name="prospectus" id="prospectus_select"><option value="0">No</option><option value="200">Yes (200/-)</option></select></div>
                                        <div class="form-group col-md-2"><label>Discount</label><input type="number" class="form-control" name="discount" id="discount_input" value="0"></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3"><label>Course Fee</label><input type="number" class="form-control" name="coursefee" id="coursefee" readonly></div>
                                        <div class="form-group col-md-3"><label>Fee Payable</label><input type="number" class="form-control" name="feepayable" id="feepayable" readonly></div>
                                        <div class="form-group col-md-3"><label>Fee Paid</label><input type="number" class="form-control" name="feepaid" required></div>
                                        <div class="form-group col-md-3"><label>Address</label><input type="text" class="form-control" name="address" required></div>
                                    </div>
                                </div>
                                <div class="card-footer"><button type="submit" name="submit_test_admission" class="btn btn-primary">Submit Test Admission</button></div>
                            </form>
                        </div>
                        <script>
                            function calculateFee() {
                                var courseFee = parseInt($('#course_select option:selected').data('fee')) || 0;
                                var pickdrop = parseInt($('#pickdrop_select').val()) || 0;
                                var prospectus = parseInt($('#prospectus_select').val()) || 0;
                                var discount = parseInt($('#discount_input').val()) || 0;
                                var total = courseFee + pickdrop + prospectus - discount;
                                $('#coursefee').val(courseFee);
                                $('#feepayable').val(total);
                            }
                            $('#course_select, #pickdrop_select, #prospectus_select, #discount_input').on('change keyup', calculateFee);
                            $(document).ready(calculateFee);
                        </script>
                        <?php
                    }
                    ?>
                </div>
            </section>
        </div>
        <div class="no-print"><?php include('footer.php'); ?></div>
    </div>
    <?php include('footerPlugins.php'); ?>
</body>
</html>
