<?php session_start();
$pageTitle = "Duplicate Registration Form";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php'); ?>
<!--/Head-->
<?php
$userName = $_SESSION['loginUsername'];
$userID = $_SESSION['loginUserID'];

$User = userByID($userID);
$userSchoolID = $User->idschool;
$School = schoolByID($userSchoolID);
$schoolName = $School->location;

?>
<style>
    #profiletbl td, #profiletbl th {
        padding: 10px !important;
    }
</style>
<!--Body-->

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('topNav.php') ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include 'sidebar.php'; ?>
        <!--/ Main Sidebar Container-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Duplicate Registration Form</h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Duplicate Admission Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!--fetch last token-->
                                <!-- form start -->
                                <?php
                                if (isset($_POST['submit'])) {
                                    $Registration = CleanData($_POST['registration']);
                                    
                                    // High-performance JOIN to fetch all data in one go
                                        $sql = "SELECT 
                                                    a.*, 
                                                    s.fullname as studentName, s.fathername, s.cnic, s.dob, s.gender as genderID, s.phone, s.email, s.address, s.timegroup, s.idblood,
                                                    c.coursename, c.duration,
                                                    v.vouchernumber, v.grand_total, v.discount, v.remarks, v.idstudentcategory,
                                                    f.paid_date, f.idbank,
                                                    sch.location as schoolLoc, sch.schoolcode,
                                                    city.name as cityName, city.shortcode as cityShort,
                                                    g.name as genderName,
                                                    b.name as bloodName,
                                                    sc.name as categoryName,
                                                    bank.name as bankName
                                                FROM admissions a
                                            INNER JOIN students s ON a.idstudent = s.id
                                            INNER JOIN courses c ON a.idcourse = c.id
                                            INNER JOIN vouchers v ON a.idvoucher = v.id
                                            INNER JOIN fee_payments f ON a.idfee_payment = f.id
                                            INNER JOIN schools sch ON a.idschool = sch.id
                                            INNER JOIN cities city ON sch.idcity = city.id
                                            INNER JOIN gender g ON s.gender = g.id
                                            LEFT JOIN blood b ON s.idblood = b.id
                                            INNER JOIN studentcategories sc ON v.idstudentcategory = sc.id
                                            LEFT JOIN banks bank ON f.idbank = bank.id
                                            WHERE a.registration = ?";
                                    
                                    $stmt = mysqli_prepare($con, $sql);
                                    mysqli_stmt_bind_param($stmt, "s", $Registration);
                                    mysqli_stmt_execute($stmt);
                                    $Result = mysqli_stmt_get_result($stmt);
                                    
                                    if ($Row = mysqli_fetch_assoc($Result)) {
                                        $studentCNIC = $Row['cnic'];
                                        $photoPath = 'StudentImages/' . $studentCNIC . '.JPG';
                                        if (!file_exists($photoPath)) {
                                            $photoPath = ($Row['genderID'] == '2') ? 'dist/img/avatar2.png' : 'dist/img/avatar5.png';
                                        }
                                ?>
                                        <div id="printArea">
                                            <div class="text-center mb-4">
                                                <h2 class="font-weight-bold">REGISTRATION FORM</h2>
                                                <strong style="font-size: medium">Driving School - Traffic Police Punjab</strong><br>
                                                <strong style="font-size: medium"><?php echo $Row['schoolLoc'] . " " . $Row['cityName']; ?></strong>
                                            </div>

                                            <table class="table table-bordered table-sm table-striped" id="profiletbl">
                                                <tbody>
                                                    <tr>
                                                        <th>Admission Date</th>
                                                        <td colspan="2"><?php echo date('d-M-Y', strtotime($Row['admission_date'])); ?></td>
                                                        <th class="text-center" rowspan="5">
                                                            <img width="180px" height="180px" src="<?php echo $photoPath; ?>" class="img-thumbnail elevation-2" alt="Student Photo">
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Registration No</th>
                                                        <td colspan="2"><span class="badge badge-primary" style="font-size: 1rem;"><?php echo $Registration; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Voucher Number / PSID</th>
                                                        <td colspan="2"><?php echo $Row['vouchernumber']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Voucher Paid Date</th>
                                                        <td colspan="2"><?php echo date('d-M-Y', strtotime($Row['paid_date'])) . " - " . ($Row['bankName'] ?: 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>CNIC</th>
                                                        <td colspan="2"><strong><?php echo $studentCNIC; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Name of Student</th>
                                                        <td colspan="3"><?php echo strtoupper($Row['studentName']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Guardian</th>
                                                        <td colspan="3"><?php echo $Row['fathername']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>DOB / Gender</th>
                                                        <td colspan="3">
                                                            <?php echo date('d-m-Y', strtotime($Row['dob'])); ?> / 
                                                            <span class="badge badge-info"><?php echo $Row['genderName']; ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Student Category</th>
                                                        <td><span class="badge badge-secondary"><?php echo $Row['categoryName']; ?></span></td>
                                                        <th>Blood Group</th>
                                                        <td><span class="badge badge-danger"><?php echo $Row['bloodName'] ?: 'N/A'; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone</th>
                                                        <td><?php echo $Row['phone']; ?></td>
                                                        <th>Email</th>
                                                        <td><?php echo $Row['email'] ?: '-'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Course Details</th>
                                                        <td><strong><?php echo $Row['coursename']; ?></strong> <small>(<?php echo $Row['duration']; ?>)</small></td>
                                                        <th>Time Group</th>
                                                        <td><?php echo $Row['timegroup']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fee Concession</th>
                                                        <td>Rs. <?php echo number_format($Row['discount'] ?? 0); ?></td>
                                                        <th>Grand Total Fee</th>
                                                        <td>Rs. <?php echo number_format($Row['grand_total']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td colspan="3"><?php echo $Row['address']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Remarks</th>
                                                        <td colspan="3"><?php echo $Row['remarks'] ?: '-'; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="row mt-5 pt-4">
                                                <div class="col-4 text-center border-top">
                                                    <p class="mt-2 font-weight-bold">Signature Applicant</p>
                                                </div>
                                                <div class="col-4"></div>
                                                <div class="col-4 text-center border-top">
                                                    <p class="mt-2 font-weight-bold">Signature Admin</p>
                                                </div>
                                            </div>

                                            <div style="border-top: 3px dashed #000; margin: 50px 0;"></div>

                                            <!-- Student Card Section -->
                                            <div class="student-card-wrapper d-flex justify-content-center">
                                                <div class="card card-outline card-danger" style="width: 100%; max-width: 600px;">
                                                    <div class="card-header text-center">
                                                        <h4 class="m-0">STUDENT CARD</h4>
                                                        <small>Car Driving School <?php echo $Row['schoolLoc'] . " " . $Row['cityName']; ?></small>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="row no-gutters">
                                                            <div class="col-8 p-3">
                                                                <table class="table table-sm table-borderless m-0">
                                                                    <tr>
                                                                        <th style="width: 40%;">Registration:</th>
                                                                        <td><?php echo $Registration; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Student:</th>
                                                                        <td><strong><?php echo strtoupper($Row['studentName']); ?></strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>CNIC:</th>
                                                                        <td><?php echo $studentCNIC; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Course:</th>
                                                                        <td><?php echo $Row['coursename'] . " (" . $Row['duration'] . ")"; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Time Group:</th>
                                                                        <td><?php echo $Row['timegroup']; ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-4 text-center p-3 align-self-center">
                                                                <img width="120px" height="120px" src="<?php echo $photoPath; ?>" class="img-circle elevation-2 shadow-sm" alt="Student Card Photo">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Temporary commented -->
                                                    <!-- <div class="card-footer p-2 text-center bg-light">
                                                        <div class="row">
                                                            <div class="col-4"><small><strong>Website:</strong> ctpfsd.gop.pk</small></div>
                                                            <div class="col-4"><small><strong>FB:</strong> @ctpfaisalabad</small></div>
                                                            <div class="col-4"><small><strong>YT:</strong> @CTPFaisalabadOfficial</small></div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <!-- Footer is temporary commented -->
                                            <!-- <p class="text-center mt-3 text-muted" style="font-size: 0.8rem;">
                                                Designed and Developed by: IT Branch City Traffic Police Faisalabad
                                            </p> -->
                                            
                                            <div class="text-center mt-4">
                                                <button class="btn btn-success d-print-none" onclick="window.print()">
                                                    <i class="fas fa-print"></i> Print Form
                                                </button>
                                                <a href="duplicateRegistrationForm.php" class="btn btn-secondary d-print-none">
                                                    <i class="fas fa-arrow-left"></i> Back
                                                </a>
                                            </div>
                                        </div>
                                <?php
                                        mysqli_stmt_close($stmt);
                                    } else {
                                        echo "<div class='alert alert-danger'>Registration Number <strong>$Registration</strong> not found!</div>";
                                        echo "<a href='duplicateRegistrationForm.php' class='btn btn-primary ml-3 mt-2'>Try Again</a>";
                                    }
                                } else {
                                    //Showing Registration Form
                                ?>
                                    <form role="form" method="post" action="duplicateRegistrationForm.php" id="newEnrollmentForm">
                                        <div class="card-body">

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="InputCNIC">Enter Registration No</label>
                                                    <input type="text" class="form-control" id="registration" placeholder="Enter Registration No" name="registration" autofocus>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" id="submit" class="btn btn-primary" name="submit">Submit</button>
                                        </div>
                                        <!--/.card-footer-->
                                    </form>
                                    <!-- form ends -->
                                <?php
                                }
                                ?>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!--Footer Content-->
        <div class="d-print-none">
            <?php include('footer.php') ?>
        </div>
        <!--/Footer Content-->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->

        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include('footerPlugins.php') ?>
    <script>
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Letters only please");
    </script>
</body>
<!--/Body-->

</html>