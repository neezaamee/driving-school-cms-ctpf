<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Driving Test System CTP Faisalabad</title>
    <style>
      b.r{color:Crimson;}
      input[type=radio],input[type=checkbox],button,label{cursor:pointer;}
      #test{border:#000 1px solid;padding:10px 40px 40px 40px;}
      #tt{padding:10px;}
      div#test{ border-style: solid; padding:30px 50px 50px 50px; background-color: lightblue;}
    </style>
</head>
<center>
<body>
<?php

   include('connection.php');
  date_default_timezone_set("Asia/Karachi");
  $todayDate = date("d-m-Y");
  $entrytime = date("h:i:s");
  
  $name = $_POST['name'];
  $id=$_REQUEST['name'];
  
  $aks="SELECT * from candata where id=".$id;
  $ag=mysql_query($aks);
  $adk=mysql_fetch_array($ag);

  $tkn=$adk['token'];
  $asgntst =$adk['sgntst'];
  $finl = $adk['fnlres'];


  $result = $name;
  if ($result == $tkn and (empty($asgntst))) {  

      $dte=$todayDate;
      $nm=$adk['name'];
      $s_o=$adk['fwdname'];
      $nic=$adk['cnic'];
      $lcat=$adk['liccat'];
    }
    else {

        echo "<p align='center'> <font color=blue size='6pt'>. .  .  Already Feeded OR Record not Found Token No:</font> <font color=red size='6pt'>$name</font></p>";  
        goto a;
      }
  
//session_register();
  session_start();                         
  
  
  $_SESSION['ctoken'] = $tkn;
  $_SESSION["cname"] = $nm;
  $_SESSION["fhname"] = $s_o;
  $_SESSION["ccnic"] = $nic;
  $_SESSION["clcat"] = $lcat;

  echo "Token No.....", $tkn; 
  echo "......Date.....",$todayDate;
  echo "......Time.....", date("h:i:s");
  echo ".....Name.....",$nm;

