<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
extract($_POST);
extract($_GET);
extract($_SESSION);
?>
<?php
    $candidateID = $_SESSION['candidateID'];
    $candidateName = $_SESSION['candidateName'];
    $candidateToken = $_SESSION['candidateToken'];
    $candidateLearnerPermitNo = $_SESSION['candidateLearnerPermitNo'];
    $candidateLicenseCategory = $_SESSION['candidateLicenseCategory'];
    $isCommercial = $_SESSION['candidateIsCommercial'];
    $candidateCNIC = $_SESSION['candidateCNIC'];
    $loginUserName = $_SESSION['loginUserName'];
    $loginRole = $_SESSION['loginRole'];
    
?>
<?php
$wrongAnswers=0;
$correctAnswers=0;
$questionNum=0;
/*Fetch Questions*/
$fetchQuestionsQ="select * from questions ORDER BY rand() LIMIT 10";
$fetchQuestionsQR=mysqli_query($con,$fetchQuestionsQ);
$questionsLength= mysqli_num_rows($fetchQuestionsQR);
if($questionsLength > 0){    
    $_SESSION['totalQuestions']=$questionsLength;
}
else{
    echo "No Question Found in Database";
}

?>
<!--/ PHP Code: Token Entery -->
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->
<!--Body-->
<!--<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>-->
<script>
    $(function() {
        $("#radio").buttonset();
    });

</script>
<style>
    .ansImg {
        width: 200px;
        height: 200px;
    }

    #radio input[type="radio"]:checked+img {
        border: 1px solid red;
    }

</style>
<script>
    $(document).ready(function() {
        // make following action fire when radio button changes
        $('input[type = radio]').change(function() {
            // find the submit button and click it on the previous action
            $('input[type = submit]').click()
        });
    });

</script>
<script>
    var audioQuestion = document.getElementById("audio");
    audioQuestion.autoplay = true;
    audioQuestion.load();

</script>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('topNav.php') ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include ('sidebar.php')?>
        <!--/ Main Sidebar Container-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0 text-dark">Sign Test <span id="countdown" style="float: right"></span></h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo "CNIC: <b>". $candidateCNIC. "</b> Name : <b>".$candidateName."</b> Token # : <b>".$candidateToken."</b>" ;?></h3>
                                </div>
                                <!-- /.card-header -->
                                <!--Fetch Questions-->
                                <?php

//$rs=mysqli_query($con, $fetchQuestionsQ);
if(!isset($_SESSION['questionNum']))
{
	$_SESSION['questionNum']=0;
	//$questionNum=$_SESSION['questionNum'];
	mysqli_query($con,"delete from useranswers where sess_id='" . session_id() ."'");
	$_SESSION['trueans']=0;
    $_SESSION['notanswered']=0;
	//$correctAnswers=$_SESSION['trueans'];
	
}
else
{	
		if(isset($_POST['nextquestion']))
		{	
            //Save User Answer
                mysqli_data_seek($fetchQuestionsQR,$_SESSION['questionNum']);                 
				$row= mysqli_fetch_row($fetchQuestionsQR);
            if(!isset($ans)){
                     $ans = "Not Answered";
                $_SESSION['notanswered'] = $_SESSION['notanswered']+1;
                 }
				mysqli_query($con,"insert into useranswers(sess_id,candidateid,questionid,que_des, ans1,ans2,ans3,ans4,useropt,correctopt) values ('".session_id()."','$candidateID','$qid','$questiontext','$opt1','$opt2','$opt3', '$opt4','$ans','$correctopt')");
				mysqli_query($con,"insert into useranswers_permanent(sess_id,candidateid,questionid,que_des, ans1,ans2,ans3,ans4,useropt,correctopt) values ('".session_id()."','$candidateID','$qid','$questiontext','$opt1','$opt2','$opt3', '$opt4','$ans','$correctopt')");
				
            if($ans===$correctopt)
				{
							$_SESSION['trueans']=$_SESSION['trueans']+1;
				}
				$_SESSION['questionNum']=$_SESSION['questionNum']+1;
		}
		else if(isset($_POST['getresult']))
		{
				mysqli_data_seek($fetchQuestionsQR,$_SESSION['questionNum']);
				$row= mysqli_fetch_row($fetchQuestionsQR);
            if(!isset($ans)){
                     $ans = "Not Answered";
                $_SESSION['notanswered'] = $_SESSION['notanswered']+1;
                 }
				mysqli_query($con,"insert into useranswers(sess_id,candidateid,questionid,que_des, ans1,ans2,ans3,ans4,useropt,correctopt) values ('".session_id()."','$candidateID','$qid','$questiontext','$opt1','$opt2','$opt3', '$opt4','$ans','$correctopt')");
				mysqli_query($con,"insert into useranswers_permanent(sess_id,candidateid,questionid,que_des, ans1,ans2,ans3,ans4,useropt,correctopt) values ('".session_id()."','$candidateID','$qid','$questiontext','$opt1','$opt2','$opt3', '$opt4','$ans','$correctopt')");
				if($ans===$correctopt)
				{
							$_SESSION['trueans']=$_SESSION['trueans']+1;
				}
            
            
				echo "";
				$_SESSION['questionNum']=$_SESSION['questionNum']+1;
				$wrong=$_SESSION['questionNum']-$_SESSION['trueans'];
				
            ?>
                                <div style="width: 400px; height: 400px; margin: 15px auto auto auto;">
                                    <table class="table table-bordered">
                                        <th colspan="2" class="text-center">City Traffic Police Faisalabad
                                            <br /> <u>Sign Test Result</u></th>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-center">
                                                <?php echo $_SESSION['questionNum'];?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>True</td>
                                            <td class="text-center">
                                                <?php echo $_SESSION['trueans'];?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Wrong</td>
                                            <td class="text-center">
                                                <?php echo $wrong; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Not Answered</td>
                                            <td class="text-center">
                                                <?php echo $_SESSION['notanswered']; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <?php
            $totalQuestion=$_SESSION['questionNum'];
            $currentSession=session_id();
            $totalTrue=$_SESSION['trueans'];
            $notAnswered=$_SESSION['notanswered'];
            $finalResult="Absent";            
            $signTestResult= "Fail";
            
            if($totalTrue > 6){
                $signTestResult="Pass";
                $finalResult="Absent";                
                echo "<center><h2 style='color: green'>You are Passed</h2></center>"; 
            }else{
                $finalResult = "Fail";
                echo "<center><h2 style='color: red'>You are Failed</h2></center>";
            }
                              mysqli_query($con,"insert into tests(candidateid,session_id,totalquestions,notanswered,totalright,totalwrong,signtest,finalresult,type,testby) values ('$candidateID','$currentSession','$totalQuestions','$notAnswered','$totalTrue','$wrong','$signTestResult','$finalResult','$isCommercial','$loginRole-$loginUserName')");
				echo "<h1 align=center><a href=review.php> Review Question</a> </h1>";
				echo "<h1 align=center><a href=printSignTestResult.php> Print Token</a> </h1>";
				unset($_SESSION['questionNum']);
				unset($_SESSION['trueans']);
				exit;
		}
}
//$rs=mysqli_query($con,"select * from questions ORDER BY rand() LIMIT 10");
if($_SESSION['questionNum']>mysqli_num_rows($fetchQuestionsQR)-1)
{
unset($_SESSION['questionNum']);
echo "<h1 class=head1>Some Error  Occured</h1>";
session_destroy();
echo "Please <a href=tokenfortest.php> Start Again</a>";

exit;
}
mysqli_data_seek($fetchQuestionsQR,$_SESSION['questionNum']);
$row= mysqli_fetch_row($fetchQuestionsQR);
                                ?>
                                <form name=myfm method=post action=takeExamFirst.php>
                                    <table>
                                        <?php
