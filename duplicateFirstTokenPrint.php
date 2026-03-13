<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Only Admin Can Add User-->
<?php
if ($_SESSION['loginRole'] !== 'Admin') {
    ?>
<?php header('Location: index.php'); exit; ?>
<?php
    }
?>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->
<!-- PHP Code: add User -->

<body onload="window.print()">
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
                                    $candidateName = $candidateDataObject->name;
                                    $candidateFatherName = $candidateDataObject->fathername;
                                    $candidateToken = $candidateDataObject->token;
                                    $candidateCNIC = $candidateDataObject->cnic;
                                    //$candidateLearnerPermitNo = $candidateDataObject->lpdate;
                                    $candidateLicenseCategory = $candidateDataObject->liccat;
                                    $candidateLicenseEntryDate = $candidateDataObject->entrydate;
                                ?>
    <!--Token Table-->
    <div class="printToken" style="width: 400px; height: 400px; margin: auto;">
        <table class="table table-bordered">
            <th colspan="2" class="text-center">City Traffic Police Faisalabad
                <br /> <u>Duplicate Token</u> </th>
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
                <th colspan="2" class="text-center">Developed by: IT Branch CTPF</th>
            </tr>
        </table>
        <!--<a href="duplicateFirstToken.php">Back</a>-->
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

                            }

                            
                        ?>
</body>
<!--/ PHP Code: Duplicate First Token -->
<script>
    setTimeout(function() {
        window.location.href = 'duplicateFirstToken.php';
    }, 3000);

</script>
