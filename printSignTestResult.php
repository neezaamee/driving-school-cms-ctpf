<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--Head-->
    <?php include('Head.php')?>
        <!--/Head-->

        <body onload="window.print()">
            <!-- PHP Code: print Sign Test Result -->
            <?php
                        
                            //echo "<center><h3>User Added <span style='color: green;'>Successfully</h3></center>";
                            $currentDateTime= date("d-m-Y h:i:a");
                            $fetchTestDataQ = "SELECT * FROM tests ORDER BY id DESC LIMIT 1";
                            $fetchTestDataQR = mysqli_query($con,$fetchTestDataQ);	
                            $fetchTestDataNum = mysqli_num_rows($fetchTestDataQR);	
                            if($fetchTestDataNum>0)
	                           {
		                          $testDataObject = mysqli_fetch_object($fetchTestDataQR);
                                    //$_SESSION['candidateID'] = $candidateDataObject->id;
                                    $TestID = $testDataObject->id;
                                    $candidateID = $testDataObject->candidateid;
                                    $signTestResult = $testDataObject->signtest;                                    
                                
                                $fetchCandidateDataQ = "SELECT * FROM candidates WHERE id='$candidateID'";
                            $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);	
                            $fetchCandidateDataNum = mysqli_num_rows($fetchCandidateDataQR);	
                            if($fetchCandidateDataNum>0)
	                           {
		                          $candidateDataObject = mysqli_fetch_object($fetchCandidateDataQR);
                                    //$_SESSION['candidateID'] = $candidateDataObject->id;
                                    $candidateName = $candidateDataObject->name;
                                    $candidateFatherName = $candidateDataObject->fathername;
                                    $candidateToken = $candidateDataObject->id;
                                    $candidateCNIC = $candidateDataObject->cnic;
                                    //$candidateLearnerPermitNo = $candidateDataObject->lpdate;
                                    $candidateLicenseCategory = $candidateDataObject->liccat;
                                
                            }
                                
                            }
?>
                <!--Token Table-->
                <div class="printToken" style="width: 400px; height: 400px; margin: auto;">
                    <table class="table table-bordered">
                        <th colspan="2" class="text-center">City Traffic Police Faisalabad</th>
                        <tr>
                            <th>Date Time:</th>
                            <td>
                                <?php echo $currentDateTime; ?>
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
                            <td>Not Attempted </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center">Developed by: IT Branch CTPF</th>
                        </tr>
                    </table>
                </div>
                <!--/Token Table-->
                <?php
		
	                           

                            
                        ?>
                    <!--/ PHP Code: Print Sign Test Result -->
        </body>
        <script>
            setTimeout(function () {
                window.location.href = 'index.php';
            }, 3000);
        </script>