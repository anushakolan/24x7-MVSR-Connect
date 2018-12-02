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
      <title>View Internal Papers</title>
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
    <label>ALL INTERNAL PAPERS</label>
    </div>
   	    <form method="post" action="sortintpapers.php">

      <?php echo display_error(); //this must be present to display errors

       ?>  
<h1>Search by any one format </h1>
    <div class="input-group">
      <label>Year</label>
      <input type="number" name="year">
    </div>
    <div class="input-group">
      <label>Subject</label>
      <input type="text" name="subject">
    </div>
    <div class="input-group">
      <label>year/sem</label>
      <input type="text" name="yearsem">
    </div>
    <div class="input-group">
      <label>internal</label>
      <input type="number" name="internal">
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="search_btn">Search</button>
    </div>
     <div class="input-group">
      <button type="submit" class="btn" name="all_btn">All</button>
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
          <th>Paper Id</th>
          <th>Date</th>
          <th>Filename</th>
          <th>Year</th>
          <th>Year/sem</th>
          <th>Subject</th>
          <th>Internal</th>
          <th>Type</th>
          <th>Size</th>
          <td>View</td>
          
        </tr>
      </thead>
      <?php
      $db = mysqli_connect('localhost', 'root', '', 'registration');
	  if($db === false)
	  {
      die("ERROR: Could not connect. " . mysqli_connect_error());
	  }
if (isset($_POST['search_btn']))
 {
  $row1=array();
  $paperid  = "";
  $year     = "";
  $internal = "";
  $subject  = "";
  $date     = "";
  $file     = "";
  $yearsem  = "";
  $type     = "";
  $size     = "";
 
    
global $db,$errors,$c,$row1;

 // $paperid  = e($_POST['paperid']);
  $year     = e($_POST['year']);
  $internal = e($_POST['internal']);
  $subject  = e($_POST['subject']);
  //$date     = e($_POST['date']);;
  //$file     = e($_POST['file']);;
  $yearsem  = e($_POST['yearsem']);
 // $type     = e($_POST['type']);;
 // $size     = e($_POST['size']);;
 

    if(!empty($year)){$c++;}
    if(!empty($yearsem)){$c++;}
    if(!empty($subject)){$c++;}
    if(!empty($internal)){$c++;}

   

    if($c == 1)
    {
      if(!empty($year))
      {
        $query1="SELECT * FROM `tbl_uploads` WHERE year='$year'";
        $res2=mysqli_query($db, $query1);
        $row1 = mysqli_fetch_assoc($res2);
      }
      else if(!empty($yearsem))
      {
        $query1="SELECT * FROM `tbl_uploads` WHERE yearsem='$yearsem'";
        $res2=mysqli_query($db, $query1);
        $row1 = mysqli_fetch_assoc($res2);
      }
      else if(!empty($subject))
      {
        $query1="SELECT * FROM `tbl_uploads` WHERE subject='$subject'";
        $res2=mysqli_query($db, $query1);
        $row1 = mysqli_fetch_assoc($res2);
      }
      else if(!empty($internal))
      {
        $query1="SELECT * FROM `tbl_uploads` WHERE internal='$internal'";
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
              <td><?php echo $row1['id'] ?></td>
              <td><?php echo $row1['date'] ?></td>
              <td><?php echo $row1['file'] ?></td>
              <td><?php echo $row1['year'] ?></td>
              <td><?php echo $row1['yearsem']?></td>
              <td><?php echo $row1['subject'] ?></td>
              <td><?php echo $row1['internal'] ?></td>
              <td><?php echo $row1['size'] ?></td> 
              <td><?php echo $row1['type']?></td>
              <td><a href="internalpapers/<?php echo $row1['file'] ?>" target="_blank">view file</a></td>
 
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
          $result = mysqli_query($db,"SELECT * FROM tbl_uploads");

          while( $row1 = mysqli_fetch_assoc( $result ) ){
            ?>
            <tr>
              <td><?php echo $row1['id'] ?></td>
              <td><?php echo $row1['date'] ?></td>
              <td><?php echo $row1['file'] ?></td>
              <td><?php echo $row1['year'] ?></td>
              <td><?php echo $row1['yearsem']?></td>
              <td><?php echo $row1['subject'] ?></td>
              <td><?php echo $row1['internal'] ?></td>
              <td><?php echo $row1['size'] ?></td> 
              <td><?php echo $row1['type']?></td>
              <td><a href="internalpapers/<?php echo $row1['file'] ?>" target="_blank">view file</a></td>
 
            </tr>
            <?php
 
          }
  }

  else
  {
          $result = mysqli_query($db,"SELECT * FROM tbl_uploads");
          while( $row1 = mysqli_fetch_assoc( $result ) ){
            ?>
            <tr>
              <td><?php echo $row1['id'] ?></td>
              <td><?php echo $row1['date'] ?></td>
              <td><?php echo $row1['file'] ?></td>
              <td><?php echo $row1['year'] ?></td>
              <td><?php echo $row1['yearsem']?></td>
              <td><?php echo $row1['subject'] ?></td>
              <td><?php echo $row1['internal'] ?></td>
              <td><?php echo $row1['size'] ?></td> 
              <td><?php echo $row1['type']?></td>
              <td><a href="internalpapers/<?php echo $row1['file'] ?>" target="_blank">view file</a></td>
 
            </tr>
            <?php
 
          }
  }
 	 mysqli_close($db); ?>
    </body>
	</main>
    </html>