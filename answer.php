<?php include('functions.php') ?>
<!DOCTYPE html>
<html>
<style>
    img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 0px;
    width: 130px;
    height: 40px;
    position: absolute;
    left: 0px;
    top: 1px;
    z-index: 0;
    }

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
   <head>
   <title>Answer</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <div class="container">           
  <a href="viewposts.php" class="login" title="homeicon"><img src="images/backicon.png" width="120" height="100"></a>
</div>
   </head>
   <body>
    <div class="header">
    <h2>Answer a question</h2>
  </div>
  <main>
        <?php
   if(!isset($_SESSION['username']))
    {
       header("location:login.php");
     }
      elseif (time() - $_SESSION['timeout'] > 60*60) 
              {
               // session timed out, last request is longer than 3 minutes ago
                $_SESSION = array();
              session_destroy();
              echo "Sorry, your session has expired.... ";
              echo  "Click here to <a href = 'login.php' tite = Login>Login";   
              header("location:login.php");         
             }
      else {
       $usr= $_SESSION['username'];
       $_SESSION['timeout']=time();
   }
   ?>
   
     
   <form method=post action="addpost.php">
      <?php echo display_error(); ?>
      <div class="input-group">
      <label>Enter id of post to answer</label>
      <input type="number" name="postid1">
    </div>
   <div class="input-group">
   <label>Answer</label><br>
   <textarea name="post_text1" rows=8 cols=40 wrap=virtual></textarea>
   </div>
   <div class="input-group">
      <button type="submit" class="btn" name="answer_btn">Post Answer</button>
    </div>
  </form>
</main>
  </body>
  </html>