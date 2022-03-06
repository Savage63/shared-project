<?php
	// Initialize the session
	session_start();
	
	// Include the database configuration file  
	require_once 'Config.php'; 
?>


<!DOCTYPE html>
<html>
	<style>
		body {font-family: Arial, Helvetica, sans-serif;}
		* {box-sizing: border-box}

		input[type=text], input[type=phonenumber]
		{
			width: 100%;
			padding: 15px;
			margin: 5px 0 22px 0;
			display: inline-block;
			border: none;
			background: #f1f1f1;
		}

		button 
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
		<form action="/Home.php" style="border:1px solid #ccc">
			<div class="home">
				<h1>Your Close Contact</h1>
				<p>Please Fill in the Contact Information of your Close Contact</p>
				<hr>

				<div class="form-group">
					<label for="name"><b>Full Name</b></label>
					<input type="text" placeholder="Full Name" name="name" required>
				</div> 
			
				<div class="form-group">
					<label for="PhoneNumber"><b>Phone Number</b></label>
					<input type="phonenumber" placeholder = "0871234123" name="PhoneNumber" required minlength=10 maxlength=10 />
				</div>
	
				<div class="clearfix">
					<button type="submit" class="submit">Submit</button>
				</div>
			</div>
		</form>
	</body>
</html>