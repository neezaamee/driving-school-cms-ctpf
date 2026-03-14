<?php session_start();
require_once('connection.php');
include('Functions.php');
?>
<?php

if (isset($_POST['login'])) {
  if (!isset($_POST['csrf']) || !verify_csrf_token($_POST['csrf'])) {
      die("<script>alert('Security Error: Invalid or missing CSRF token.'); window.location.href='Login.php';</script>");
  }

  $userName = CleanData($_POST['email']);
  $Password = CleanData($_POST['password']);

  $AdminLoginQ = "SELECT * FROM users WHERE username=?";
  
  $stmt = mysqli_prepare($con, $AdminLoginQ);
  mysqli_stmt_bind_param($stmt, "s", $userName);
  mysqli_stmt_execute($stmt);
  $AdminLoginQR = mysqli_stmt_get_result($stmt);

  $AdminLoginNum = mysqli_num_rows($AdminLoginQR);

  if ($AdminLoginNum > 0) {
    $AdminLoginRow = mysqli_fetch_assoc($AdminLoginQR);
    $dbPassword = $AdminLoginRow['password'];
    $userID = $AdminLoginRow['id'];
    
    // Verify password (supports seamless transition from plaintext to bcrypt hashes)
    $authSuccess = false;
    if (password_verify($Password, $dbPassword)) {
        $authSuccess = true;
    } elseif ($Password === $dbPassword) {
        // Legacy plaintext match - Hash it securely and update the database immediately
        $authSuccess = true;
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
        $updateQ = "UPDATE users SET password=? WHERE id=?";
        $updateStmt = mysqli_prepare($con, $updateQ);
        mysqli_stmt_bind_param($updateStmt, "si", $hashedPassword, $userID);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
    }
    
    mysqli_stmt_close($stmt);

    if ($authSuccess) {
        $Status = $AdminLoginRow['status'];
        if ($Status == 1) {
          // Prevent Session Fixation attacks
          session_regenerate_id(true);
          
          $_SESSION['loginUsername'] = $AdminLoginRow['username'];
          $_SESSION['loginUserID'] = $userID;
          $_SESSION['loginRole'] = $AdminLoginRow['idusertype'];
          $sessionID = session_id();
    
          $userLog =  userLog($userID, $sessionID, 'login');
    
          header("Location: index.php");
          exit;
        } else {
          echo "<script>alert('Your username is not activated. Contact IT Branch');</script>";
        }
    } else {
        echo "<script>alert('wrong email or password');</script>";
    }
  } else {
    echo "<script>alert('wrong email or password');</script>";
  }
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Login to Admin Panel</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
  <noscript>
    <link rel="stylesheet" href="assets/css/noscript.css" />
  </noscript>
  <style>
    @media only screen and (max-width: 500px) {
      footer {
        margin-top: -100px !important;
      }

      #wrapper {
        margin-top: -100px;
      }
    }
  </style>
</head>

<body>
  <!-- Wrapper -->
  <div id="wrapper">
    <!-- Header -->
    <header id="header">
      <div class="logo"> <span class="fab fa-adn fa-5x"></span> </div>
      <div class="content">
        <div class="inner">
          <h1>Admin Panel</h1>
          <h2>Driving Schools</h2>
          <p>City Traffic Police
            <br>Faisalabad
          </p>
          <!--<p>A fully responsive site template designed by <a href="https://html5up.net">HTML5 UP</a> and released<br /> for free under the <a href="https://html5up.net/license">Creative Commons</a> license.</p>-->
        </div>
      </div>
      <nav>
        <ul>
          <!--<li><a href="#intro">Intro</a></li>
<li><a href="#work">Work</a></li>-->
          <li><a href="#contact">Login</a></li>
          <li><a href="#about">About</a></li>
          <!--<li><a href="#elements">Elements</a></li>-->
        </ul>
      </nav>
    </header>
    <!-- Main -->
    <div id="main">
      <!-- About -->
      <article id="about">
        <h2 class="major">About</h2>
        <!--<span class="image main"><img src="images/pic05.jpg" alt="" /></span>-->
        <h1>CTP FAISALABAD</h1> <b>FB: fb.com/ctpfaisalabad</b>
        <br /> <b>Developed by <u>IT Branch</u></b>
        <br /> <b>PH: +92-41-9200514 </b>
      </article>
      <!-- Contact -->
      <article id="contact">
        <h2 class="major">Login</h2>
        <form method="post" action="Login.php">
          <input type="hidden" name="csrf" value="<?php echo generate_csrf_token(); ?>">
          <div class="field half first">
            <label for="email">Username</label>
            <input type="text" name="email" id="name" autofocus />
          </div>
          <div class="field half">
            <label for="password">Password</label>
            <input type="password" name="password" id="email" />
          </div>
          <!--<div class="field">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" rows="4"></textarea>
                        </div>-->
          <ul class="actions">
            <li>
              <input type="submit" name="login" value="Login" class="special" />
            </li>
            <!--<li><input type="reset" value="Reset" /></li>-->
          </ul>
        </form>
        <!--<ul class="icons">
                    <li><a href="www.twitter.com/ctpfsd" class="icon fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>
                    <li><a href="www.facebook.com/ctpfaisalabad" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="www.youtube.com/c/citytrafficpolicefaisalabad" class="icon fa-youtube"><span class="label">Youtube</span></a></li>
                    <li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
                </ul>-->
      </article>
    </div>
    <!-- Footer -->
    <footer id="footer">
      <p class="copyright">&copy; Developed by:
        <br>IT Branch
        <a href="https://facebook.com/ctpfaisalabad"> <b>City Traffic Police, Faisalabad</b></a>.
      </p>
    </footer>
  </div>
  <!-- BG -->
  <div id="bg"></div>
  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/skel.min.js"></script>
  <script src="assets/js/util.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>
