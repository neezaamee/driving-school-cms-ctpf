<!DOCTYPE html>
<html>
<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
?>
<!---
Site : http:www.smarttutorials.net
Author :muni
--->
<?php
if(!empty($_SESSION['name'])){

    $right_answer=0;
    $wrong_answer=0;
    $unanswered=0; 

   $keys=array_keys($_POST);
   $order=join(",",$keys);

   $response=mysql_query("select id,correctopt from questions where id IN($order) ORDER BY FIELD(id,$order)");

   while($result=mysql_fetch_array($response)){
       if($result['correctopt']==$_POST[$result['id']]){
               $right_answer++;
           }else if($_POST[$result['id']]==5){
               $unanswered++;
           }
           else{
               $wrong_answer++;
           }
   }
   $name=$_SESSION['name'];  
   mysql_query("update users set score='$right_answer' where user_name='$name'");
?>
<head>
    <title>Responsive Quiz Application Using PHP, MySQL, jQuery, Ajax and Twitter Bootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="../../assets/js/html5shiv.js"></script>
        <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->
</head>

<body>
    <header>
        <p class="text-center"> Welcome
            <?php 
                if(!empty($_SESSION['name'])){
                    echo $_SESSION['name'];
                }?>
        </p>
    </header>
    <div class="container result">
        <hr>
        <div class="row">
            <div class="col-xs-18 col-sm-9 col-lg-9">
                <div class='result-logo1'> <img src="image/cat.GIF" class="img-responsive" /> </div>
            </div>
            <div class="col-xs-6 col-sm-3 col-lg-3"> <a href="<?php echo BASE_PATH;?>" class='btn btn-success'>Start new Quiz!!!</a> <a href="<?php echo BASE_PATH.'logout.php';?>" class='btn btn-success'>Logout</a>
                <div style="margin-top: 30%">
                    <p>Total no. of right answers : <span class="answer"><?php echo $right_answer;?></span></p>
                    <p>Total no. of wrong answers : <span class="answer"><?php echo $wrong_answer;?></span></p>
                    <p>Total no. of Unanswered Questions : <span class="answer"><?php echo $unanswered;?></span></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html><?php } ?>
