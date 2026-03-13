<?php
include('connection.php');
if(isset($_POST["submit"])) {
    if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['questionImg']['tmp_name']) && is_uploaded_file($_FILES['opt1']['tmp_name'])) {
		$sourcePath = $_FILES['questionImg']['tmp_name'];
        $sourcePath1 = $_FILES['opt1']['tmp_name'];

		$targetPath = "images/".$_FILES['questionImg']['name'];
		$targetPath1 = "images/".$_FILES['opt1']['name'];

        if(move_uploaded_file($sourcePath,$targetPath) && move_uploaded_file($sourcePath,$targetPath)) {
            
            $addCandidateQ = "INSERT INTO questions(questiontext, opt1) VALUES('$targetPath', '$targetPath1')";
                            $addCandidateQR = mysqli_query($con,$addCandidateQ);

                                if($addCandidateQR)
                                {       
                                    echo "<center><h3>User Added <span style='color: green;'>Successfully</h3></center>";
                                    ?>
<!--<script>
                    setTimeout(function () {
                        window.location.href = 'index.php';
                    }, 2000);
                </script>-->
<?php
                                }
                                else
                                {
                                    echo mysqli_error($con);
                                    echo "<h3 class='text-center'>Try Again.</h3>";
                                }
?>
<?php
		}
	}
}
}
?>
<?php
/*

if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['questionImg']['tmp_name']) && is_uploaded_file($_FILES['opt1']['tmp_name'])) {
		$sourcePath = $_FILES['questionImg']['tmp_name'];
        $sourcePath1 = $_FILES['opt1']['tmp_name'];

		$targetPath = "images/".$_FILES['questionImg']['name'];
		$targetPath1 = "images/".$_FILES['opt1']['name'];

        if(move_uploaded_file($sourcePath,$targetPath) && move_uploaded_file($sourcePath,$targetPath)) {
            
            $addCandidateQ = "INSERT INTO questions(questiontext, opt1) VALUES('$targetPath', '$targetPath1')";
                            $addCandidateQR = mysqli_query($con,$addCandidateQ);

                                if($addCandidateQR)
                                {       
                                    echo "<center><h3>User Added <span style='color: green;'>Successfully</h3></center>";
                                    ?>
<!--<script>
                    setTimeout(function () {
                        window.location.href = 'index.php';
                    }, 2000);
                </script>-->
<?php
                                }
                                else
                                {
                                    echo mysqli_error($con);
                                    echo "<h3 class='text-center'>Try Again.</h3>";
                                }
?> <img src="<?php echo $targetPath; ?>" width="200px" height="200px" class="upload-preview" /> <img src="<?php echo $targetPath1; ?>" width="200px" height="200px" class="upload-preview" />
<?php
		}
	}
}*/
		/*if(move_uploaded_file($sourcePath,$targetPath) || move_uploaded_file($sourcePath1,$targetPath1)) {
?> <img src="<?php echo $targetPath; ?>" width="200px" height="200px" class="upload-preview" /> <img src="<?php echo $targetPath1; ?>" width="200px" height="200px" class="upload-preview" />
<?php
		}*/
?>
