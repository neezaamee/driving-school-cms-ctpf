<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->

<!--<body onload="window.print();">-->
<style>
    #form-heading{
        height: 20px;
    }
</style>
<body>
    <!-- PHP Code: add User -->
    <?php
    $a = true;
            if($a= true)
            {
                /*$schoolID = CleanData($_POST['schoolid']);
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
                $voucherNo = 1010;
                $prospectusFee = 500;
                $Total = $courseFee+$pickdropFee+$prospectusFee;
                $grandTotal = ($courseFee+$pickdropFee+$prospectusFee)-$Discount;
                $addStudent = addStudentCreateVoucher($schoolID,$CNIC, $Name, $fatherName, $Gender, $courseID, $pickdropFee, $voucherNo, $courseFee, $prospectusFee, $pickdropFee, $Total, $Discount, $grandTotal);*/
                ?>

    <!--Token Table-->
    <div class="printToken">

        <?php
                    $copy = "";
                    for($i = 1; $i <= 1; $i++){ 
                ?>

        <table class="table table-bordered" style="width: 100%; margin: auto;">
            <tr id="form-heading">
                <th class="text-center" colspan="5" style="font-size: x-large;">Car Driving School GM ABAD - City Traffic Police Faisalabad</th>
            </tr>

            <tr>
                <th>Admission Date</th>
                <td>06.12.2022</td>
                <th>Registration No</th>
                <td>256376</td>
                <th class="col-xs-12 text-center" style="width: 20%">Photo</th>
            </tr>
            <tr>
                <th>CNIC</th>
                <td>3310221557297</td>
                <th>Name of Student</th>
                <td>Ali</td>
                <td rowspan="7"></td>
            </tr>
            <tr>
                <th>Guardian</th>
                <td>Hassan</td>
                <th>Gender</th>
                <td>Male</td>
            </tr>
            <tr>
                <th>DOB</th>
                <td>01-01-1990</td>
                <th>Phone</th>
                <td>03216611821</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>nizami@email.com</td>
                <th>Time</th>
                <td>Morning</td>
            </tr>
            <tr>
                <th>Blood Group</th>
                <td>A+</td>
                <th>Course</th>
                <td>Car 2 Week</td>
            </tr>
            <tr>
                <th>Address</th>
                <td colspan="4">ABC Road Fsd</td>
            </tr>
            <tr>
                
            </tr>
        </table>
        <br />
        <table  class="table table-bordered" style="width: 100%; margin: auto;">
            <tr>
                <th class="text-center" colspan="6" style="font-size: larger">Sheet Student Course Attendance</th>
            </tr>
            <?php
            for($i = 1; $i<=14; $i++){
                
            ?>
            <tr>
                <th style="width: 15%"><?php echo "Class ". $i?></th>
                <td class="text-center"></td>
                <th style="width: 15%"><?php echo "Class ". $i+1;?></th>
                <td class="text-center"></td>
            </tr>
            
            <?php
            $i = $i +1;
            } ?>
        </table>
        <br />
        <table class="table table-bordered" style="width: 100%; margin: auto;">
            <tr>
                <th style="width: 15%;">1</th>
                <th>Photography</th>
                <td></td>
            </tr>
            <tr>
                <th style="width: 15%;">2</th>
                <th>CNIC Copy</th>
                <td></td>
            </tr>
            <tr>
                <th style="width: 15%;">3</th>
                <th>Learner License Copy</th>
                <td></td>
            </tr>
        </table>
        <?php
                        if($i <= 2)
                        {      
                        ?>
        <hr style="color: black; border: 2px dotted; margin: 30px 0px" />
        <?php
                        }
                    ?>
        <!--
                    <div class="ui divider"></div>

                    <table class="table table-bordered">
                        <tr>
                            <th colspan="4" class="text-center">Car Driving School GM ABAD -  City Traffic Police Faisalabad</th>
                        </tr>
                        <tr>
                            <th colspan="2">Fee Voucher</th>
                            <th colspan="2" class="text-right">(School Copy)</th>
                        </tr>
                        <tr>
                            <th colspan="2">Student Information</th>
                            <th colspan="2">Charges</th>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <th>Ali</th>
                            <th>Admission Fee</th>
                            <td>3000</td>
                        </tr>
                        <tr>
                            <th>Programme</th>
                            <td>
                                car (2 week)
                            </td>
                            <th>Prospectus/Syllabus Fee</th>
                            <td>500</td>
                        </tr>
                        <tr>
                            <th colspan="2">Challan Information</th>
                            <th>Pick n Drop</th>
                            <td>1000</td>

                        </tr>
                        <tr>
                            <th>Serial Number</th>
                            <td>2022-012-112</td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>Issue Date</th>
                            <td>
                                Dec 19, 2022
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Validity</th>
                            <td>Dec 25, 2022</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>NBP Account</th>
                            <td>103565656565656</td>
                            <th>Total</th>
                            <td>3500</td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="4" class="text-center">Car Driving School GM ABAD -  City Traffic Police Faisalabad</th>
                        </tr>
                        <tr>
                            <th colspan="2">Fee Voucher</th>
                            <th colspan="2" class="text-right">(Student Copy)</th>
                        </tr>
                        <tr>
                            <th colspan="2">Student Information</th>
                            <th colspan="2">Charges</th>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <th>Ali</th>
                            <th>Admission Fee</th>
                            <td>3000</td>
                        </tr>
                        <tr>
                            <th>Programme</th>
                            <td>
                                car (2 week)
                            </td>
                            <th>Prospectus/Syllabus Fee</th>
                            <td>500</td>
                        </tr>
                        <tr>
                            <th colspan="2">Challan Information</th>
                            <th>Pick n Drop</th>
                            <td>1000</td>

                        </tr>
                        <tr>
                            <th>Serial Number</th>
                            <td>2022-012-112</td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>Issue Date</th>
                            <td>
                                Dec 19, 2022
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Validity</th>
                            <td>Dec 25, 2022</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>NBP Account</th>
                            <td>103565656565656</td>
                            <th>Total</th>
                            <td>3500</td>
                        </tr>
                    </table>-->
        <?php } ?>


    </div>
    <!--/Token Table-->
    <?php
               
                            

                }
                else
                {
                    echo mysqli_error($con);
                    echo "<h3 class='text-center'>Try Again.</h3>";
                }
                    mysqli_close($con);
                            
    ?>
    <!--/ PHP Code: add User -->
</body>
<script>
    /*setTimeout(function() {
        window.location.href = 'index.php';
    }, 3000);*/

</script>
