<style>
    .tans {
        color: green;
    }

    .style8 {
        color: red;
    }

</style>
<?php
session_start();
extract($_POST);
extract($_SESSION);
include("connection.php");
/*if($submit=='Finish')
{
	mysql_query("delete from mst_useranswer where sess_id='" . session_id() ."'") or die(mysql_error());
	unset($_SESSION['questionNo']);
	header("Location: index.php");
	exit;
}*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Online Quiz - Review Quiz </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="quiz.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
//include("header.php");
echo "<h1 class=head1> Review Test Question</h1>";

if(!isset($_SESSION['questionNo']))
{
		$_SESSION['questionNo']=0;
}
else if($submit=='Next Question' )
{
	$_SESSION['questionNo']=$_SESSION['questionNo']+1;
	
}
else if($submit=='Finish')
{
	mysqli_query($con,"delete from useranswers where sess_id='" . session_id() ."'") or die(mysqli_error());
	unset($_SESSION['questionNo']);
	header("Location: index.php");
	exit;
}

$rs=mysqli_query($con,"select * from useranswers where sess_id='" . session_id() ."'") or die(mysqli_error());
mysqli_data_seek($rs,$_SESSION['questionNo']);
$row= mysqli_fetch_row($rs);
echo "<form name=myfm method=post action=review2.php>";
echo "<table width=100%> <tr> <td width=30>&nbsp;<td> <table border=0>";
$n=$_SESSION['questionNo']+1;
echo "<tR><td><span class=style2>Que ".  $n .": $row[3]</style>";
echo "<tr><td class=".($row[8]=='opt1'?'tans':'style8').">$row[4]";
echo "<tr><td class=".($row[8]=='opt2'?'tans':'style8').">$row[5]";
echo "<tr><td class=".($row[8]=='opt3'?'tans':'style8').">$row[6]";
echo "<tr><td class=".($row[8]=='opt4'?'tans':'style8').">$row[7]";
if($_SESSION['questionNo']<mysqli_num_rows($rs)-1){
echo "<tr><td><input type=submit name=submit value='Next Question'>";
}
else{
echo "<tr><td><input type=submit name=submit value='Finish'></form>";
echo "</table></table>";
}
?>
