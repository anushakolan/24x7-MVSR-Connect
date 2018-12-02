<!DOCTYPE html>
<html>
<body>
  <?php
  //$timeout="60*60";
  include('functions.php');
   //session_start();
   if(!isset($_SESSION['username']))
    {
       header("location:login.php");
     }
      elseif (time() - $_SESSION['timeout'] > 60) 
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
<div class="profile_info">
      <img src="images/user_profile.png" class=img1  width='50' height='50'>
</div>
<!DOCTYPE html>
<html>
<head>
<style>
ul {
    list-style-image: url('sqpurple.gif');
    color: red;
}
#section {
      width: 100%;//length of the ash box
      height: 100%;
      margin: 5px auto 0 auto;
      padding: 5%;//centre position: 
      border-radius: 5px;
      border: 6px solid #e0e0e0;
  }
  #section li {
      display: inline;
    margin: 0px;
  }
h3 {
  font-family: 'Open Sans', sans-serif;
  font-weight: 300;
  color: grey;
  display: block;
}
 img
    {
    position: absolute;
    left: 750px;
    top: 120px;
    z-index: 0;
    }
    .img1
    {
    position: absolute;
    left: 1020px;
    top: 2px;
    z-index: 1;
    }
  </style>
</head>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">24x7 CONNECT</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="homepage.html">Home</a></li>
      <li><a href="#">VIEW</a></li>
      <li><a href="dashboard.php">DASHBOARD</a></li>
    </ul>
    
   <ul class="nav navbar-nav navbar-right">
          <li><a href="mybooks.php">My books</a></li>
          <li><a href="#">Hello, <?php echo $_SESSION["username"]; ?></a></li>
          <li><a href="logout.php" title = Logout>Logout</li>
    </ul>
  </div>
</nav>

<div id="section">
<ul >
      <li><a href="seeanswer.php" ><h3>View answers by postid...</h3></a></li>
      <li><a href="sortbooks.php" font size="5" face="arial" color="red"><h3>Search for a Textbook...</h3></a></li>
</ul>
<ul >
      <li><a href="sortstudymaterials.php" font size="5" face="arial" color="red"><h3>View study materials...</h3></a></li>
      <li><a href="sortintpapers.php" font size="5" face="arial" color="red"><h3>View internal question papers...</h3></a></li>
</ul>
<ul >
      <li><a href="viewannouncements.php" font size="5" face="arial" color="red"><h3>Announcements...</h3></a></li>
</ul>
</div>
<div class="container">           
  <img src="images/networking.png" class="bg-centre" width="490" height="300"> 
</div>
</body>
</html>



