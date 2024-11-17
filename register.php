<?php
    $HintType = '';
    $HintMsg = '';

    session_start();
    // If already logged in, redirect to homepage
    if (isset($_SESSION["userid"])) {
      header('Location: index.php');
      exit();
    }

    if (!empty($_POST)) {
        define('DIRECT_VISIT_CHECK', 'IN_GUESTBOOK');
        require_once("./inc/core.class.php");

       $username = isset($_POST['username']) ? trim($_POST['username']) : '';
       $password = isset($_POST['password']) ? trim($_POST['password']) : '';
       $password_comfirm = isset($_POST['password_comfirm']) ? trim($_POST['password_comfirm']) : '';
       $captcha = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';

      //  if (!$captcha || strtolower($captcha) != $_SESSION['authnum_session']) {
      //     $HintType = 'error';
      //     $HintMsg = 'Incorrect captcha';
      //  } else 
      if (!$username) {
          $HintType = 'error';
          $HintMsg = 'Please enter a username';
       } else if (!$password) {
          $HintType = 'error';
          $HintMsg = 'Please enter a password';
       } else if ($password != $password_comfirm) {
         $HintType = 'error';
         $HintMsg = 'Passwords do not match';
       } else {
          // Check if username already exists
          $db = Database::getInstance();
          $Result = $db->Select("*", null, "user", "username='$username'", true);

          if ($Result) {
            $HintType = 'error';
            $HintMsg = 'Username already exists!';
          } else {
            // Username does not exist, proceed with registration
            $password_md5 = md5($password);
            $db->Insert("user", array("username", "password"), array($username, $password_md5));
            
            $HintType = 'succeed';
            $HintMsg = 'Registration successful! <a href="login.php">Go to Login >></a>';
          }
       }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags must come first, any other content must follow -->
    <title>User Registration</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>

    <!-- Add some margin at the top -->
    <div style="margin-top: 5%"></div>
    
    <form class="form-horizontal" action="" method="post">

      <div class="form-group">

        <?php if ($HintType == "succeed") { ?>
        <!-- Success message for registration -->
        <div class="alert alert-success col-sm-offset-4 col-sm-4 fade in" role="alert">
          <?php echo $HintMsg; ?>
          <!-- Close button -->
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
       <?php } else if ($HintType == "error") { ?>
        <!-- Error message for registration -->
        <div class="alert alert-danger col-sm-offset-4 col-sm-4 fade in" role="alert">
          <?php echo $HintMsg; ?>
          <!-- Close button -->
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php } ?>

      </div>

      <div class="form-group">
        <h2 class="col-sm-offset-4 col-sm-4">User Registration</h2>
      </div>
      
      <div class="form-group">
        <label for="inputUsername" class="col-sm-4 control-label">Username</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Enter a username">
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword" class="col-sm-4 control-label">Password</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Enter a password">
        </div>
      </div>
      <div class="form-group">
        <label for="inputPasswordConfirm" class="col-sm-4 control-label">Confirm Password</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" id="inputPasswordConfirm" name="password_comfirm" placeholder="Re-enter the password">
        </div>
      </div>
      <!-- <div class="form-group">
        <label for="inputCaptcha" class="col-sm-4 control-label">Captcha</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="inputCaptcha" name="captcha" placeholder="Enter the captcha">
        </div>
        <img id="captcha_pic" title="Click to refresh" src="./inc/getCaptcha.php" align="absbottom" onclick="this.src='./inc/getCaptcha.php?'+Math.random();"></img>
      </div>
       -->

      <div class="form-group">
        <div class="col-sm-offset-4 col-sm-3">
          <button type="submit" class="btn btn-primary">Register</button>
          <a href="login.php" class="btn btn-info">Already have an account? Login >></a>
        </div>
      </div>
    </form>

    <!-- jQuery (required for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <!-- Load all Bootstrap JavaScript plugins. You can also load individual plugins as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
