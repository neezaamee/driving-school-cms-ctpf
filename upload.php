<?php
include('connection.php');
if(isset($_FILES['questionImage'])){
    if(is_uploaded_file($_FILES['questionImage']['tmp_name'])) {
		$sourcePath = $_FILES['questionImage']['tmp_name'];
		$targetPath = "Q/Questions/".$_FILES['questionImage']['name'];

        
            
            $addCandidateQ = "INSERT INTO questions(questiontext) VALUES('$targetPath')";
            $addCandidateQR = mysqli_query($con,$addCandidateQ);
            //Getting Last Question Inserted ID
            $questionId=mysqli_insert_id($con);
                if($addCandidateQR)
                {       
                    //echo "<center><h3>User Added <span style='color: green;'>Successfully</h3></center>";
                    if(isset($_FILES['Ans1'])){
                            if(is_uploaded_file($_FILES['Ans1']['tmp_name'])) {
                                $sourcePath = $_FILES['Ans1']['tmp_name'];
                                $targetPath = "Q/Answers/".$_FILES['Ans1']['name'];

                                
                                    $addCandidateQ = "UPDATE questions SET `opt1`='$targetPath' WHERE `id`='$questionId'";
                                    $addCandidateQR = mysqli_query($con,$addCandidateQ);
                                        
                                
                            }
                        }
                     if(isset($_FILES['Ans2'])){
                            if(is_uploaded_file($_FILES['Ans2']['tmp_name'])) {
                                $sourcePath = $_FILES['Ans2']['tmp_name'];
                                $targetPath = "Q/Answers/".$_FILES['Ans2']['name'];

                                
                                    $addCandidateQ = "UPDATE questions SET `opt2`='$targetPath' WHERE `id`='$questionId'";
                                    $addCandidateQR = mysqli_query($con,$addCandidateQ);
                                        
                                
                            }
                        }
                    if(isset($_FILES['Ans3'])){
                            if(is_uploaded_file($_FILES['Ans3']['tmp_name'])) {
                                $sourcePath = $_FILES['Ans3']['tmp_name'];
                                $targetPath = "Q/Answers/".$_FILES['Ans3']['name'];

                                
                                    $addCandidateQ = "UPDATE questions SET `opt3`='$targetPath' WHERE `id`='$questionId'";
                                    $addCandidateQR = mysqli_query($con,$addCandidateQ);
                                  
                            }
                        }
                    if(isset($_FILES['Ans4'])){
                            if(is_uploaded_file($_FILES['Ans4']['tmp_name'])) {
                                $sourcePath = $_FILES['Ans4']['tmp_name'];
                                $targetPath = "Q/Answers/".$_FILES['Ans4']['name'];

                               
                                    $addCandidateQ = "UPDATE questions SET `opt4`='$targetPath' WHERE `id`='$questionId'";
                                    $addCandidateQR = mysqli_query($con,$addCandidateQ);
                                        
                                
                            }
                        }
                    if(isset($_FILES['audio'])){
                            if(is_uploaded_file($_FILES['audio']['tmp_name'])) {
                                $sourcePath = $_FILES['audio']['tmp_name'];
                                $targetPath = "Q/Audios/".$_FILES['audio']['name'];

                                
                                    $addCandidateQ = "UPDATE questions SET `audio`='$targetPath' WHERE `id`='$questionId'";
                                    $addCandidateQR = mysqli_query($con,$addCandidateQ);
                                        
                                
                            }
                        }
                    if(isset($_POST['correctopt'])){
                            $correctOption = $_POST['correctopt'];
                            $addCandidateQ = "UPDATE questions SET `correctopt`='$correctOption' WHERE `id`='$questionId'";
                            $addCandidateQR = mysqli_query($con,$addCandidateQ);
                                        
                    }
                    echo 'successfully added';
                }
                else
                {
                    echo mysqli_error($con);
                    echo "<h3 class='text-center'>Try Again.</h3>";
                }
		
	}
}

?>