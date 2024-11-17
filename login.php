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

      if (!$username){
         $HintType = 'error';
         $HintMsg = 'Please enter your username';
      } else if (!$password) {
         $HintType = 'error';
         $HintMsg = 'Please enter your password';
      } else {
        $password_md5 = md5($password);

        $db = Database::getInstance();
        $Result = $db->Select("*", null, "user", "username='$username' and password='$password_md5'", true);
          if ($Result){
            // Login successful, set session and redirect to homepage
            $_SESSION["userid"] = $Result['id'];
            header('Location: index.php');
            exit();
          } else {
            $HintType = 'error';
            $HintMsg = 'Incorrect username or password!';
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
    <title>User Login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>

    <!-- Add some margin at the top -->
    <div style="margin-top: 5%"></div>

    <form class="form-horizontal" action="" method="post" >

      <div class="form-group">
        <?php if ($HintType == "error") { ?>
        <!-- Error message for login failure -->
        <div class="alert alert-danger col-sm-offset-4 col-sm-4 fade in" role="alert">
          <?php echo $HintMsg; ?>
          <!-- Close button -->
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php } ?>
      </div>

      <div class="form-group">
        <h2 class="col-sm-offset-4 col-sm-4">User Login</h2>
      </div>
      
      <div class="form-group">
        <label for="inputUsername" class="col-sm-4 control-label">Username</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Enter your username">
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword" class="col-sm-4 control-label">Password</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Enter your password">
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-offset-4 col-sm-3">
          <button type="submit" class="btn btn-primary">Login</button>
          <a href="register.php" class="btn btn-info">Don't have an account? Register here >></a>
        </div>
      </div>
    </form>
   
    <!-- jQuery (required for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <!-- Load all Bootstrap JavaScript plugins. You can also load individual plugins as needed. -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
