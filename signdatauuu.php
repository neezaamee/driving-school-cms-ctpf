<!DOCTYPE html> 
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
</center>
  <script type="text/javascript">
      function resizeImg(img, height, width) {
          img.height = height;
          img.width = width;

          }
  </script>

  <center>
  <script>
    /* for comments
    */
    var questions = [
      [
      /* g */
      ],

      [[ "<img src='signtest/informative/inf6.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",1], 
      [[ "<img src='signtest/informative/inf7.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",1],
      [[ "<img src='signtest/mendatory/men3.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",4],
      [[ "<img src='signtest/mendatory/men6.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",4],  
      [[ "<img src='signtest/mendatory/men8.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",1],
      [[ "<img src='signtest/mendatory/men7.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",2],
      [[ "<img src='signtest/precautionary/inf2.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",2],
      [[ "<img src='signtest/precautionary/pre5.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",4],
      [[ "<img src='signtest/precautionary/pre7.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",3],
      [[ "<img src='signtest/precautionary/pre8.jpg' border='0' height='real_height' width='real_width' onload='resizeImg(this, 300, 600)'>", "1", "2", "3", "4"],"false",1], 
       
      ],

    to='',
    sec=20,
    A;
    /*  funcs */
    function _(x){return document.getElementById(x);}
    function getRandomInt(min,max){return Math.floor(Math.random() * (max - min)) + min;}
    function in_array(what,where){for(var i=0; i < where.length; i++)if(what == where[i])return true;return false;}
 
    function ask(){
      var len=questions.length;
      if(len==1){
      var answers=questions[0],
          a_len=answers.length,
        cor=0,
        incor=0,
        msg='';
        
        for(var z=0; z < a_len; z++){
        if(in_array('true',answers[z])){cor++;}
        else{incor++;}
        }

     msg='You have given '+cor+' correct and '+incor+' incorrect answers of '+a_len+' questions in the test.<br />';

      var corr = cor
      var incorr = incor
      var length = a_len
      correct = cor;
      incorrect = incorr;
      totalq = a_len
      
      window.location.href = "signprnt.php?correct=" + correct + "&incorrect=" + incorrect;


    _('test').innerHTML=msg;

    /* Check checkbox and open new window */

    if(_('nw').checked){
      var win=window.open('','resultWin','width=500,height=500,top=0,left=0,statusbar=no,searchbar=no,titlebar=no,toolbar=no,location=no,scrollbars=no');
      win.document.write('<center><div style="padding:150px 20px;">'+msg+'</div><a href="#null" onclick="window.close();">Close</a></center>');
      
      win.focus();
      win.moveBy((screen.width-500)/2,(screen.height-500)/3);
      }
      return;
      }
    else{
      var answered=questions[0].length,/* how many questions already answered */
      temp=questions.slice(1),/* get a copy of questions w/o first element */
      total=answered + temp.length,/* how many questions in the test */
      index=getRandomInt(0,temp.length),
        Q=A=temp[index],/* pick a random element from temp */
      Q_answer_index=Q[2], /* index of the correct answer */
      q_text=Q[0][0],/* question text */
      q_answers=Q[0].slice(1),/* possible answers */
      test=_('test'),
      i=0,/* counter */
      user_input='false';/* user answer */
      test.innerHTML='<div>You have answered '+answered+' questions from '+total+'</div><h3>'+q_text+'</h3><div id="tt"></div>';/* message current status of question/answer */
      
      for(; i<q_answers.length; i++){
        var val=(i+1==Q_answer_index) ? 'true' : 'false';
        test.innerHTML+='<b>'+(i+1)+'.</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type="radio" name="choices" value="'+val+'" title="'+val+'" style="height:55px; width:55px; vertical-align: middle;"/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<i>'+'</i>';
        }
      
        test.innerHTML+='<br /><button>Submit Answer</button>';

        var opts=test.querySelectorAll('[type="radio"]'),
          btn=test.querySelector('button');
      
      for(var k=0; k<opts.length; k++){
          opts[k].onchange=function(){user_input=this.value;}
          }
      
          btn.onclick=function(){
          A[1]=user_input;
          clearTimeout(to);
          answer(index+1);
          }
          
          timer(sec,index+1);
          }

          }

    function timer(val,ind){
      var ending=(val > 1) ? 's' : '';
      var txt='<b class="r">'+( val>9 ? val : ('0'+val) )+'</b> second'+ending+' left';
      if(val > 0){
      _('tt').innerHTML=txt;
      val--;
      to=setTimeout('timer('+val+','+ind+')',1000);
      }
      else{
      _('tt').innerHTML='Time is up';
      clearTimeout(to);
      answer(ind);
      return;
      }
      }

      function answer(ind){
        questions[0].push(A);
        questions.splice(ind,1);
        setTimeout('ask()',200);
        }

        onload=ask;
 
   </script>

     <div id="test"></div><label for="nw">
     <input type="checkbox"  id="nw" />&nbsp;Show results in a new window</label> 

</script>

</center>

<?php
a:
?>

</body>
</html>

