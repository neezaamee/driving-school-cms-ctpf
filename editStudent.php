<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include('topNav.php') ?>
        <?php include('sidebar.php') ?>
        
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"><h1 class="m-0 text-dark">Modify Student Details</h1></div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header"><h3 class="card-title">Student Modification Form</h3></div>
                                <div class="card-body">
                                <?php
                                if (isset($_POST['update_student'])) {
                                    // Handle the Update logic (from editStudentRSP.php)
                                    $studentID = CleanData($_POST['idstudent']);	
                                    $fullName = CleanData($_POST['fullname']);
                                    $guardianName = CleanData($_POST['fathername']);
                                    $DOB = CleanData($_POST['dob']);
                                    $CNIC = CleanData($_POST['cnic']);
                                    $Gender = CleanData($_POST['gender']);
                                    $Phone = CleanData($_POST['phone']);
                                    $Email = CleanData($_POST['email']);
                                    $Blood = CleanData($_POST['bloodgroup']);
                                    $Time = CleanData($_POST['time']);
                                    $Address = CleanData($_POST['address']);

                                    $sql = "UPDATE students SET fullname=?, fathername=?, dob=?, cnic=?, gender=?, phone=?, email=?, idblood=?, timegroup=?, address=? WHERE id=?";
                                    $stmt = mysqli_prepare($con, $sql);
                                    mysqli_stmt_bind_param($stmt, "ssssssssssi", $fullName, $guardianName, $DOB, $CNIC, $Gender, $Phone, $Email, $Blood, $Time, $Address, $studentID);
                                    
                                    if (mysqli_stmt_execute($stmt)) {
                                        echo "<div class='alert alert-success'>Student details updated successfully.</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Error updating student: " . mysqli_error($con) . "</div>";
                                    }
                                    mysqli_stmt_close($stmt);
                                    echo "<script>setTimeout(function(){ window.location.href='editStudent.php'; }, 2000);</script>";

                                } elseif (isset($_POST['fetch_student'])) {
                                    // Handle the Fetch logic (Step 2)
                                    $Registration = CleanData($_POST['registration']);
                                    $Admission = admissionByRegistration($Registration);
                                    
                                    if ($Admission) {
                                        $studentID = $Admission->idstudent;
                                        $Student = studentByID($studentID);
                                        ?>
                                        <form role="form" method="post" action="editStudent.php">
                                            <input type="hidden" name="idstudent" value="<?php echo $studentID; ?>">
                                            <div class="form-row">
                                                <div class="form-group col-md-6"><label>Registration #</label><input type="text" class="form-control" name="registration" value="<?php echo $Registration;?>" readonly></div>
                                                <div class="form-group col-md-6"><label>Admission Date</label><input type="text" class="form-control" value="<?php echo $Admission->created_at; ?>" readonly></div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6"><label>Full Name</label><input type="text" class="form-control" name="fullname" value="<?php echo $Student->fullname; ?>" required></div>
                                                <div class="form-group col-md-6"><label>Guardian Name</label><input type="text" class="form-control" name="fathername" value="<?php echo $Student->fathername; ?>" required></div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6"><label>DOB (Current: <?php echo $Student->dob; ?>)</label><input type="date" class="form-control" name="dob" value="<?php echo $Student->dob; ?>" required></div>
                                                <div class="form-group col-md-6"><label>CNIC</label><input type="number" class="form-control" name="cnic" value="<?php echo $Student->cnic; ?>" required></div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label>Gender</label>
                                                    <select class="form-control" name="gender" required>
                                                        <option value="1" <?php if($Student->gender == 1) echo 'selected'; ?>>Male</option>
                                                        <option value="2" <?php if($Student->gender == 2) echo 'selected'; ?>>Female</option>
                                                        <option value="3" <?php if($Student->gender == 3) echo 'selected'; ?>>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3"><label>Phone</label><input type="text" class="form-control" name="phone" value="<?php echo $Student->phone; ?>"></div>
                                                <div class="form-group col-md-3"><label>Email</label><input type="email" class="form-control" name="email" value="<?php echo $Student->email; ?>"></div>
                                                <div class="form-group col-md-3">
                                                    <label>Blood Group</label>
                                                    <select class="form-control" name="bloodgroup">
                                                        <?php
                                                        $bloods = mysqli_query($con, "SELECT * FROM blood");
                                                        while($b = mysqli_fetch_array($bloods)) {
                                                            $sel = ($b['id'] == $Student->idblood) ? 'selected' : '';
                                                            echo "<option value='{$b['id']}' $sel>{$b['name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Time Group</label>
                                                    <select class="form-control" name="time">
                                                        <option value="Morning" <?php if($Student->timegroup == 'Morning') echo 'selected'; ?>>Morning</option>
                                                        <option value="Evening" <?php if($Student->timegroup == 'Evening') echo 'selected'; ?>>Evening</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6"><label>Address</label><input type="text" class="form-control" name="address" value="<?php echo $Student->address; ?>" required></div>
                                            </div>
                                            <button type="submit" name="update_student" class="btn btn-primary">Update Details</button>
                                        </form>
                                        <?php
                                    } else {
                                        echo "<div class='alert alert-danger'>Registration # not found.</div>";
                                        echo "<a href='editStudent.php' class='btn btn-link'>Try Again</a>";
                                    }
                                } else {
                                    // Initial Step: Enter Registration #
                                    ?>
                                    <form role="form" method="post" action="editStudent.php">
                                        <div class="form-group">
                                            <label>Enter Registration #</label>
                                            <input type="text" class="form-control" name="registration" placeholder="Year-School-CTP-Number" required autofocus>
                                        </div>
                                        <button type="submit" name="fetch_student" class="btn btn-primary">Fetch Details</button>
                                    </form>
                                    <?php
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include('footer.php') ?>
    </div>
    <?php include('footerPlugins.php') ?>
</body>
</html>
