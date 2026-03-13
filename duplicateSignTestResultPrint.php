<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<?php include('Head.php')?>
<!--/Head-->
<!-- PHP Code: add User -->
<?php
                        if(isset($_POST['submit']))
                        {
                            
                            $candidateToken = CleanData($_POST['token']);
                                  
                                    //echo "<center><h3>User Added <span style='color: green;'>Successfully</h3></center>";
                                    //$currentDateTime= date("d-m-Y h:i:a");
                                    $todayDate= date("Y-m-d");
                                    $fetchCandidateDataQ = "SELECT * FROM candidates where DATE(entrydate)='$todayDate' AND token='$candidateToken'";
                                    $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);	
                                   $fetchCandidateDataNum = mysqli_num_rows($fetchCandidateDataQR);	
                                   if($fetchCandidateDataNum>0)
                                       {
                                          $candidateDataObject = mysqli_fetch_object($fetchCandidateDataQR);
                                            //$_SESSION['candidateID'] = $candidateDataObject->id;
                                            $candidateID = $candidateDataObject->id;
                                            $candidateName = $candidateDataObject->name;
                                            $candidateFatherName = $candidateDataObject->fathername;
                                            $candidateToken = $candidateDataObject->token;
                                            $candidateCNIC = $candidateDataObject->cnic;
                                            //$candidateLearnerPermitNo = $candidateDataObject->lpdate;
                                            $candidateLicenseCategory = $candidateDataObject->liccat;
                                            $candidateLicenseEntryDate = $candidateDataObject->entrydate;
                                       //check if candidate has sign test record
                                       $fetchCandidateTestDataQ = "SELECT * FROM tests where candidateid='$candidateID' ORDER BY id DESC LIMIT 1";
                                       $fetchCandidateTestDataQR = mysqli_query($con,$fetchCandidateTestDataQ);
                                       if(!$fetchCandidateTestDataQR){
                                           echo "query nahi chali";
                                       }
                                   $fetchCandidateTestDataNum = mysqli_num_rows($fetchCandidateTestDataQR);	
                                   if($fetchCandidateTestDataNum>0)
                                   {
                                    $testDataObject = mysqli_fetch_object($fetchCandidateTestDataQR);
                                            //$_SESSION['candidateID'] = $candidateDataObject->id;
                                            $TestID = $testDataObject->id;
                                            $candidateID = $testDataObject->candidateid;
                                            $signTestResult = $testDataObject->signtest;
                                        if ($signTestResult == True){
                                            $signTestResult = "Pass";

                                        }else{
                                            $signTestResult = "Fail";
                                        }
                                       ?>
<!--Token Table-->
<div class="printToken" style="width: 400px; height: 400px; margin: auto;">
    <table class="table table-bordered">
        <th colspan="2" class="text-center">City Traffic Police Faisalabad
            <br /> <u>Duplicate Token</u></th>
        <tr>
            <th>Date Time:</th>
            <td>
                <?php echo $candidateLicenseEntryDate; ?>
            </td>
        </tr>
        <tr>
            <th>Token #:</th>
            <td>
                <?php echo $candidateToken;?>
            </td>
        </tr>
        <tr>
            <th>Name:</th>
            <td>
                <?php echo $candidateName;?>
            </td>
        </tr>
        <tr>
            <th>Father Name:</th>
            <td>
                <?php echo $candidateFatherName;?>
            </td>
        </tr>
        <tr>
            <th>CNIC:</th>
            <td>
                <?php echo $candidateCNIC;?>
            </td>
        </tr>
        <tr>
            <th>Category:</th>
            <td>
                <?php echo $candidateLicenseCategory;?>
            </td>
        </tr>
        <tr>
            <th>Sign Test:</th>
            <td>
                <?php echo $signTestResult; ?>
            </td>
        </tr>
        <tr>
            <th>Road Test:</th>
            <td> Not Attempted </td>
        </tr>
        <tr>
            <th colspan="2" class="text-center">Developed by: IT Branch CTPF</th>
        </tr>
    </table> <a href="index.php">Back</a>
</div>
<!--/Token Table-->
<?php

                                   }
                                       else{
                                           echo "<h3 class='text-center'>No Sign Test Record Found</h3>";
                                       }





                                        ?>
<?php

                                       }


                                        else
                                        {
                                            echo "<h3 class='text-center'>Token Number not Found</h3>";
                                        }

                                    }
                            
                        ?>
<!--/ PHP Code: add User -->
