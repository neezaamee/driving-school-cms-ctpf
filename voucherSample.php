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
    
<style media="print">
    @page {
    size: landscape;
    margin:20px !important;        
    }
    html, body {
        width: auto;
        margin: auto;
        height: 0;
        font-size: 11px;
    }
    table {
        visibility: visible;
        background-image: url(images/CTPF2.png) !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
       }
</style>
<style>
    table,
    tr,
    th,
    td {
        border: 1px solid black !important;
        border-collapse: collapse !important;
    }
    ul{
        margin-left: -20px !important;
       }
    ol{
        text-transform: capitalize;
        margin-left: -20px !important;
        margin-bottom: 0px !important;
       }
      table {
        background-image: url(images/CTPF2.png) !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
          
       }
       
</style>
   
<!--<body onload="window.print();">-->

<body>
    <!-- PHP Code: add User -->
    <div class="printToken">
        <?php
           /* if(isset($_POST['submit']))
            {
                $schoolID = CleanData($_POST['schoolid']);
                $CNIC = CleanData($_POST['cnic']);
                $Name = CleanData($_POST['fullname']);
                $fatherName = CleanData($_POST['fathername']);
                $Gender = CleanData($_POST['gender']);
                $courseID = CleanData($_POST['course']);
                $pickdropFee = CleanData($_POST['pickndrop']);
                $Discount = CleanData($_POST['discount']);
                $Course = courseByID($courseID);
                $courseName = $Course->coursename;
                $courseFee = $Course->fee;                                
                //Creating Voucher FORMULA YMD-00+CourseID+SchoolID-00+LastVoucher + 1
                $voucherNo = date("ymd")."-".$courseID.$schoolID."-".rand(111111,999999);
                
                
                $prospectusFee = 500;
                $Total = $courseFee+$pickdropFee+$prospectusFee;
                $grandTotal = ($courseFee+$pickdropFee+$prospectusFee)-$Discount;
                $addStudent = addStudentCreateVoucher($schoolID,$CNIC, $Name, $fatherName, $Gender, $courseID, $pickdropFee, $voucherNo, $courseFee, $prospectusFee, $pickdropFee, $Total, $Discount, $grandTotal);*/
        ?>

        <!--Token Table-->
               
                <div class="ui three column stackable relaxed grid">
                   <?php
                    $copy = "";
                    for($i = 1; $i < 4; $i++){                        
                    
                    ?>
                    <div class="column">        
                        <table class="ui table compact">
                            <tr>
                                <td colspan="2"><h3 class="text-center">Fee Voucher 2023 <br>Car Driving School People Colony <br>City Traffic Police Faislabad</h3></td>
                            </tr>
                            <tr><td colspan="2"> Account # <b>6010123313500013</b> <br>Bank of Punjab - Authorized Branches</td></tr>
                            <tr>
                                <td colspan="2">
                                    <ol style="margin-left: 0;">
                                        <li>GC university branch (code:0308)</li>
                                        <li>ghulam muhammadabad branch (code:0124)</li>
                                        <li>madina town branch  (code:0053)</li>
                                        <li>samanabad branch (code:0156)</li>
                                        <li>d-ground branch (code:0010)</li>
                                        <li>canal road branch (code:0534)</li>
                                        <li>chak jhumra branch (code:0133)</li>
                                        <li>jaranwala branch (code:0169)</li>
                                        <li>adda dijkot branch (code:0599)</li>
                                    </ol>
                                </td>
                                
                            </tr>
                            <tr>
                                <td><h4>Voucher #</h4></td>
                                <td><h4>230117-22-587784</h4></td>
                            </tr>
                            <tr>
                                <td>Issue Date</td>
                                <td>04-01-2023</td>
                            </tr>
                                <tr>
                                    <td>Due Date</td>
                                    <td>08-01-2023</td>
                                </tr>
                            <tr>
                                <td>Name</td>
                                <td>Sadaf Zahra</td>
                            </tr>
                            <tr>
                                <td>Guardian</td>
                                <td>Hadi Hussain</td>
                            </tr>
                            <tr>
                                <td>CNIC</td>
                                <td>3310255217297</td>
                            </tr>
                            <tr>
                                <td>Program</td>
                                <td>Car(2 Weeks)</td>
                            </tr>
                            <tr>
                                <td><h4>Description</h4></td>
                                <td><h4>Amount</h4></td>
                            </tr>
                            <tr>
                                <td>Admission Fee</td>
                                <td>3000</td>
                            </tr>
                            <tr>
                                <td>Prospectus + Course Book</td>
                                <td>400</td>
                            </tr>
                            <tr>
                                <td>Pick and Drop</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Fee Concession</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td><h4>Net Amount</h4></td>
                                <td><h4>3400/-</h4></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <ul style="text-style: justify;">
                                        <li>Fee must be deposited B/W 09am to 05pm in working days.</li>
                                        <li>Fee must be deposited within due date.</li>
                                        <li>Fee must be deposited in prescribed banks only.<br>No other bank are authorized to receive the fee in cash.</li>
                                        <li>This voucher will be cancelled automatically after due date.</li>
                                        <li>Any kind of editing in the voucher strictly prohibited.</li>
                                        <li>The bank will only accept the exact Net Amount.</li>
                                        <br>
                                        <span>
                                            <b>Note:</b> This is Computer generated fee voucher.
                                        </span>
                                    </ul>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <h3>
                                         <?php

                                if($i == 1){
                                    $copy = "Bank Copy";
                                }elseif($i == 2){
                                    $copy = "School Copy";
                                }else{
                                    $copy = "Student Copy";
                                }
                                echo $copy;
                                ?>
                                    </h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <?php
                    }
                    ?>
                </div>
<?php      
//}
        ?>
    </div>
    <!--/ PHP Code: add User -->
</body>
<script>
    /*setTimeout(function() {
        window.location.href = 'index.php';
    }, 3000);*/

</script>
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.2/dist/semantic.min.js"></script>