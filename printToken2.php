<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
    <!--Head-->
    <?php include('Head.php')?>
        <!--/Head-->

        <body onload="window.print()">
            <!-- PHP Code: add User -->
            <?php
                        if(isset($_POST['submit']))
                        {
                            
                            $candidateToken = CleanData($_POST['candidatetoken']);
                            $candidateIsCommercial = CleanData($_POST['candidateiscommercial']);
                            $candidateCNIC = CleanData($_POST['candidatecnic']);
                            $candidateName = CleanData($_POST['candidatename']);	
                            $candidateFatherName = CleanData($_POST['candidatefathername']);
                            //$candidateEmail = CleanData($_POST['candidateemail']);
                            $candidatePhone = CleanData($_POST['candidatephone']);
                            //$candidateBloodGroup = CleanData($_POST['candidatebloodgroup']);
                            $candidateAddress = CleanData($_POST['candidateaddress']);
                            $candidateLPNo = CleanData($_POST['candidatelpno']);
                            $candidateLPDate = CleanData($_POST['candidatelpdate']);
                            $candidateLicenseCategory = CleanData($_POST['licensecategory']);
                            $candidateSpecialCase = CleanData($_POST['specialcase']);
                            $candidateTicketCost = CleanData($_POST['candidateticketcost']);
                            $candidateLPCby = CleanData($_POST['lpcauthority']);
                        
                            $addCandidate = addCandidate($candidateToken,$candidateCNIC,$candidateName,$candidateFatherName,$candidatePhone,$candidateAddress,$candidateLPNo,$candidateLPDate,$candidateLicenseCategory,$candidateTicketCost);

                                if($addCandidate)
                                {
                                    
                                    $currentDateTime= date("d-m-Y h:i:a");
                                    //get last candidate
                                    $last_id = $con->insert_id;
                                    $candidate = candidateByID($last_id);
                                    /*$fetchCandidateDataQ = "SELECT * FROM candidates WHERE id='$last_id'";
                            $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);	
	                       $fetchCandidateDataNum = mysqli_num_rows($fetchCandidateDataQR);*/	
	                       
                                    $candidateID = $candidate->id;
                                    $candidateName = $candidate->name;
                                    $candidateFatherName = $candidate->fathername;
                                    $candidateToken = $candidate->token;
                                    $candidateCNIC = $candidate->cnic;
                                    //$candidateLearnerPermitNo = $candidateDataObject->lpdate;
                                    $candidateLicenseCategory = $candidate->liccat;
                                    $compToken = $candidateID."041".$candidateToken;
                                    $sql = "UPDATE candidates SET comptoken='$compToken' WHERE id='$last_id'";
                               
                                    if (!$result = $con->query($sql)) {
                                        echo "some error occured";
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
                            <th colspan="2" class="text-center">Developed by: IT Branch CTPF</th>
                        </tr>
                    </table>
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

                            }else{
                                    header("Location: addCandidate.php");
                                }
                            
                        ?>
                            <!--/ PHP Code: add User -->
        </body>
        <script>
            setTimeout(function () {
                window.location.href = 'addCandidate2.php';
            }, 3000);
        </script>