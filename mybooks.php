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
    <label>MY BOOKS</label>
    </div>
   	    <form method="post" action="mybooks.php">

      <?php echo display_error(); //this must be present to display errors

       ?>  

    <div class="input-group">
      <label>ENTER BOOK ID OF BOOK TO BE DELETED</label>
      <input type="number" name="deletebookid">
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="delete_btn">Submit</button>
    </div>

  </form>
      <?php
      $db = mysqli_connect('localhost', 'root', '', 'registration');
	  if($db === false)
	  {
      die("ERROR: Could not connect. " . mysqli_connect_error());
	  }
	  $query2="SELECT rollno from users where username = '".$_SESSION['user']['username'] ."'";
		$res1=mysqli_query($db, $query2);
		$row = mysqli_fetch_row($res1);
      //execute the SQL query and return records
      $result = mysqli_query($db,"SELECT * FROM `books` WHERE rollno='$row[0]'");
      ?>
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
      <tbody>
        <?php
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
        ?>
      </tbody>
    </table>
 	<?php mysqli_close($db); ?>
    </body>
	</main>
    </html>