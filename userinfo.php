<?php
	//Save Inputs phps
	// Initialize the session
	session_start();
 
	//Check if the user is logged in, if not then send to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
		header("location: login.php");
		exit;
	}
 
	//Include config file
	require_once "config.php";
 
	//Initialise Variable in Database to 0
	$name = "";
	$address = "";
	$dobS = "";
	$phone = "";
	
	$name_err ="";
	$address_err = "";
	$dob_err = "";
	$phone_err = "";
	
	$sql = "INSERT INTO userinfo (name, address, dob, phone) VALUES (?, ?, ?, ?)";
	
?>

<?php 
	//Save Image PHPS
	// Include the database configuration file  
	require_once 'Config.php'; 
 
	//If file upload form is submitted 
	$status = $statusMsg = ''; 
	if(isset($_POST["submit"]))
	{ 
		$status = 'error'; 
		if(!empty($_FILES["image"]["name"])) 
		{ 
			//Get file info 
			$fileName = basename($_FILES["image"]["name"]); 
			$fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
			//Allow certain file formats 
			$allowTypes = array('jpg','png','jpeg','gif'); 
			if(in_array($fileType, $allowTypes))
			{ 
				$image = $_FILES['image']['tmp_name']; 
				$imgContent = addslashes(file_get_contents($image)); 
         
				//Insert image content into database 
				$insert = $db->query("INSERT into user (image, created) VALUES ('$imgContent', NOW())"); 
             
				if($insert)
				{ 
					$status = 'success'; 
					$statusMsg = "File uploaded successfully."; 
				}
				else
				{ 
					$statusMsg = "File upload failed, please try again."; 
				}  
			}
			else
			{ 
				$statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
			} 
		}
	} 
?>


<!DOCTYPE html>
<title>User Details</title>
<html>
	<style>
		body {font-family: Arial, Helvetica, sans-serif;}
		* {box-sizing: border-box}

		input[type=text], input[type=date], input[type=int], input[type=file]
		{
			width: 100%;
			padding: 15px;
			margin: 5px 0 22px 0;
			display: inline-block;
			border: none;
			background: #f1f1f1;
		}

		input[type=submit]
		{
			float: left;
			width: 10%;
			padding: 14px 20px;
		}

		.home
		{
			padding: 16px;
		}
	</style>
	<body>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="border:1px solid #ccc" >
			<div class="home">
				<h1>Welcome!</h1>
				<p>Please Fill in your Contact Details and upload a picture of your Positive Antigen Test</p>
				<a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
				<hr>
			
		
				<div class="form-group">
					<label for="name"><b>Full Name</b></label>
					<input type="text" placeholder="Full Name" name="name" required 
				</div>
			
				<div class="form-group">
					<label for="address"><b>Address</b></label>
					<input type="text" placeholder="Your Address" name="address" required 
				</div>
			
				<div class="form-group">
					<label for="dob"><b>Date of Birth</b></label>
					<input type="date" name="dob" required
				</div> 
			
				<div class="form-group">
					<label for="phone"><b>Phone Number</b></label>
					<input type="int" placeholder="0851231234" name="phone" required minlength=10 maxlength=10>
				</div>
			
				<form action="closecontacts.php" method="post" enctype="multipart/form-data">
					<label><b>Select Image File</b></label>
					<input type="file" name="image">
					<input type="submit" name="submit" value="Continue">
				</form>
			</div>
		</form>
	</body>
</html>