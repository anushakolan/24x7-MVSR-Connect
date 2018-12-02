<?php
include('functions.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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
<title>UPLOADING INTERNAL PAPERS</title>
<div class="container">           
  <a href='dashboard.php' class="login" title="homeicon"><img src="images/homeicon1.jpg" width="120" height="100"></a>
</div>
</head>
<link rel="stylesheet" href="style.css" type="text/css">
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
<div id="header2">
<label>INTERNAL PAPERS</label>
</div>
<div id="body">
	<form action="qpupload.php" method="post" enctype="multipart/form-data">
	
		<?php echo display_error(); //this must be present to display errors

  		 ?>  
		<div class="input-group">
			<label>Year of examination</label>
			<input type="text" name="year">
		</div>
		<div class="input-group">
			<label>Year/sem</label>
			<input type="text" name="yearsem">
		</div>
		<div class="input-group">
			<label>Subject</label>
			<input type="text" name="subject1">
		</div>
		<div>
			<label>File</label>
			<input type="file" class="btn" name="file" />
		</div>
		<div class="input-group">
			<label>Internal</label>
			<input type="number" name="internal">
		</div>
	<button type="submit" class="btn" name="btn-upload">upload</button>
	</form>
    <br /><br />
    <?php
	if(isset($_GET['success']))
	{
		?>
        <label>File Uploaded Successfully...  <a href="sortintpapers.php">click here to view file.</a></label>
        <?php
	}
	else if(isset($_GET['fail']))
	{
		?>
        <label>Problem While File Uploading !</label>
        <?php
	}
	else if(isset($_GET['invalidtype']))
	{
		?>
        <label>Upload only pdf,png and jpeg files</label>
        <?php
	}
	else if(isset($_GET['sizeexceeded']))
	{
		?>
        <label>Your file exceeds maximun size upload a file with less size</label>
        <?php
	}
	else
	{
	}
	?>
</div>
</body>
</html>