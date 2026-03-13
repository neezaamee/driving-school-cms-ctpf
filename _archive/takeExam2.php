<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
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
    $candidateCNIC = $_SESSION['candidateCNIC'];
    $userRole = $_SESSION['loginRole'];
    
?>
<?php
$wrongAnswers=0;
$correctAnswers=0;
$questionNum=0;
/*Fetch Questions*/
$fetchQuestionsQ="select * from questions";
$fetchQuestionsQR=mysqli_query($con,$fetchQuestionsQ);
$questionsLength= mysqli_num_rows($fetchQuestionsQR);
if($questionsLength > 0){    
    $_SESSION['totalQuestions']=$questionsLength;
}
else{
    echo "No Question Found in Database";
}

//echo "Name:  "; echo $candidateName; echo "CNIC: "; echo $candidateCNIC; echo " Token #: "; echo $candidateToken; echo " Total Questions: "; echo $questionsLength;
?>
<!--/ PHP Code: Token Entery -->
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php')?>
<!--/Head-->
<!--Body-->

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
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
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
                                    <h3 class="card-title">Sign Test: <?php echo "CNIC: <b>". $candidateCNIC. "</b> Name : <b>".$candidateName."</b>";?></h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- Test -->
                                <!--Fetch Questions-->
                                <?php

$query="select * from questions";

$rs=mysqli_query($con, $fetchQuestionsQ);
if(!isset($_SESSION['questionNum']))
{
	$_SESSION['questionNum']=0;
	//$questionNum=$_SESSION['questionNum'];
	mysqli_query($con,"delete from useranswers where sess_id='" . session_id() ."'");
	$_SESSION['trueans']=0;
	//$correctAnswers=$_SESSION['trueans'];
	
}
else
{	
		if(isset($_POST['nextquestion']) && isset($ans))
		{	
            //Save User Answer
                mysqli_data_seek($fetchQuestionsQR,$_SESSION['questionNum']);
				$row= mysqli_fetch_row($fetchQuestionsQR);
				mysqli_query($con,"insert into useranswers(sess_id,candidateid,que_des, ans1,ans2,ans3,ans4,useropt,correctopt) values ('".session_id()."','$candidateID','$row[1]','$row[2]','$row[3]','$row[4]', '$row[5]','$ans','$row[6]')");
				mysqli_query($con,"insert into useranswers_permanent(sess_id,candidateid,que_des, ans1,ans2,ans3,ans4,useropt,correctopt) values ('".session_id()."','$candidateID','$row[1]','$row[2]','$row[3]','$row[4]', '$row[5]','$ans','$row[6]')");
				if($ans==$row[6])
				{
							$_SESSION['trueans']=$_SESSION['trueans']+1;
				}
				$_SESSION['questionNum']=$_SESSION['questionNum']+1;
		}
		else if(isset($_POST['getresult']) && isset($ans))
		{
				mysqli_data_seek($fetchQuestionsQR,$_SESSION['questionNum']);
				$row= mysqli_fetch_row($fetchQuestionsQR);	
				mysqli_query($con,"insert into useranswers(sess_id,candidateid,que_des, ans1,ans2,ans3,ans4,useropt,correctopt) values ('".session_id()."','$candidateID','$row[1]','$row[2]','$row[3]','$row[4]', '$row[5]','$ans','$row[6]')");
				mysqli_query($con,"insert into useranswers_permanent(sess_id,candidateid,que_des, ans1,ans2,ans3,ans4,useropt,correctopt) values ('".session_id()."','$candidateID','$row[1]','$row[2]','$row[3]','$row[4]', '$row[5]','$ans','$row[6]')");
				if($ans==$row[6])
				{
							$_SESSION['trueans']=$_SESSION['trueans']+1;
				}
				echo "<h1 class=head1> Result</h1>";
				$_SESSION['questionNum']=$_SESSION['questionNum']+1;
				echo "<Table align=center><tr class=tot><td>Total Question<td>"; echo $_SESSION['questionNum'];
				echo "<tr class=tans><td>True Answer<td>".$_SESSION['trueans'];
				$wrong=$_SESSION['questionNum']-$_SESSION['trueans'];
				echo "<tr class=fans><td>Wrong Answer<td> ". $wrong;
				echo "</table>";
            $totalQuestion=$_SESSION['questionNum'];
            $currentSession=session_id();
            $totalTrue=$_SESSION['trueans'];
            $finalResult=False;
            $signTestResult= False;
            
            if($totalTrue > 2){
                $signTestResult=True;             
            }
                             mysqli_query($con,"insert into tests(candidateid,session_id,totalquestions,totalright,totalwrong,signtest,finalresult,testby) values ('$candidateID','$currentSession','$totalQuestions','$totalTrue','$wrong','$signTestResult','$finalResult','$userRole')");
				echo "<h1 align=center><a href=review2.php> Review Question</a> </h1>";
				unset($_SESSION['questionNum']);
				unset($_SESSION['trueans']);
				exit;
		}
}
$rs=mysqli_query($con,"select * from questions");
if($_SESSION['questionNum']>mysqli_num_rows($rs)-1)
{
unset($_SESSION['questionNum']);
echo "<h1 class=head1>Some Error  Occured</h1>";
session_destroy();
echo "Please <a href=index.php> Start Again</a>";

exit;
}
mysqli_data_seek($rs,$_SESSION['questionNum']);
$row= mysqli_fetch_row($rs);
echo "<form name=myfm method=post action=takeExam.php>";
echo "<table width=100%> <tr> <td width=30>&nbsp;<td> <table border=0>";
$n=$_SESSION['questionNum']+1;                                
echo "<tR><td><span class=style2>Q ". $n .":<img src=". $row[1] ." width=45% height=200px>";
echo "<tr><td class=style8><input type=radio name=ans value=opt1><img src=". $row[2] ." width=10% height=50px>";
echo "<tr><td class=style8> <input type=radio name=ans value=opt2><img src=". $row[3] ." width=10% height=50px>";
echo "<tr><td class=style8><input type=radio name=ans value=opt3><img src=". $row[4] ." width=10% height=50px>";
echo "<tr><td class=style8><input type=radio name=ans value=opt4><img src=". $row[5] ." width=10% height=50px>";

if($_SESSION['questionNum']<mysqli_num_rows($rs)-1){
echo "<tr><td><input type=submit name=nextquestion value='Next Question'></form>";
    }
else{
echo "<tr><td><input type=submit name=getresult value='Get Result'></form>";
echo "</table></table>";
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
        <?php include ('footer.php')?>
        <!--/Footer Content-->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include ('footerPlugins.php')?>
</body>
<!--/Body-->

</html>