$n=$_SESSION['questionNum']+1;
?>
                                        <tr>
                                            <td colspan='4'>
                                                <h3>Q: <?php echo $n; ?>:<img src="<?php echo $row[1]; ?>" width=100% height=200px>
                                                    <input type="hidden" name="questiontext" value="<?php echo $row[1]; ?>"></h3>
                                                <input type="hidden" name="qid" value="<?php echo $row[0]; ?>">
                                            </td>
                                        </tr>
                                        <!--<div id="radio">-->
                                        <tr>
                                            <td>
                                                <input type="radio" name="ans" value="opt1" id="radio1">
                                                <input type="hidden" name="opt1" value="<?php echo $row[2]; ?>">
                                                <label for="radio1"><img src="<?php echo $row[2] ?>" alt="" class="ansImg"></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="ans" value="opt2" id="radio2">
                                                <input type="hidden" name="opt2" value="<?php echo $row[3]; ?>">
                                                <label for="radio2"><img src="<?php echo $row[3] ?>" alt="" class="ansImg"></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="ans" value="opt3" id="radio3">
                                                <input type="hidden" name="opt3" value="<?php echo $row[4]; ?>">
                                                <label for="radio3"><img src="<?php echo $row[4] ?>" alt="" class="ansImg"></label>
                                            </td>
                                            <td>
                                                <input type="radio" name="ans" value="opt4" id="radio4">
                                                <input type="hidden" name="opt4" value="<?php echo $row[5]; ?>">
                                                <input type="hidden" name="correctopt" value="<?php echo $row[6]; ?>">
                                                <label for="radio4"><img src="<?php echo $row[5] ?>" alt="" class="ansImg"></label>
                                            </td>
                                            <td>
                                                <audio loop hidden autoplay="true">
                                                    <source src="<?php echo $row[7]; ?>" type="audio/ogg" autoplay="true"> Your browser does not support the audio element. </audio>
                                            </td>
                                        </tr>
                                        <!--</div>-->
                                        <?php
if($_SESSION['questionNum']<mysqli_num_rows($fetchQuestionsQR)-1){
?>
                                        <tr>
                                            <td>
                                                <label for="submitButton">
                                                    <input class="submit" type=submit name=nextquestion id="currentQuestion" value='Next Question' hidden /> </label>
                                            </td>
                                        </tr>
                                        <?php
    }
else{
                                ?>
                                        <tr>
                                            <td>
                                                <label>
                                                    <input class="submit" type=submit name=getresult id="last" value='Get Result' hidden /> </label>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <?php
    }
?>
                                <!--/ Test-->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!--Footer Content-->
        <?php //include ('footer.php')?>
        <!--/Footer Content-->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include ('footerPlugins.php')?>
    <script>
        var timeleft = 25;
        var downloadTimer = setInterval(function() {
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                document.getElementById("countdown").innerHTML = "Finished";
            } else {
                document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
            }
            timeleft -= 1;
        }, 1000);

    </script>
    <script>
        function greet() {
            document.getElementById('currentQuestion').click();
        }

        function greett() {
            //alert('Howdy!');
            //document.getElementById('currentQuestion').click();
            document.getElementById('last').click();
        }
        setTimeout(greet, 24000);
        setTimeout(greett, 24000);

    </script>
</body>
<!--/Body-->

</html>
