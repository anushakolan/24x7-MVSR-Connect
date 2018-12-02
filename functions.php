<?php 
	session_start();

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'registration');
	if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$db1 = mysqli_connect('localhost', 'root', '', 'quora');
	  if($db1 === false)
	  {
      die("ERROR: Could not connect. " . mysqli_connect_error());
	  }
	//$db1 = mysqli_connect('localhost', 'root', '', 'booksposted');
	// variable declaration
	$rollno	  = "";
	$username = "";
	$email    = "";
	$loggedIn = "";
	$textbook = "";
	$author   = "";
	$subject  = "";
	$edition  = "";
	$owner    = "";
	$phone    = "";
	$user_type= "";
	$subject1 = "";
  	$year     = "";
  	$internal = "";
  	$deletebookid="";
  	$topic_title="";
  	$topicid1="";
	$errors   = array(); 

	// call the register() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}
	if (isset($_POST['register_btn'])) {
		register();
	}
	if (isset($_POST['addtopic_btn'])) {
		addtopic();
	}
	if (isset($_POST['answer_btn'])) {
		answer();
	}
	if (isset($_POST['btn_study'])) {
		poststudymaterials();
	}
	if (isset($_POST['enteranswer_btn'])) {
		enteranswer();
	}
	if (isset($_POST['requesttopic_btn'])) {
		requesttopic();
	}
	if (isset($_POST['askquestion_btn'])) {
		askquestion();
	}
	if (isset($_POST['addpost1_btn'])) {
		addposts1();
	}
	
	
	// call the login() function if register_btn is clicked
	if (isset($_POST['delete_btn'])) {
		deletebook();
	}

	if (isset($_POST['btn-upload'])) {
		intqpupload();
	}
	if (isset($_POST['btn_announce'])) {
		announce();
	}

	if (isset($_POST['book_btn'])) {
		bookpost();
	}


	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: ../login.php");
	}

	// REGISTER USER
	function register(){
		global $db, $errors;

		// receive all input values from the form
		$rollno		 =  e($_POST['rollno']);
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);


		// form validation: ensure that the form is correctly filled
		if (empty($rollno)) { 
			array_push($errors, "rollno is required"); 
		}
		if(strlen($rollno)!=12){
			array_push($errors, "Invalid rollno"); 
		}
		$query = "SELECT * FROM users WHERE rollno='$rollno'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) != 0)
         { 
          array_push($errors, "rollno already in use!");
         }
		if (empty($username)) { 
			array_push($errors, "Username is required"); 
		}
		 $query1 = "SELECT * FROM users WHERE username='$username'";
        $results1 = mysqli_query($db, $query1);
        if (mysqli_num_rows($results1) != 0) { array_push($errors, "username already in use!"); }
		if (empty($email)) { 
			array_push($errors, "Email is required"); 
		}
		if (empty($password_1)) { 
			array_push($errors, "Password is required"); 
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}


		// register user if there are no errors in the form
		if (count($errors) == 0) {

			$password = md5($password_1);//encrypt the password before saving in the database

			if (isset($_POST['user_type'])) {
				echo"admin";
				$user_type = e($_POST['user_type']);
				$query = "INSERT INTO users (rollno,username,email,user_type,password) 
						  VALUES('$rollno','$username','$email','$user_type','$password')";
						  echo $query;
				$res=mysqli_query($db, $query);
				echo $res;
				if(!$res)
				{

    			die("DAMMIT");
				}
				else
				{ 
					echo "Success";
				}
				$_SESSION['success']  = "New user successfully created!!";
				header('location: ../dashboard.php');
			}else{
				echo "user";
				$query = "INSERT INTO users (rollno,username,email,user_type,password) 
						  VALUES($rollno,'$username','$email','user','$password')";
				$res=mysqli_query($db, $query);
				echo $res;
				if(!$res)
				{

    			die("DAMMIT");
				}
				else
				{ 
					echo "Success";
				}

				$_SESSION['success']  = "New user successfully created!!";
				header('location: homepage.html');

				// get id of the created user
				//$logged_in_user_id = mysqli_insert_id($db);

				//$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "You are now logged in";
				$_SESSION['username'] = $username;
				$_SESSION['loggedIn'] = true;
		        $_SESSION['timeout'] = time();		          
				header('location: dashboard.php');	

			}
			

		}

	}
	// return user array from their id
	function getUserById($id){
		global $db;
		$query = "SELECT * FROM users WHERE id=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}

	// LOGIN USER
	function login(){
		global $db, $username, $errors;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['user_type'] == 'admin') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					$_SESSION['timeout'] = time();
					header('location: admin/home.php');		  
				}else{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					$_SESSION['username'] = $logged_in_user['username'];
					$_SESSION['loggedIn'] = true;
					$_SESSION['timeout'] = time();
				header('location: dashboard.php');	
				}
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
			return true;
		}else{
			return false;
		}
	}

	// escape string
	function e($val){
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}

	function bookpost()
	{
		global $db, $errors,$username;

		// receive all input values from the form
		$textbook   =  e($_POST['textbook']);
		$author     =  e($_POST['author']);
		$subject    =  e($_POST['subject']);
		$edition    =  e($_POST['edition']);
		$owner      =  e($_POST['owner']);
		$phone      =  e($_POST['phone']);

	
		// form validation: ensure that the form is correctly filled
		if (empty($textbook)) { 
			array_push($errors, "Textbook name is required"); 
		}
		if (empty($author)) { 
			array_push($errors, "author is required"); 
		}
		if (empty($subject)) { 
			array_push($errors, "subject is required"); 
		}
		if (empty($edition)) { 
			array_push($errors, "edition is required"); 
		}
		if (empty($owner)) { 
			array_push($errors, "owner name is required"); 
		}
		$query = "SELECT * FROM users WHERE username='$owner'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 0) { 
        	array_push($errors, "Owner not registered please register and post the book"); 
        }

		if (empty($phone)) { 
			array_push($errors, "phone is required"); 
		}
		if(strlen($phone)!=10){
			array_push($errors, "Invalid rollno"); 
		}
		$query2="SELECT rollno from users where username = '".$_SESSION['user']['username'] ."'";
		$res1=mysqli_query($db, $query2);
			$row = mysqli_fetch_row($res1);	
		// register user if there are no errors in the form
		if (count($errors) == 0)
		{
					

				$query = "INSERT INTO books (rollno,textbook, author, subject, edition,owner,phone) 
						  VALUES($row[0],'$textbook', '$author', '$subject','$edition','$owner','$phone')";
				echo $query2;
				$res=mysqli_query($db, $query);
				
				if(!$res)
				{

    			die("DAMMIT");
				}
				else
				{ 
					echo "Success";
				}
				$_SESSION['success']  = "New book successfully created!!";
				header('location: sortbooks.php');
		}

	}

	function intqpupload()
	{	

			global $db,$errors,$k;	
			

			$yearsem	   =  e($_POST['yearsem']);
  			$subject1      =  e($_POST['subject1']);
  			$year   	   =  e($_POST['year']);
  			$internal      =  e($_POST['internal']);
  			

  			if (empty($subject1)) 
  			{ 
			array_push($errors, "subject name is required"); 
			}
			if (empty($year)) 
			{ 
			array_push($errors, "year is required"); 
			}
			if (empty($yearsem)) 
			{ 
			array_push($errors, "year/sem is required"); 
			}
			if (empty($internal))
			{ 
			array_push($errors, "internal is required"); 
			}

		$query = "SELECT * FROM tbl_uploads WHERE subject='$subject1'";
        $results1 = mysqli_query($db, $query);

       // echo $query;

        $query = "SELECT * FROM tbl_uploads WHERE year='$year'";
        $results2 = mysqli_query($db, $query);

        //echo $query;

        $query = "SELECT * FROM tbl_uploads WHERE yearsem='$yearsem'";
        $results3 = mysqli_query($db, $query);

       // echo $query;

        $query = "SELECT * FROM tbl_uploads WHERE internal='$internal'";
        $results4 = mysqli_query($db, $query);

        //echo $query;


        if (!empty(mysqli_num_rows($results1)))
        {
        	$k++;
        }
       

        	if(!empty(mysqli_num_rows($results2))){$k++;} 
        		if(!empty(mysqli_num_rows($results3))){$k++;}  
        			if(!empty(mysqli_num_rows($results4))){$k++;}  
         
       

        if($k == 4)
         { 
          array_push($errors, "Question paper already uploaded");
         }

         
  			
		if (count($errors) == 0)
		{

  				$file = $_FILES['file'];
  				$fileName = $file['name'];
 				$fileTmpName = $file['tmp_name'];
 				$fileSize = $file['size'];
  				$fileError = $file['error'];
  				$fileType = $file['type'];
 				$new_size = $fileSize/1024; 

  					$fileExt = explode('.', $fileName);
  					$fileActualExt = strtolower(end($fileExt));

 					 $allowed = array('jpg', 'jpeg', 'png', 'pdf');

  					if (in_array($fileActualExt, $allowed))
  					{
   					 if ($fileError === 0)
    				  {
      					if ($new_size < 1000000)
      					{
        				$fileNameNew = uniqid('', true).".".$fileActualExt;
        				$fileDestination = 'internalpapers/'.$fileNameNew;
            			if(move_uploaded_file($fileTmpName, $fileDestination))
           				 {
           				 $sql="INSERT INTO tbl_uploads(file,year,yearsem,subject,internal,type,size) VALUES('$fileNameNew','$year','$yearsem','$subject1','$internal','$fileType','$new_size')";

           				 
            			mysqli_query($db,$sql);
             			?>
           				 <script>
            			alert('successfully uploaded');
            			window.location.href='qpupload.php?success';
            			</script>
            			<?php
            			}
           				else
           				{
            			?>
            			<script>
            			alert('error while uploading file');
            			window.location.href='qpupload.php?fail';
            			</script>
            			<?php
            			}
          
        //header("Location: index.php?uploadsuccess");
     					 }
      					else 
      					{
          				?>
          				<script>
          				alert('Your file is too big!');
           				window.location.href='qpupload.php?sizeexceeded';
           				</script>
           				<?php
          				//echo "Your file is too big!";
       					}
    				   } 
     				   else
   					   {
                       ?>
            			<script>
            			alert('error while uploading file');
            			window.location.href='qpupload.php?fail';
            			</script>
            			<?php
      					//echo "There was an error uploading your file!";
    					}
  					}
  					else
  					{
    				?>
    				<script>
    				alert('You cannot upload files of this type!');
    				window.location.href='qpupload.php?invalidtype';
    				</script>
    				<?php
   // echo "You cannot upload files of this type!";
  					}
		}
		
	}
	function poststudymaterials()
	{	

			global $db,$errors,$k;	
			

			$yearsem7	   =  e($_POST['yearsem']);
  			$subject7      =  e($_POST['subject']);
  			$unit7   	   =  e($_POST['unit']);
  			$source7     	=  e($_POST['source']);
  			

  			if (empty($subject7)) 
  			{ 
			array_push($errors, "subject name is required"); 
			}
			if (empty($yearsem7)) 
			{ 
			array_push($errors, "year/sem is required"); 
			}
			if (empty($unit7))
			{ 
			array_push($errors, "unit is required"); 
			}
			if (empty($source7))
			{ 
			array_push($errors, "source is required"); 
			}	
		if (count($errors) == 0)
		{

  				$file = $_FILES['file'];
  				$fileName = $file['name'];
 				$fileTmpName = $file['tmp_name'];
 				$fileSize = $file['size'];
  				$fileError = $file['error'];
  				$fileType = $file['type'];
 				$new_size = $fileSize/1024; 

  					$fileExt = explode('.', $fileName);
  					$fileActualExt = strtolower(end($fileExt));

 					 $allowed = array('jpg', 'jpeg', 'png', 'pdf','docx','ppt','rtf','doc');
 					 echo $fileSize;
  					if (in_array($fileActualExt, $allowed))
  					{
   					 if ($fileError === 0)
    				  {
    				  	
      					if ($new_size < 1000000)
      					{
        				$fileNameNew = uniqid('', true).".".$fileActualExt;
        				$fileDestination = 'studymaterials/'.$fileNameNew;
            			if(move_uploaded_file($fileTmpName, $fileDestination))
           				 {
           				 	$query2="SELECT rollno from users where username = '".$_SESSION['user']['username'] ."'";
							$res1=mysqli_query($db, $query2);
							$row = mysqli_fetch_row($res1);	

           				 $sql="INSERT INTO studymaterials(postedby,yearsem,subject,unit,file,type,size,source) VALUES('$row[0]','$yearsem7','$subject7','$unit7','$fileNameNew','$fileType','$new_size','$source7')";

           				 
            			mysqli_query($db,$sql);
             			?>
           				 <script>
            			alert('successfully uploaded');
            			window.location.href='uploadmaterials.php?success';
            			</script>
            			<?php
            			}
           				else
           				{
            			?>
            			<script>
            			alert('error while uploading file');
            			window.location.href='uploadmaterials.php?fail';
            			</script>
            			<?php
            			}
          
        //header("Location: index.php?uploadsuccess");
     					 }
      					else 
      					{
          				?>
          				<script>
          				alert('Your file is too big!');
           				window.location.href='uploadmaterials.php?sizeexceeded';
           				</script>
           				<?php
          				//echo "Your file is too big!";
       					}
    				   } 
     				   else
   					   {
                       ?>
            			<script>
            			alert('error while uploading file');
            			window.location.href='uploadmaterials.php?fail';
            			</script>
            			<?php
      					//echo "There was an error uploading your file!";
    					}
  					}
  					else
  					{
    				?>
    				<script>
    				alert('You cannot upload files of this type!');
    				window.location.href='uploadmaterials.php?invalidtype';
    				</script>
    				<?php
   // echo "You cannot upload files of this type!";
  					}
		}
		
	}
	function deletebook(){
		global $db,$errors;
		$deletebookid  =  e($_POST['deletebookid']);
		$query="SELECT rollno from users where username = '".$_SESSION['user']['username'] ."'";
		$res1=mysqli_query($db, $query);
		$row = mysqli_fetch_row($res1);
		$presentuser=$row[0];

		$query1="SELECT `rollno` FROM `books` WHERE bookid='$deletebookid'";
		$res2=mysqli_query($db, $query1);
		$row1 = mysqli_fetch_row($res2);
		$actualowner=$row1[0];

		if($presentuser == $actualowner)
		{
		if (empty($deletebookid)) 
  		{ 
		array_push($errors, "Book id name is required for deletion"); 
		}
		$query = "DELETE FROM `books` WHERE bookid='$deletebookid'";
		$result = mysqli_query($db, $query);
		if(!$result)
				{

    			die("DAMMIT");
				}
				else
				{ 
					echo "Success";
				}
				$_SESSION['success']  = "Book successfully deleted!!";
		//header('location: mybooks.php');
		}
		else
		{
			echo "you cannot delete this book";
		}
	}
 function addtopic(){
 	global $db,$db1,$errors;
 	
 		$topic_title=e($_POST['topic_title']);
 		$post_text=e($_POST['post_text']);
 		if (empty($topic_title)) 
			{ 
			array_push($errors, "Topic is required"); 
			}
			if (empty($post_text))
			{ 
			array_push($errors, "Details are required"); 
			}

		$query="SELECT username from users where username = '".$_SESSION['user']['username'] ."'";
		$res1=mysqli_query($db, $query);
		$row = mysqli_fetch_row($res1);
		$presentuser=$row[0];

		$query="SELECT email from users where username = '".$_SESSION['user']['username'] ."'";
		$res2=mysqli_query($db, $query);
		$row1 = mysqli_fetch_row($res2);
		$presentuseremail=$row1[0];

		$add_topic ="INSERT into addtopic(username,emailid,title,topic) values ('$row[0]','$row1[0]','$topic_title','$post_text')";

  		$result=mysqli_query($db1,$add_topic);
  		if(!$result)
				{
    			die("DAMMIT");
				}
				else
				{ 
					echo "Success";
				}
				//header('location: topicrequestmail.php');
 }
 function answer()
 {
 	global $db,$db1,$errors,$topicid1;
 		
 		$postid1=e($_POST['postid1']);
 		$post_text1=e($_POST['post_text1']);
			if (empty($post_text1))
			{ 
			array_push($errors, "Answer is required"); 
			}
			if (empty($postid1))
			{ 
			array_push($errors, "Post id is required"); 
			}
			$q="SELECT * from posts where postid = '$postid1'";
			$res1=mysqli_query($db1, $q);
			 if (!empty(mysqli_num_rows($res1)))
        	{
        	
		$query="SELECT username from users where username = '".$_SESSION['user']['username'] ."'";
		$res1=mysqli_query($db, $query);
		$row = mysqli_fetch_row($res1);
		$presentuser=$row[0];

		$add_answer ="INSERT into answer(postid,answer,username) values ('$postid1','$post_text1','$row[0]')";

  		$result=mysqli_query($db1,$add_answer);
  		if(!$result)
				{
    			die("DAMMIT");
				}
				else
				{ 
					echo "Success";
					header('location: viewposts.php');
				}
				echo "success";
			}
			else
			{
				echo "invalid id";
				header('location: answer.php');
			}


 }
 function addposts1()
 {
 	header('location: addpost.php');
 }
 
 function enteranswer()
 {
 	header('location: answer.php');
 }
  function requesttopic()
 {
 	header('location: addtopic.php');
 }
 function askquestion(){
 	global $db,$db1,$errors,$topicid1;
 		
 		$topicid1=e($_POST['topicid1']);
 		$post_text=e($_POST['post_text']);
			if (empty($post_text))
			{ 
			array_push($errors, "Question is required"); 
			}
			if (empty($topicid1))
			{ 
			array_push($errors, "Topic id is required"); 
			}
			$q="SELECT * from topics where topicid = '$topicid1'";
			$res1=mysqli_query($db1, $q);
			 if (!empty(mysqli_num_rows($res1)))
        	{
        	
		$query="SELECT rollno from users where username = '".$_SESSION['user']['username'] ."'";
		$res1=mysqli_query($db, $query);
		$row = mysqli_fetch_row($res1);
		$presentuser=$row[0];



		//s$username = .$_SESSION['user']['username'];
							
		echo $row[0];
		$add_topic ="INSERT into posts(topicid,username,question) values ('$topicid1','$rollno','$post_text')";

  		$result=mysqli_query($db1,$add_topic);
  		if(!$result)
				{
    			die("DAMMIT");
				}
				else
				{ 
					echo "Success";
					header('location: viewposts.php');
				}
				
			}
			else
			{
				echo "invalid id";
			}


 }
 function announce()
	{	

			global $db,$errors,$k;	
			

			$details	   =  e($_POST['details']);
  			

  			if (empty($details)) 
  			{ 
			array_push($errors, "Details are required"); 
			}

		         
		if (count($errors) == 0)
		{

  				$file = $_FILES['file'];
  				$fileName = $file['name'];
 				$fileTmpName = $file['tmp_name'];
 				$fileSize = $file['size'];
  				$fileError = $file['error'];
  				$fileType = $file['type'];
 				$new_size = $fileSize/1024; 

  					$fileExt = explode('.', $fileName);
  					$fileActualExt = strtolower(end($fileExt));

 					 $allowed = array('jpg', 'jpeg', 'png', 'pdf');

  					if (in_array($fileActualExt, $allowed))
  					{
   					 if ($fileError === 0)
    				  {
      					if ($new_size < 1000000)
      					{
        				$fileNameNew = uniqid('', true).".".$fileActualExt;
        				$fileDestination = '../announcements/'.$fileNameNew;
        				$query="SELECT username from users where username = '".$_SESSION['user']['username'] ."'";
						$res1=mysqli_query($db, $query);
						$row = mysqli_fetch_row($res1);
						$presentuser=$row[0];
            			if(move_uploaded_file($fileTmpName, $fileDestination))
           				 {
           				 $sql="INSERT INTO announcements(postedby,file,details,type,size) VALUES('$row[0]','$fileNameNew','$details','$fileType','$new_size')";
           				
            			mysqli_query($db,$sql);
             			?>
           				 <script>
            			alert('successfully posted');
            			window.location.href='postannouncements.php?success';
            			</script>
            			<?php
            			}
           				else
           				{
            			?>
            			<script>
            			alert('error while uploading file');
            			window.location.href='postannouncements.php?fail';
            			</script>
            			<?php
            			}
          
        //header("Location: index.php?uploadsuccess");
     					 }
      					else 
      					{
          				?>
          				<script>
          				alert('Your file is too big!');
           				window.location.href='postannouncements.php?sizeexceeded';
           				</script>
           				<?php
          				//echo "Your file is too big!";
       					}
    				   } 
     				   else
   					   {
                       ?>
            			<script>
            			alert('error while uploading file');
            			window.location.href='postannouncements.php?fail';
            			</script>
            			<?php
      					//echo "There was an error uploading your file!";
    					}
  					}
  					else
  					{
    				?>
    				<script>
    				alert('You cannot upload files of this type!');
    				window.location.href='postannouncements.php?invalidtype';
    				</script>
    				<?php
   // echo "You cannot upload files of this type!";
  					}
		}
		
	}
 

?>