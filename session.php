============ Veriable send php page 1 to php page 2====
INSIDE "page1.php"

<?php
  // "session_register()" and "session_start();" both prepare the session ready for use, and "$myPHPvar=5"
  // is the variable we want to carry over to the new page. Just before we visit the new page, we need to
  // store the variable in PHP's special session area by using "$_SESSION['myPHPvar'] = $myPHPvar;"
  session_register();
  session_start();                      
  $myPHPvar=5;
  $_SESSION['myPHPvar'] = $myPHPvar;
?>

<a href="page2.php">Click this link</a>, and the "$myPHPvar" variable should carry through.


--------INSIDE "page2.php"--------

<?php
  // Retrieve the PHP variable (using PHP).
  session_start();
  $myPHPvar = $_SESSION['myPHPvar'];
  echo "myPHPvar: ".$myPHPvar." ..........(should say \"myPHPvar: 5\")<br>";
?>
============



===== set session veriable ===

<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// Set session variables
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
?>

</body>
</html>
-----Get PHP Session Variable Values ------

<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// Echo session variables that were set on previous page
echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
echo "Favorite animal is " . $_SESSION["favanimal"] . ".";
?>

</body>
</html>

==========================
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy();

echo "All session variables are now removed, and the session is destroyed." 
?>

</body>
</html>
==================