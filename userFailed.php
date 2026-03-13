<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<?php
$q = intval($_GET['q']);
$todayDate= date("Y-m-d");
//check if cnic has already issued token for today
$sql0="SELECT * FROM candidates WHERE cnic = '".$q."' AND DATE(entrydate) = '".$todayDate."'";
$result0 = mysqli_query($con,$sql0);
$result0Num = mysqli_num_rows($result0);
if($result0Num > 0){
    $row0 = mysqli_fetch_array($result0);  
    $candidateToken = $row0['token'];
    echo "Token issued already against this CNIC. Token Number is ".$candidateToken;
}else{
//check if candidate failed within 42 days
$sql="SELECT * FROM candidates WHERE cnic = '".$q."' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);  
$candidateID = $row['id'];
$sql1="SELECT testdate FROM tests WHERE candidateid = '$candidateID' AND signtest = 'Fail'";
$result1 = mysqli_query($con,$sql1);
$result1Num = mysqli_num_rows($result1);	
   if($result1Num>0){
       $row1 = mysqli_fetch_array($result1);
       $date = $row1['testdate'];       
       $now = time();
       $your_date = strtotime($date);
       $datediff = $now - $your_date;
       $days = round($datediff / (60 * 60 * 24));
       
       if($days < 43){
           
       echo "User Failed within ".$days." Candidate failed on ".$date;
       }else{
echo "CNIC is Ok";
       }
        }else{
        echo "CNIC is Ok";
        }
//$row1 = mysqli_fetch_array($result1)
  
  //$candidateID = $row['id'];

mysqli_close($con);
    }
?>
