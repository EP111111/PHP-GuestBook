<?php
  define('DIRECT_VISIT_CHECK', 'IN_GUESTBOOK');
  require_once("./inc/core.class.php");

  session_start();
  if (isset($_SESSION['userid'])) {
    $isLogin = true;
    $user = new User($_SESSION['userid']);
  } else {
    $isLogin = false;
  }

  $db = Database::getInstance();
  $comments = $db->Select("*", NULL, "comments", NULL, false);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other content must come after them -->
    <title>Guestbook</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
    <!-- Custom CSS for Homepage -->
    <link href="css/index.css" rel="stylesheet">
  </head>
  <body>
  
    <nav class="navbar navbar-default" style="margin-bottom: 0px;">
      <div class="container-fluid">
        <!-- Brand and toggle grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">My-Guestbook</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
          </ul>
          
          <ul class="nav navbar-nav navbar-right">
          <?php if (!$isLogin) { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
          <?php } else { ?>
            <li><a href="#">Welcome, <?php echo $user->getUsername(); ?></a></li>
            <li><a href="admin/index.php">Admin Panel</a></li>
            <li><a href="logout.php">Logout</a></li>
          <?php } ?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <div class="jumbotron" style="background-image: url(img/bg.png); background-size:100% 100%;  background-repeat: no-repeat; 
">
      <div class="container">
          <h1>Welcome to My Guestbook!</h1>
          <p>Leave your thoughts and connect with others here.</p>
          <p>
            <?php if ($isLogin) { ?>
            <a class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#addComment">Write a Comment</a>
            <?php } else { ?>
            <a class="btn btn-primary btn-lg" role="button" href="login.php">Write a Comment</a>
            <?php } ?>
          </p>
       </div>
    </div>

    <div class="container">
      <?php for ($i = 0; $i < count($comments); $i++) { 
          $author = new User($comments[$i]['owner']);
      ?>
      <div class="row">
        <!-- Comment Block -->
        <div class="comment-box col-md-3 col-sm-6 col-xs-12">
          <!-- Author Block -->
          <div class="author-box">
            <!-- Author Avatar -->
            <div id="avatar">
              <img src="./img/avatar/<?php echo $author->getAvatar() . "?r=" . rand(1, 99); ?>" height="150px" width="150px" />
            </div>
            <!-- Author Information -->
            <div id="info">
              <p>Username: <?php echo $author->getUsername(); ?></p>
              <p>Role: <?php echo $author->getLevel() > 0 ? '<font color="red"><b>Admin</b></font>' : 'Member'; ?></p>
            </div>
          </div>

          <!-- Content Block -->
          <div class="content-box">
            <!-- Comment Metadata -->
            <div id="date">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Comment ID: <?php echo $comments[$i]['id']; ?>
              &nbsp;&nbsp;&nbsp;
              <span class="glyphicon glyphicon-time" aria-hidden="true"></span> Date: <?php echo $comments[$i]['date']; ?>
            </div>
            <!-- Comment Content -->
            <div id="content">
              <?php echo $comments[$i]['text']; ?>
            </div>
          </div>
        </div>
      </div>
      <hr />
      <?php } ?>
    </div>

    <!-- jQuery (required for Bootstrap's JavaScript plugins) -->
    <script src="./js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="./js/bootstrap.min.js"></script>

    <!-- Footer -->
    <footer class="footer">
       <div class="container">
          &copy; 2024
       </div>
    </footer>

    <!-- Comment Modal -->
    <div class="modal fade" id="addComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <form action="addcomment.php" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Write a Comment</h4>
            </div>
            <div class="modal-body">
              <textarea type="text" class="form-control" id="kindeditor" name="content" placeholder="Share your thoughts..."></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- HTML Editor -->
    <script charset="utf-8" src="./js/editor/kindeditor-all-min.js"></script>
    <script charset="utf-8" src="./js/editor/lang/en.js"></script>
    <script>
      KindEditor.ready(function(K) {
        window.editor = K.create('#kindeditor', {
          width : '850px',
          height : '300px'
        });
      });
    </script>

  </body>
</html>
