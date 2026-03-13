<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->

<!--<body onload="window.print();">-->

<body>
    <!-- PHP Code: add User -->
    <?php
            if(isset($_POST['submit']))
            {
                
                $CNIC = CleanData($_POST['cnic']);
                $Student = students_copyByCNIC($CNIC);
                $studentID = $Student->id;
                $Voucher = voucherByStudentID($studentID);
                
                $Name = $Student->fullname;
                $courseID = $Student->idcourse;
                $schoolID = $Student->idschool;
                $courseName = courseByID($Student->idcourse)->coursename;
                $courseFee = courseByID($Student->idcourse)->fee;
                $pickdropFee = $Student->pickndrop;
                $prospectusFee = $Voucher -> prospectus;
                $Total = $Voucher -> total;
                $Discount = $Voucher -> discount;
                $grandTotal = $Voucher -> grand_total;
                
                $sql = "SELECT * FROM vouchers ORDER BY id DESC LIMIT 1";
                $Result = mysqli_query($con,$sql);
                $Voucher = mysqli_fetch_object($Result);
                $lastVoucherID = $Voucher->id;
                $voucherNo = date("ymd")."-".$courseID.$schoolID."-".rand(111111,999999);
                $newVoucher = addDuplicateVoucher($voucherNo, $courseFee, $prospectusFee, $pickdropFee, $Total, $Discount, $grandTotal, $studentID);
                
                ?>

                <!--Token Table-->
                <div class="printToken">

                <?php
                    $copy = "";
                    for($i = 1; $i <= 3; $i++){ 
                ?>

                    <table class="table table-bordered" style="width: 80%; margin: auto;">
                        <tr>
                            <th colspan="4" class="text-center" style="font-size: larger;">Car Driving School GM ABAD - City Traffic Police Faisalabad</th>
                        </tr>
                        <tr>
                            <th colspan="2">Fee Voucher</th>
                            <th colspan="2" class="text-right">
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

                            </th>
                        </tr>
                        <tr>
                            <th colspan="2"><u>Student Information</u></th>
                            <th>Programme</th><td><?php echo $courseName; ?></td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <th><?php echo strtoupper($Name); ?></th>
                            <th colspan="2"><u>Charges</u></th>
                        </tr>
                        <tr>
                            <th>CNIC</th>
                            <td><?php echo $CNIC; ?></td>            
                            <th>Admission Fee</th>
                            <td><?php echo $courseFee?></td>
                        </tr>
                        <tr>
                            <th colspan="2"><u>Challan Information</u></th>
                            <th>Pick n Drop</th>
                            <td>
                                   <?php
                                    if($pickdropFee == 1){
                                        $pickdropFee = 1000;
                                    }
                                    echo $pickdropFee;
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <th>Voucher No.</th>
                            <td><?php echo $voucherNo; ?></td>
                            <th>Prospectus/Syllabus Fee</th>
                            <td><?php echo $prospectusFee; ?></td>

                        </tr>
                        <tr>
                            <th>Issue Date</th>
                            <td>
                                <?php echo date("d-M-Y");?>
                            </td>
                            <th>Total Amount</th>
                            <td><u><?php echo $Total. "/- RS"; ?></u></td>
                        </tr>
                        <tr>
                            <th>Validity</th>
                            <td>Dec 25, 2022</td>
                            <th>Discount</th>
                            <td><?php echo $Discount. "/- RS"; ?></td>
                        </tr>
                        <tr>
                            <th>Bank of Punjab (Any Branch)</th>
                            <th>A/C# &nbsp; &nbsp; 60101233313500013</th>
                            <th>Grand Total (Payable Amount )</th>
                            <th><?php echo $grandTotal."/- RS";?></th>
                        </tr>
                    </table>
                    <?php
                        if($i <= 2)
                        {      
                        ?>
                            <hr style="color: black; border: 2px dotted; margin: 20px 0px" />
                            <?php
                        }
                    ?>
                    <?php } ?>

               
                </div>
                <!--/Token Table-->
                <?php
               
                            

                }
                else
                {
                    ?>
                <form role="form" method="post" action="generateDuplicateVoucher.php" id="newEnrollmentForm">
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="InputCNIC">Enter CNIC</label>
                                <input type="text" class="form-control" id="cnic" placeholder="Enter CNIC" name="cnic" onkeyup="showUser(this.value);" autofocus>
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
    <!--/ PHP Code: add User -->
</body>
<script>
    /*setTimeout(function() {
        window.location.href = 'index.php';
    }, 3000);*/

</script>
