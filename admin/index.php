<?php
  define('DIRECT_VISIT_CHECK', 'IN_GUESTBOOK');
  require_once("../inc/core.class.php");

  session_start();
  if (isset($_SESSION['userid'])) {
    $user = new User($_SESSION['userid']);
  } else {
    header('Location: ../login.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags must come first; any other content must follow -->
    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for the admin panel -->
    <link href="../css/admin.css" rel="stylesheet">

  </head>
  <body>
    <!-- Top navigation bar -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" title="logoTitle" href="#">Admin Panel</a>
           </div>
           <div class="collapse navbar-collapse">
               <ul class="nav navbar-nav navbar-right">
                   <li role="presentation">
                       <a href="#">Current User: <span class="badge"><?php echo $user->getUsername(); ?></span></a>
                   </li>
				   <li>
				       <a href="../index.php">
                             <span class="glyphicon glyphicon-home"></span> Return to Homepage
					   </a>
				   </li>
                   <li>
                       <a href="../logout.php">
                             <span class="glyphicon glyphicon-lock"></span> Logout
					   </a>
                    </li>
                </ul>
           </div>
        </div>      
    </nav>
    <!-- Main content section -->
    <div class="pageContainer">
         <!-- Left sidebar navigation -->
         <div class="pageSidebar">
             <ul class="nav nav-stacked nav-pills">
                 <li role="presentation">
                     <a href="frame/home.php" target="mainFrame" >Admin Home</a>
                 </li>
                 <li role="present
