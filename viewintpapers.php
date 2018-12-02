<?php
include 'functions.php';
?>
<!DOCTYPE html>
<meta http-equiv="pragma" content="no-cache" />
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
<title>QUESTION PAPERS</title>
</head>
<link rel="stylesheet" type="text/css"  href="style2.css">
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
<div id="header">
<label>INTERNAL QUESTION PAPERS</label>
</div>
<div class="container">           
  <a href="dashboard.php" class="login" title="homeicon"><img src="images/homeicon1.jpg" width="120" height="100"></a>
</div>
<div id="body">
    <table width="100%" border="1">
    <tr>
    <th colspan="7"><label><a href="qpupload.php">Upload new question papers...</a></label></th>
    </tr>
    <tr>
    <td>Year</td>
    <td>Subject</td>
    <td>Internal</td>
    <td>File Name</td>
    <td>File Type</td>
    <td>File Size(KB)</td>
    <td>View</td>
    </tr>
    <?php
    $sql="SELECT * FROM tbl_uploads";
    $result_set=mysqli_query($db,$sql);
    while($row=mysqli_fetch_array($result_set))
    {
        ?>
        <tr>
        <td><?php echo $row['year'] ?></td>
        <td><?php echo $row['subject'] ?></td>
        <td><?php echo $row['internal'] ?></td>
        <td><?php echo $row['file'] ?></td>
        <td><?php echo $row['type'] ?></td>
        <td><?php echo $row['size'] ?></td>
        <td><a href="internalpapers/<?php echo $row['file'] ?>" target="_blank">view file</a></td>
        </tr>
        <?php
    }
    ?>
    </table>
    
</div>
</body>
</html>