?>

    <div> 
        <h2> Traffic Road Signs Test System </h2>
        <h3 id="test_status">Road Sign Test</h3> 
         <h3 id="timeleft">Time left</h3> 
    </div> 
    <div id="test"></div> 

    <script type="text/javascript">
        function resizeImg(img, height, width) {
        img.height = height;
        img.width = width;
        }
    </script>

    <script> 
    var myVar; 
    function startTimer() { 
      myVar = setInterval(function(){myTimer()},1000); 
      timelimit = maxtimelimit; 
    } 

    function myTimer() { 
      if (timelimit > 0) { 
        curmin=Math.floor(timelimit/60); 
        cursec=timelimit%60; 
        if (curmin!=0) { curtime=curmin+" minutes and "+cursec+" seconds left"; } 
                  else { curtime=cursec+" seconds left"; } 
        $_('timeleft').innerHTML = curtime; 
      } else { 
        $_('timeleft').innerHTML = timelimit+' - Out of Time - no credit given for answer'; 
    //    clearInterval(myVar); 
        checkAnswer(); 
      } 
      timelimit--; 
    }   

    var pos = 0, posn, choice, correct = 0, rscore = 0; 
    var maxtimelimit = 20, timelimit = maxtimelimit;  // 20 seconds per question 
    
    var questions = [ 

        [ "<img src='/rsts/signtest/informative/inf2.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", 
           "1", "2", "3", "4", "3"], 
        [ "<img src='/rsts/signtest/informative/inf6.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "1"], 
        [ "<img src='/rsts/signtest/mendatory/men6.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "4"],  
        [ "<img src='/rsts/signtest/mendatory/men8.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "1"], 
        [ "<img src='/rsts/signtest/mendatory/men10.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "1"],
        [ "<img src='/rsts/signtest/mendatory/men2.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "3"],
        [ "<img src='/rsts/signtest/precautionary/pre6.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],
        [ "<img src='/rsts/signtest/precautionary/pre8.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "1"],
        [ "<img src='/rsts/signtest/precautionary/pre10.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "4"], 
        [ "<img src='/rsts/signtest/precautionary/pre2.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "1"],    
        [ "<img src='/rsts/signtest/informative/inf1.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", 
           "1", "2", "3", "4", "3"], 
        [ "<img src='/rsts/signtest/informative/inf4.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "1"], 
        [ "<img src='/rsts/signtest/mendatory/men1.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "3"],  
        [ "<img src='/rsts/signtest/mendatory/men5.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "3"], 
        [ "<img src='/rsts/signtest/mendatory/men3.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "4"],
        [ "<img src='/rsts/signtest/mendatory/men4.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],
        [ "<img src='/rsts/signtest/precautionary/pre1.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],
        [ "<img src='/rsts/signtest/precautionary/pre4.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "3"],
        [ "<img src='/rsts/signtest/precautionary/pre5.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "4"], 
        [ "<img src='/rsts/signtest/precautionary/pre7.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "3"],    
        [ "<img src='/rsts/signtest/informative/inf7.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", 
           "1", "2", "3", "4", "1"], 
        [ "<img src='/rsts/signtest/informative/inf9.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
        "1", "2", "3", "4", "4"], 
        [ "<img src='/rsts/signtest/mendatory/men7.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],
        [ "<img src='/rsts/signtest/mendatory/men9.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",    
          "1", "2", "3", "4", "3"],
        [ "<img src='/rsts/signtest/precautionary/pre9.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],    
        [ "<img src='/rsts/signtest/informative/inf8.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", 
           "1", "2", "3", "4", "1"], 
        [ "<img src='/rsts/signtest/informative/inf5.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],
        [ "<img src='/rsts/signtest/informative/inf3.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],    
        [ "<img src='/rsts/signtest/precautionary/pre11.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "3"], 
        [ "<img src='/rsts/signtest/precautionary/pre12.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "1"], 
        [ "<img src='/rsts/signtest/mendatory/men11.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "4"],
        [ "<img src='/rsts/signtest/mendatory/men12.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "1"],
        [ "<img src='/rsts/signtest/precautionary/pre13.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "2"],  
        [ "<img src='/rsts/signtest/precautionary/pre14.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "2"],                             
        [ "<img src='/rsts/signtest/mendatory/men13.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "3"],
        [ "<img src='/rsts/signtest/mendatory/men14.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "3"], 
        [ "<img src='/rsts/signtest/precautionary/pre15.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "1"],                   
        [ "<img src='/rsts/signtest/precautionary/pre16.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "4"], 
        [ "<img src='/rsts/signtest/mendatory/men15.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "4"],
        [ "<img src='/rsts/signtest/mendatory/men16.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],
        [ "<img src='/rsts/signtest/precautionary/pre17.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "3"],            
        [ "<img src='/rsts/signtest/precautionary/pre18.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "4"], 
        [ "<img src='/rsts/signtest/mendatory/men18.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "3"],
        [ "<img src='/rsts/signtest/mendatory/men19.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "1"],     
        [ "<img src='/rsts/signtest/precautionary/pre19.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "4"],               
        [ "<img src='/rsts/signtest/precautionary/pre20.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
                   "1", "2", "3", "4", "3"], 
        [ "<img src='/rsts/signtest/mendatory/men20.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>",  
           "1", "2", "3", "4", "2"],
    ]; 

    var questionOrder = []; 
    var testQuestion  = 10;

    var maxNumberOfQuestions = questions.length;  // do NOT make BIGGER than number of 'questions' array 
    //var maxNumberOfQuestions = 10;  // do NOT make BIGGER than number of 'questions' array 

    function setQuestionOrder() { 
      questionOrder.length = 0; 
      for (var i=0; i<maxNumberOfQuestions; i++) { questionOrder.push(i); } 

        questionOrder.sort(randOrd);   // alert(questionOrder);  // shuffle display order 

        pos = 0;  posn = questionOrder[pos]; 
    } 

    function $_(IDS) { return document.getElementById(IDS); } 
    function randOrd() { return (Math.round(Math.random())-0.5); } 

    function renderResults(){ 
      var test = $_("test"); 
      // final result
      test.innerHTML = "<h3>You got "+correct+" of "+testQuestion+" questions correct</h3>"; 
      
      // data send to print page 
      var corr = correct
      var incorr = testQuestion-correct
      var totq = testQuestion
      window.location.href = "signprnt.php?correct=" + corr + "&incorrect=" + incorr;


      $_("test_status").innerHTML = "Test Completed"; 
      $_('timeleft').innerHTML = ''; 
      test.innerHTML += '<button onclick="location.reload()">Next-Test</a> '; 
      setQuestionOrder(); 
      correct = 0; 
      clearInterval(myVar); 
      return false; 
    } 

    function renderQuestion() { 
      var test = $_("test"); 
      $_("test_status").innerHTML = "Question "+(pos+1)+" of "+testQuestion; //display current ques status
      
      if (rscore != 0) { $_("test_status").innerHTML += '<br>Currently: '+(correct/rscore*100).toFixed(0)+'% correct'; }

      var question = questions[posn][0]; 
      var ch1 = questions[posn][1]; 
      var ch2 = questions[posn][2]; 
      var ch3 = questions[posn][3]; 
      var ch4 = questions[posn][4];

      test.innerHTML = "<h3>"+question+"</h3>"; 
      test.innerHTML += "<label><input type='radio' style='width:40px; height:40px;' name='choices' value='1'> "+ch1+"</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"; 
      test.innerHTML += "<label><input type='radio' style='width:40px; height:40px;' name='choices' value='2'> "+ch2+"</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"; 
      test.innerHTML += "<label><input type='radio' style='width:40px; height:40px;' name='choices' value='3'> "+ch3+"</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"; 
      test.innerHTML += "<label><input type='radio' style='width:40px; height:40px;'name='choices' value='4'> "+ch4+"</label><br><br>"; 
      test.innerHTML += "<button onclick='checkAnswer()'>Submit Answer</button>"; 

      timelimit = maxtimelimit; 
      clearInterval(myVar); 
      startTimer(); 
    } 

    function checkAnswer(){ 
      var choices = document.getElementsByName("choices"); 
      for (var i=0; i<choices.length; i++) { 
        if (choices[i].checked) { choice = choices[i].value; } 
      } 
      rscore++; 
      if (choice == questions[posn][5] && timelimit > 0) { correct++; } 
      pos++;  posn = questionOrder[pos]; 
      if (pos < testQuestion) { renderQuestion(); } else { renderResults(); } 
    } 

    
//window.location.href = "signprnt.php?correct=" + correct + "&incorrect=" + incorrect;


    window.onload = function() { 
      setQuestionOrder(); 
      renderQuestion(); 
    } 

    </script> 
    
</script>
<?php
a:
header('refresh: 5; url=signstest.php');
?>
</center>
</body>
</html>>




 
