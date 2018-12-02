<?php
include('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<html>
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
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
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
	<div class="header">
		<h2>Book post </h2>
	</div>
	<div class="container">           
  <a href="homepage.html" class="login" title="homeicon"><img src="images/homeicon1.jpg" width="120" height="100"></a>
</div>




  	<form method="post" action="Bookpost.php">

  		<?php echo display_error(); //this must be present to display errors

  		 ?>  

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
			<label>Edition Number</label>
			<input type="text" name="edition">
		</div>
		<div class="input-group">
			<label>Owner Name</label>
			<input type="text" name="owner">
		</div>
		<div class="input-group">
			<label>Phone Number</label>
			<input type="number" name="phone">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="book_btn">Submit</button>
		</div>
	</form>
</body>
</html>