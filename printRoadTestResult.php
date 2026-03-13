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
                        
                            //echo "<center><h3>User Added <span style='color: green;'>Successfully</h3></center>";
                            $currentDateTime= date("d-m-Y h:i:a");
                            $fetchTestDataQ = "SELECT * FROM tests ORDER BY id DESC LIMIT 1";
                            $fetchTestDataQR = mysqli_query($con,$fetchTestDataQ);	
                            $fetchTestDataNum = mysqli_num_rows($fetchTestDataQR);	
                            if($fetchTestDataNum>0)
	                           {
		                          $testDataObject = mysqli_fetch_object($fetchTestDataQR);
                                    
                                    $TestID = $testDataObject->id;
                                    $candidateID = $testDataObject->candidateid;
                                    $signTestResult = $testDataObject->signtest;
                                    $roadTestResult = $testDataObject->roadtest;
                                    //finding candidate data from candidates
                                    $Candidate = candidateByID($candidateID);
                                    $candidateName = $Candidate->name;
                                    $candidateFatherName = $Candidate->fathername;
                                    $candidateToken = $Candidate->token;
                                    $candidateCNIC = $Candidate->cnic;
                                    $candidateLicenseCategory = $Candidate->liccat;
                                
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
                <td>
                    <?php echo $roadTestResult; ?>
                </td>
            </tr>
            <tr>
                <th colspan="2" class="text-center">Developed by: IT Branch CTPF</th>
            </tr>
        </table>
    </div>
    <!--/Token Table-->
</body>
<script>
    setTimeout(function() {
        window.location.href = 'tokenForRoadTest.php';
    }, 3000);

</script>
