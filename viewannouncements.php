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
      <title>Announcements</title>
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
    <label>Announcements</label>
    </div>
   	          <?php
      $db = mysqli_connect('localhost', 'root', '', 'registration');
	  if($db === false)
	  {
      die("ERROR: Could not connect. " . mysqli_connect_error());
	  }

      //execute the SQL query and return records
      $result = mysqli_query($db,"SELECT * FROM announcements");
      ?>
      <table width="100%" border="1">      
      <thead>
        <tr>
          <th>Post Id</th>
          <th>Posted By</th>
          <th>Date</th>
          <th>Details</th>
          <th>View</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while( $row1 = mysqli_fetch_assoc($result) )
          {
            ?>
            <tr>
              <td><?php echo $row1['postid'] ?></td>
              <td><?php echo $row1['postedby'] ?></td>
              <td><?php echo $row1['date'] ?></td>
              <td><?php echo $row1['details'] ?></td>
              <td><a href="announcements/<?php echo $row1['file'] ?>" target="_blank">view file</a></td>
 
            </tr>
            <?php
          }
        ?>
      </tbody>
    </table>
 	<?php mysqli_close($db); ?>
    </body>
	</main>
    </html>