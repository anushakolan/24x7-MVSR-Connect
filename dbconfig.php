<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "dbtuts";
$db = mysqli_connect('localhost', 'root', '', 'dbtuts');
	if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>