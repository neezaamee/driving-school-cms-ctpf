
<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->
<?php
$userName = $_SESSION['loginUsername'];
$userID = $_SESSION['loginUserID'];

$User = userByID($userID);
$userSchoolID = $User->idschool;  
$School = schoolByID($userSchoolID);
$schoolName = $School->location;
    
    
    ?>
<!--<body onload="window.print();">-->

<!--<?php header('Location: index.php'); exit; ?>-->
<style>
    #profiletbl tr td {
        padding: 20px;
    }

    table,
    tr,
    th,
    td {
        border: 1px solid black !important;
        border-collapse: collapse !important;
        vertical-align: middle !important;
    }

    @media print {

        table,
        th,
        tr,
        td {
            border: 1px solid black !important;
            border-collapse: collapse !important;
            vertical-align: middle !important;
        }
    }

</style>

<body onload="window.print();">
    <!-- PHP Code: add User -->
    <?php
            if(isset($_POST['submit']))
            {
                $voucherID = CleanData($_POST['voucherid']);
                $Voucher = voucherByID($voucherID);
                $Status = $Voucher->status;
                if($Status == 1){
                    echo "voucher paid";
                }else{
                    $voucherID = $Voucher->id;
                    $voucherNo = $Voucher->vouchernumber;
                    $courseName = courseByID($Voucher->idcourse)->coursename;
                    $PicknDrop = $Voucher->pickndrop;
                    $courseID = $Voucher->idcourse;
                    $courseName = courseByID($Voucher->idcourse)->coursename;
                    $Email = CleanData($_POST['email']);
                    $DOB = CleanData($_POST['dob']);
                    $paidDate = CleanData($_POST['paiddate']);
                    $bankID = CleanData($_POST['bank']);
                    $Address = CleanData($_POST['address']);
                    $Phone = CleanData($_POST['phone']);
                    $Group = CleanData($_POST['time']);
                    $bloodID = CleanData($_POST['blood']);
                    $Blood = bloodByID($bloodID)->name;
                    $timeGroup = CleanData($_POST['time']);
                    $studentID = $Voucher->idstudent;
                    //student details
                    $Student = studentByID($studentID);
                    $studentSchoolID = $Voucher -> idschool;
                    $Gender = $Student -> gender;
                    
                    $sql = "SELECT * FROM admissions";
                    $Result = mysqli_query($con,$sql);
                    $NR = mysqli_num_rows($Result);
                    if($NR>0)
                    {
                        $NR = $NR+1;
                    }
                    else
                    {
                        $NR = 1;
                    }
                    //Year + CTPF + SchoolID + Admission No                
                    $Registration = date("y").$studentSchoolID."CTPF".$NR;
                
                //Fee Payment
                $feePaymentID = newFeePayment($voucherID, $studentID, $studentSchoolID, $bankID, $paidDate, $userID);
                
                //New Admission
                $newAdmission = newAdmission($Registration, $PicknDrop, $studentID, $courseID, $voucherID, $feePaymentID, $studentSchoolID, $userID);
                
                //Update Voucher Status
                $voucherUpdate = updateVoucherStatusToPaid($voucherID);
                
                //Update Student
                $studentUpdate = updateStudentDetails($studentID, $Email, $DOB, $Address, $Phone, $Group, $bloodID);
                
                ?>
                <!--Token Table-->
                <?php
                        $copy = "";
                        for($i = 1; $i <= 1; $i++){ 
                    ?>

                <table id="profiletbl" class="table" style="width: 100%; margin: auto;">
                    <tr id="form-heading">
                        <th class="text-center" colspan="5" style="font-size: x-large;">Admission Form <br /><?php echo "Driving School ".$schoolName. " - City Traffic Police Faisalabad" ;?></th>
                    </tr>

                    <tr>
                        <th>Admission Date</th>
                        <td><?php echo date("d-m-Y"); ?></td>
                        <th>Registration No</th>
                        <td><?php echo $Registration; ?></td>
                        <th class="col-xs-12 text-center" style="width: 20%">Photo</th>
                    </tr>
                    <tr>
                        <th>Voucher Number</th>
                        <td><?php echo $voucherNo;?></td>
                        <th>Voucher Paid Date</th>
                        <td><?php echo $paidDate."<br>".bankByID($bankID)->name; ?></td>
                        <td rowspan="6" style="margin: auto;" class="text-center align-middle" disabled>Photo</td>
                    </tr>
                    <tr>
                        <th>Name of Student</th>
                        <td><?php echo strtoupper($Student->fullname); ?></td>
                        <th>CNIC</th>
                        <td><?php echo $Student->cnic; ?></td>

                    </tr>
                    <tr>
                        <th>Guardian</th>
                        <td><?php echo strtoupper($Student->fathername); ?></td>
                        <th>Email</th>
                        <td><?php echo $Email; ?></td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td><?php echo $DOB; ?></td>
                        <th>Phone</th>
                        <td><?php echo $Phone; ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>
                            <?php
                                    if($Gender == 0){
                                        $Gender = "Female";
                                    }elseif($Gender == 1){
                                        $Gender = "Male";
                                    }else{
                                        $Gender = "Other";
                                    }
                                    echo $Gender;
                                ?>
                        </td>
                        <th>Time</th>
                        <td><?php echo $timeGroup; ?></td>
                    </tr>
                    <tr>
                        <th>Blood Group</th>
                        <td><?php echo $Blood; ?></td>
                        <th>Course</th>
                        <td><?php echo $courseName; ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td colspan="6"><?php echo $Address; ?></td>
                    </tr>
                    <tr>

                    </tr>
                </table>
                <br />
                <br />                
                <table class="table" style="width: 100%; margin: auto;">
                    <tr>
                        <th style="width: 15%;">1</th>
                        <th>Photography</th>
                        <td style="width: 20%"></td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">2</th>
                        <th>CNIC Copy</th>
                        <td style="width: 20%"></td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">3</th>
                        <th>Learner Permit Copy</th>
                        <td style="width: 20%"></td>
                    </tr>
                </table>
                <br />
                <div class="ui three column grid">
                    <div class="column"><span class="text-center"><h2 style="padding: 70px 0 70px 0">Incharge <br />Car Driving School</h2></div>
                    <div class="column"></div>
                    <div class="column"><span class="text-center"><h2 style="padding: 70px 0 70px 0">Admin <br />Car Driving School</h2></span></div>
                </div>
                <table class="table" style="width: 100%; margin: auto;">
                    <tr>
                        <th class="text-center" colspan="6" style="padding: 20px; font-size: larger;">Sheet Student Course Attendance</th>
                    </tr>
                    <?php
                        for($i = 1; $i<=14; $i++){

                        ?>
                    <tr>
                        <th style="width: 18.5%"><?php echo "Class ". $i?></th>
                        <td class="text-center"></td>
                        <th style="width: 18.5%"><?php echo "Class ". $i+1;?></th>
                        <td class="text-center"></td>
                    </tr>

                    <?php
                        $i = $i +1;
                        } ?>
                </table>
                <!--<div class="ui three column grid">
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="column"><span class="text-center"><h2 style="padding: 70px 0 0 0">Incharge <br />Car Driving School</h2></span></div>
                </div>-->
                <?php
                    if($i <= 2)
                    {      
                ?>
                <hr style="color: black; border: 2px dotted; margin: 30px 0px" />
                <?php
                    }//endif
                    }//endforloop for table
                    }//endelse if voucher  not paid
                    }//end if submit
    elseif(isset($_POST['submit2']))
    {
        $voucherID = CleanData($_POST['voucherid']);
                $Voucher = voucherByID($voucherID);
                $Status = $Voucher->status;
                if($Status == 1){
                    echo "voucher paid";
                }else{
                    $voucherID = $Voucher->id;
                    $voucherNo = $Voucher->vouchernumber;
                    $courseName = courseByID($Voucher->idcourse)->coursename;
                    $PicknDrop = $Voucher->pickndrop;
                    $courseID = $Voucher->idcourse;
                    $courseName = courseByID($Voucher->idcourse)->coursename;
                    $paidDate = CleanData($_POST['paiddate']);
                    $bankID = CleanData($_POST['bank']);
                    $studentID = $Voucher->idstudent;
                    //student details
                    $Student = studentByID($studentID);
                    $Email = $Student->email;
                    $DOB = $Student->dob;
                    $studentSchoolID = $Voucher -> idschool;
                    $Gender = $Student -> gender;
                    
                    $Address = $Student->address;
                    $Phone = $Student->phone;
                    $bloodID = $Student->idblood;
                    $Blood = bloodByID($bloodID)->name;
                    $timeGroup = $Student->timegroup;
                    
                    $sql = "SELECT * FROM admissions";
                    $Result = mysqli_query($con,$sql);
                    $NR = mysqli_num_rows($Result);
                    if($NR>0)
                    {
                        $NR = $NR+1;
                    }
                    else
                    {
                        $NR = 1;
                    }
                    //Year + CTPF + SchoolID + Admission No                
                    $Registration = date("y").$studentSchoolID."CTPF".$NR;
                
                //Fee Payment
                $feePaymentID = newFeePayment($voucherID, $studentID, $studentSchoolID, $bankID, $paidDate, $userID);
                
                //New Admission
                $newAdmission = newAdmission($Registration, $PicknDrop, $studentID, $courseID, $voucherID, $feePaymentID, $studentSchoolID, $userID);
                
                //Update Voucher Status
                $voucherUpdate = updateVoucherStatusToPaid($voucherID);
                
                //Update Student
                //$studentUpdate = updateStudentDetails($studentID, $Email, $DOB, $Address, $Phone, $Group, $bloodID);
                
                ?>
                <!--Token Table-->
                <?php
                        $copy = "";
                        for($i = 1; $i <= 1; $i++){ 
                    ?>

                <table id="profiletbl" class="table" style="width: 100%; margin: auto;">
                    <tr id="form-heading">
                        <th class="text-center" colspan="5" style="font-size: x-large;">Admission Form <br /><?php echo "Driving School ".$schoolName. " - City Traffic Police Faisalabad" ;?></th>
                    </tr>

                    <tr>
                        <th>Admission Date</th>
                        <td><?php echo date("d-m-Y"); ?></td>
                        <th>Registration No</th>
                        <td><?php echo $Registration; ?></td>
                        <th class="col-xs-12 text-center" style="width: 20%">Photo</th>
                    </tr>
                    <tr>
                        <th>Voucher Number</th>
                        <td><?php echo $voucherNo;?></td>
                        <th>Voucher Paid Date</th>
                        <td><?php echo $paidDate."<br>".bankByID($bankID)->name; ?></td>
                        <td rowspan="6" style="margin: auto;" class="text-center align-middle" disabled>Photo</td>
                    </tr>
                    <tr>
                        <th>Name of Student</th>
                        <td><?php echo strtoupper($Student->fullname); ?></td>
                        <th>CNIC</th>
                        <td><?php echo $Student->cnic; ?></td>

                    </tr>
                    <tr>
                        <th>Guardian</th>
                        <td><?php echo strtoupper($Student->fathername); ?></td>
                        <th>Email</th>
                        <td><?php echo $Email; ?></td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td><?php echo $DOB; ?></td>
                        <th>Phone</th>
                        <td><?php echo $Phone; ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>
                            <?php
                                    if($Gender == 0){
                                        $Gender = "Female";
                                    }elseif($Gender == 1){
                                        $Gender = "Male";
                                    }else{
                                        $Gender = "Other";
                                    }
                                    echo $Gender;
                                ?>
                        </td>
                        <th>Time</th>
                        <td><?php echo $timeGroup; ?></td>
                    </tr>
                    <tr>
                        <th>Blood Group</th>
                        <td><?php echo $Blood; ?></td>
                        <th>Course</th>
                        <td><?php echo $courseName; ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td colspan="6"><?php echo $Address; ?></td>
                    </tr>
                    <tr>

                    </tr>
                </table>
                <br />
                <br />                
                <table class="table" style="width: 100%; margin: auto;">
                    <tr>
                        <th style="width: 15%;">1</th>
                        <th>Photography</th>
                        <td style="width: 20%"></td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">2</th>
                        <th>CNIC Copy</th>
                        <td style="width: 20%"></td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">3</th>
                        <th>Learner Permit Copy</th>
                        <td style="width: 20%"></td>
                    </tr>
                </table>
                <br />
                <div class="ui three column grid">
                    <div class="column"><span class="text-center"><h2 style="padding: 70px 0 70px 0">Incharge <br />Car Driving School</h2></span></div>
                    <div class="column"></div>
                    <div class="column"><span class="text-center"><h2 style="padding: 70px 0 70px 0">Admin <br />Car Driving School</h2></span></div>
                </div>
                <table class="table" style="width: 100%; margin: auto;">
                    <tr>
                        <th class="text-center" colspan="6" style="padding: 20px; font-size: larger;">Sheet Student Course Attendance</th>
                    </tr>
                    <?php
                        for($i = 1; $i<=14; $i++){

                        ?>
                    <tr>
                        <th style="width: 18.5%"><?php echo "Class ". $i?></th>
                        <td class="text-center"></td>
                        <th style="width: 18.5%"><?php echo "Class ". $i+1;?></th>
                        <td class="text-center"></td>
                    </tr>

                    <?php
                        $i = $i +1;
                        } ?>
                </table>
                <!--<div class="ui three column grid">
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="column"><span class="text-center"><h2 style="padding: 70px 0 0 0">Incharge <br />Car Driving School</h2></span></div>
                </div>-->
                <?php
                    if($i <= 2)
                    {      
                ?>
                <hr style="color: black; border: 2px dotted; margin: 30px 0px" />
                <?php
                    }//endif
                    }//endforloop for table
                    }//endelse if voucher  not paid
    }
                else
                {
                    echo mysqli_error($con);
                    echo "<h3 class='text-center'>Try Again.</h3>";
                }
                    mysqli_close($con);
                            
    ?>
    <!--/ PHP Code: add User -->
    <?php header('Location: index.php'); exit; ?>
</body>
 