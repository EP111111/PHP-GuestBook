<?php
  define('DIRECT_VISIT_CHECK', 'IN_GUESTBOOK');
  require_once("../../inc/core.class.php");

  session_start();
  if (isset($_SESSION['userid'])) {
    $user = new User($_SESSION['userid']);
  } else {
    die("You are not logged in! Please log in first!");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Center</title>

    <!-- Bootstrap -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-fluid" style="padding-top: 10px; padding-left: 30px;">

      <div class="row">
      <div class="col-sm-10 alert alert-info fade in" role="alert">
        Welcome to the Admin Center!
      </div>
    </div>

      <p><h3>Hello! <?php echo $user->getUsername(); ?></h3></p>
      <p>Please select the action you want to perform on the right</p>

    </div>

    <!-- jQuery (Bootstrap's JavaScript plugins require jQuery, so it must be included first) -->
    <script src="../../js/jquery.min.js"></script>
    <!-- Include all of Bootstrap's JavaScript plugins, or include individual files as needed -->
    <script src="../../js/bootstrap.min.js"></script>
  </body>
</html>
