<?php
  include ('functions.php');
  ?>

<!doctype html>
    <html lang="en">
    <style>
img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 0px;
    width: 180px;
    height: 50px;
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
      <meta charset="UTF-8">
      <meta http-equiv="pragma" content="no-cache" />
      <link href='https://fonts.googleapis.com/css?family=Cinzel Decorative' rel='stylesheet'>
      <title>View Posts</title>
    </head>
    <div class="container">           
  <a href='dashboard.php' class="login" title="homeicon"><img src="images/homeicon1.jpg" width="120" height="100"></a>
</div>
    <main>
       <body>
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
	  <link rel="stylesheet" type="text/css" href="style2.css">
     <form method="post" action="seeanswer.php">

      <?php echo display_error();
      
      ?> 
        
    </div>
    <div class="input-group">
    <label>Enter id of  to see answers</label>
      <input type="number" name="postid2">
    </div>
     <div class="input-group">
      <button type="submit" class="btn" name="seeanswer_btn">See answer</button>
    </div>
    
<style>
.input-group{
  display: inline-block;
   margin-right: 0.5em;
}
form, .content {

  width: 90%;
  margin: 3px auto;
  padding: 0px;
  border: 3px solid #B0C4DE;
  background: white;
  border-radius: 0px 0px 10px 10px;
}

</style>
  </form>
    <?php
if(isset($_POST['seeanswer_btn'])){
  $row1=array();
   $postid2  = e($_POST['postid2']);
   
   ?>
   <table width="100%" border="1">      
      <thead>
        <tr>
          <th>Post Id</th>
          <th>Question</th>
          <th>Answer Id</th>
          <th>Date</th>
          <th>Answered by</th>
          <th>Answer</th>
        </tr>
      </thead>
      <?php
      $db = mysqli_connect('localhost', 'root', '', 'quora');
    if($db === false)
    {
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }

  
    
global $db,$errors,$c,$row1,$rs2;

    if(!empty($postid2)){$c++;}
   
    if($c == 1)
    {
      if(!empty($postid2))
      {
        $query1="SELECT posts.postid,posts.question,answer.answerid,answer.date,answer.username,answer.answer FROM answer INNER JOIN posts ON posts.postid=answer.postid where answer.postid='$postid2'";
        $res2=mysqli_query($db, $query1);
       // $row1 = mysqli_fetch_assoc($res2);
      }
    }
    else
    {
      echo "select a choice";
    }
      ?>

      
      <tbody>
        <?php
           while( $row1 = mysqli_fetch_assoc($res2) ){
            ?>
            <tr>
              <td><?php echo $row1['postid'] ?></td>
              <td><?php echo $row1['question'] ?></td>
              <td><?php echo $row1['answerid'] ?></td>
              <td><?php echo $row1['date'] ?></td>
              <td><?php echo $row1['username'] ?></td>
              <td><?php echo $row1['answer']?></td> 
            </tr>
            <?php
          }
         
        ?>
      </tbody>
    </table>
<?php
}
 	 mysqli_close($db); ?>
    </body>
	</main>
    </html>