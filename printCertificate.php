<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;
$School = schoolByID($userSchoolID);
$schoolName = $School->location;

$show_certificate = false;
$Admission = null;
$error = "";

if (isset($_POST['submit'])) {
    $Registration = CleanData($_POST['registration']);
    $Admission = admissionByRegistration($Registration);
    if ($Admission) {
        $show_certificate = true;
    } else {
        $error = "Registration number not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('Head.php'); ?>
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            @page { size: landscape; margin: 0; }
            body { margin: 0; padding: 0; }
        }
        .certificate-container {
            position: relative;
            width: 11in;
            height: 8in;
            margin: 0 auto;
            font-family: 'Times New Roman', serif;
            font-weight: bold;
            color: #000;
        }
        #certificateimg {
            width: 100%;
            height: 100%;
            display: block;
        }
        .cert-text { position: absolute; font-size: 1.2rem; }
        #no { top: 1.1in; left: 7.1in; }
        #dated { top: 1.5in; left: 7.4in; }
        #name { top: 3.33in; left: 2.8in; font-size: 1.5rem; }
        #guardian { top: 3.33in; left: 7.4in; font-size: 1.5rem; }
        #school { top: 5.4in; left: 4.2in; font-size: 1.5rem; }
        #from { top: 5.85in; left: 4.3in; font-size: 1.4rem; }
        #to { top: 5.85in; left: 5.9in; font-size: 1.4rem; }
        #category { top: 6.3in; left: 5in; font-size: 1.5rem; }
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
                    <div class="row mb-2"><div class="col-sm-6"><h1 class="m-0 text-dark">Print Certificate</h1></div></div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php if (!$show_certificate): ?>
                        <div class="card card-primary no-print">
                            <div class="card-header"><h3 class="card-title">Certificate Search</h3></div>
                            <form role="form" method="post" action="printCertificate.php">
                                <div class="card-body">
                                    <?php if($error) echo "<div class='alert alert-warning'>$error</div>"; ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Registration Number</label>
                                            <input type="text" class="form-control" name="registration" placeholder="Enter Registration No" required autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"><button type="submit" name="submit" class="btn btn-primary">Find Student</button></div>
                            </form>
                        </div>
                    <?php else: 
                        $student = studentByID($Admission->idstudent);
                        $course = courseByID($Admission->idcourse);
                        $school = schoolByID($Admission->idschool);
                        ?>
                        <div class="no-print mb-3 text-center">
                            <button onclick="window.print()" class="btn btn-lg btn-success"><i class="fas fa-print"></i> Print Now</button>
                            <button onclick="window.location.href='printCertificate.php'" class="btn btn-lg btn-secondary">New Search</button>
                        </div>
                        <div class="certificate-container">
                            <img src="images/IMG_20230519_0002.jpg" alt="Certificate Background" id="certificateimg">
                            <span class="cert-text" id="no"><?php echo $Admission->registration; ?></span>
                            <span class="cert-text" id="dated"><?php echo date('d-M-Y', strtotime($Admission->created_at)); ?></span>
                            <span class="cert-text" id="name"><?php echo strtoupper($student->fullname); ?></span>
                            <span class="cert-text" id="guardian"><?php echo strtoupper($student->fathername); ?></span>
                            <span class="cert-text" id="school"><?php echo strtoupper($school->location); ?></span>
                            <span class="cert-text" id="from"><?php echo date('d/m/y', strtotime($Admission->created_at)); ?></span>
                            <span class="cert-text" id="to"><?php echo date('d/m/y', strtotime($Admission->created_at)); ?></span>
                            <span class="cert-text" id="category"><?php echo $course->coursename; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <div class="no-print"><?php include('footer.php'); ?></div>
    </div>
    <?php include('footerPlugins.php'); ?>
</body>
</html>
