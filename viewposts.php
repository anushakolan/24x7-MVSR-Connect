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
    <div id="header">
    <label>Questions</label>
    </div>
   	     <form method="post" action="viewposts.php">

      <?php echo display_error();
      
      ?> 
        <div class="input-group">
      <label>Enter id of topic to search posts</label>
      <input type="text" name="topicid">
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="getposts_btn">Get Posts</button>
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="all_btn">All Posts</button>
    </div>
     
    <div class="input-group">
      <button type="submit" class="btn" name="enteranswer_btn">Answer</button>
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
    	
<table width="100%" border="1">      
      <thead>
        <tr>
          <th>Post Id</th>
          <th>Topic id</th>
          <th>Topic</th>
          <th>Date</th>
          <th>Username</th>
          <th>Question</th>
        </tr>
      </thead>
      <?php
      $db = mysqli_connect('localhost', 'root', '', 'quora');
	  if($db === false)
	  {
      die("ERROR: Could not connect. " . mysqli_connect_error());
	  }
if (isset($_POST['getposts_btn']))
 {
  $row1=array();
  $topicis="";
    
global $db,$errors,$c,$row1;

 // $paperid  = e($_POST['paperid']);
  $topicid     = e($_POST['topicid']);
 

    if(!empty($topicid)){$c++;}
   
    if($c == 1)
    {
      if(!empty($topicid))
      {
        $query1="SELECT posts.postid,posts.topicid,topics.topic,posts.date,posts.username,posts.question FROM posts INNER JOIN topics ON posts.topicid=topics.topicid where posts.topicid=$topicid";
        $res2=mysqli_query($db, $query1);
        $row1 = mysqli_fetch_assoc($res2);
      }
    }
    else
    {
      echo "select a choice";
    }
      ?>

      
      <tbody>
        <?php
          do{
            ?>
            <tr>
              <td><?php echo $row1['postid'] ?></td>
              <td><?php echo $row1['topicid'] ?></td>
              <td><?php echo $row1['topic'] ?></td>
              <td><?php echo $row1['date'] ?></td>
              <td><?php echo $row1['username'] ?></td>
              <td><?php echo $row1['question']?></td> 
            </tr>
            <?php
          }
          while( $row1 = mysqli_fetch_assoc($res2) );
        ?>
      </tbody>
    </table>
<?php
  }
  else if((isset($_POST['all_btn'])))
  {
          $result = mysqli_query($db,"SELECT posts.postid,posts.topicid,topics.topic,posts.date,posts.username,posts.question FROM posts INNER JOIN topics ON posts.topicid=topics.topicid");

          while( $row1 = mysqli_fetch_assoc( $result ) ){
            ?>
            <tr>
              <td><?php echo $row1['postid'] ?></td>
              <td><?php echo $row1['topicid'] ?></td>
              <td><?php echo $row1['topic'] ?></td>
              <td><?php echo $row1['date'] ?></td>
              <td><?php echo $row1['username'] ?></td>
              <td><?php echo $row1['question']?></td> 
            </tr>
            <?php
 
          }
  }

  else
  {
          $result = mysqli_query($db,"SELECT posts.postid,posts.topicid,topics.topic,posts.date,posts.username,posts.question FROM posts INNER JOIN topics ON posts.topicid=topics.topicid");
          while( $row1 = mysqli_fetch_assoc( $result ) ){
            ?>
            <tr>
              <td><?php echo $row1['postid'] ?></td>
              <td><?php echo $row1['topicid'] ?></td>
              <td><?php echo $row1['topic'] ?></td>
              <td><?php echo $row1['date'] ?></td>
              <td><?php echo $row1['username'] ?></td>
              <td><?php echo $row1['question']?></td>
            </tr>
            <?php
 
          }
  }
 	 mysqli_close($db); ?>
    </body>
	</main>
    </html>

