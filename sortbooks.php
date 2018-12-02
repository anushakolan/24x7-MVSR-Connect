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
      <title>View Books</title>
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
    <label>ALL BOOKS</label>
    </div>
   	    <form method="post" action="sortbooks.php">

      <?php echo display_error(); //this must be present to display errors

       ?>  
<h1>Search by any one format </h1>
    <div class="input-group">
      <label>Textbook Name</label>
      <input type="text" name="textbook">
    </div>
    <div class="input-group">
      <label>Author</label>
      <input type="text" name="author">
    </div>
    <div class="input-group">
      <label>Subject</label>
      <input type="text" name="subject">
    </div>
    <div class="input-group">
      <label>owner</label>
      <input type="text" name="owner">
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
          <th>Book Id</th>
          <th>Posted By</th>
          <th>Date</th>
          <th>Book Name</th>
          <th>Author</th>
          <th>Subject</th>
          <th>Edition number</th>
          <th>Owner</th>
          <th>Phone number</th>
          
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
  $bookid="";
  $author="";
  $owner="";
  $edition="";
  $subject="";
  $rollno="";
  $date="";
  $textbook="";
  $phone="";
    
global $db,$errors,$c,$row1;

    $textbook   =  e($_POST['textbook']);
    $author     =  e($_POST['author']);
    $subject    =  e($_POST['subject']);
    $owner      =  e($_POST['owner']);

    if(!empty($textbook)){$c++;}
    if(!empty($author)){$c++;}
    if(!empty($subject)){$c++;}
    if(!empty($owner)){$c++;}

   

    if($c == 1)
    {
      if(!empty($textbook))
      {
        $query1="SELECT * FROM `books` WHERE textbook='$textbook'";
        $res2=mysqli_query($db, $query1);
        $row1 = mysqli_fetch_assoc($res2);
      }
      else if(!empty($author))
      {
        $query1="SELECT * FROM `books` WHERE author='$author'";
        $res2=mysqli_query($db, $query1);
        $row1 = mysqli_fetch_assoc($res2);
      }
      else if(!empty($subject))
      {
        $query1="SELECT * FROM `books` WHERE subject='$subject'";
        $res2=mysqli_query($db, $query1);
        $row1 = mysqli_fetch_assoc($res2);
      }
      else if(!empty($owner))
      {
        $query1="SELECT * FROM `books` WHERE owner='$owner'";
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
            echo
            "<tr>
              <td>{$row1['bookid']}</td>
              <td>{$row1['rollno']}</td>
              <td>{$row1['date']}</td>
              <td>{$row1['textbook']}</td>
              <td>{$row1['author']}</td>
              <td>{$row1['subject']}</td>
              <td>{$row1['edition']}</td>
              <td>{$row1['owner']}</td> 
              <td>{$row1['phone']}</td> 
            </tr>\n";
          }
          while( $row1 = mysqli_fetch_assoc($res2) );
        ?>
      </tbody>
    </table>
<?php

  }
  else if((isset($_POST['all_btn'])))
  {
          $result = mysqli_query($db,"SELECT * FROM books");
          while( $row = mysqli_fetch_assoc( $result ) ){
            echo
            "<tr>
              <td>{$row['bookid']}</td>
              <td>{$row['rollno']}</td>
              <td>{$row['date']}</td>
              <td>{$row['textbook']}</td>
              <td>{$row['author']}</td>
              <td>{$row['subject']}</td>
              <td>{$row['edition']}</td>
              <td>{$row['owner']}</td> 
              <td>{$row['phone']}</td> 
            </tr>\n";
          }
  }

  else
  {
          $result = mysqli_query($db,"SELECT * FROM books");
          while( $row = mysqli_fetch_assoc( $result ) ){
            echo
            "<tr>
              <td>{$row['bookid']}</td>
              <td>{$row['rollno']}</td>
              <td>{$row['date']}</td>
              <td>{$row['textbook']}</td>
              <td>{$row['author']}</td>
              <td>{$row['subject']}</td>
              <td>{$row['edition']}</td>
              <td>{$row['owner']}</td> 
              <td>{$row['phone']}</td> 
            </tr>\n";
          }
  }
 	 mysqli_close($db); ?>
    </body>
	</main>
    </html>