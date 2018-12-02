<?php
include ('functions.php');


$db = mysqli_connect('localhost', 'root', '', 'quora');
	  if($db === false)
	  {
      die("ERROR: Could not connect. " . mysqli_connect_error());
	  }

	  $result = mysqli_query($db,"SELECT * FROM addtopic");
	  $row = mysqli_fetch_assoc( $result );

$to = "aaskanu.reddy@gmail.com";
$subject = $row[4];
$txt = $row[5];
$headers = "From: balaji.7tirumala@gmail.com" . "\r\n" .
"CC:$row[3]";

mail($to,$subject,$txt,$headers);
echo "Your request will be forwarded!Thank you..";
?>
<!DOCTYPE html>
<html>
<head>
	<a href="viewtopics.php">Go back</a>
</head>
</html>