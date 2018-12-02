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
      <title>View Topics</title>
    </head>
    <div class="container">           
  <a href="dashboard.php" class="login" title="homeicon"><img src="images/homeicon1.jpg" width="120" height="100"></a>
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
    <label>ALL TOPICS</label>
    </div>
   	    <form method="post" action="viewtopics.php">

      <?php echo display_error();
      
      ?> 
     <div class="input-group">
      <button type="submit" class="btn" name="addpost1_btn">Ask Question</button>
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="requesttopic_btn">Request a topic</button>
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
          <th>Topic Id</th>
          <th>Posted By</th>
          <th>Date</th>
          <th>Topic</th>
        </tr>
      </thead>
      <?php
      $db = mysqli_connect('localhost', 'root', '', 'quora');
	  if($db === false)
	  {
      die("ERROR: Could not connect. " . mysqli_connect_error());
	  }
       $result = mysqli_query($db,"SELECT * FROM topics");
          while( $row = mysqli_fetch_assoc( $result ) ){
            echo
            "<tr>
              <td>{$row['topicid']}</td>
              <td>{$row['author']}</td>
              <td>{$row['date']}</td>
              <td>{$row['topic']}</td>
            </tr>\n";
          }
  if(isset($_POST['all_btn']))
{
  header("location:addtopic.php");
}
 	 mysqli_close($db); ?>
    </body>
	</main>
    </html>