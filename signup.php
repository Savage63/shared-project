<?php
	// Include config file
	require_once "config.php";
 
	//Initialise Variable in Database to 0
	$username = "";
	$password = "";
	$confirm_password = "";
	
	$username_err = "";
	$password_err = "";
	$confirm_password_err = "";
 
	//Processes Data when Submitted
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//Makes sure username is Correct
		if(empty(trim($_POST["username"])))
		{
			$username_err = "Please enter a username.";
		}	 
		elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"])))
		{
			$username_err = "Username can only contain letters, numbers, and underscores.";
		} 
		else
		{
			//Selects object from table in database
			$sql = "SELECT id FROM userinfo WHERE username = ?";
        
			if($stmt = mysqli_prepare($con, $sql))
			{
				//Binds the parameters of the database variables
				mysqli_stmt_bind_param($stmt, "s", $param_username);
            
				//Set the parameters for the username
				$param_username = trim($_POST["username"]);
            
				//Executes the prepared statement
				if(mysqli_stmt_execute($stmt))
				{
					//Stores the Username into the database
					mysqli_stmt_store_result($stmt);
                
					if(mysqli_stmt_num_rows($stmt) == 1)
					{
						$username_err = "This username is already taken";
					} 
					else
					{
						$username = trim($_POST["username"]);
					}
				} 
				else
				{
					echo "Please try again later";
				}

				// Close statement
				mysqli_stmt_close($stmt);
			}
		}
    
		//Makes sure password is Correct
		if(empty(trim($_POST["password"])))
		{
			$password_err = "Please enter a password.";     
		} 
		elseif(strlen(trim($_POST["password"])) < 6)
		{
			$password_err = "Password must have atleast 6 characters";
		} 
		else
		{
			$password = trim($_POST["password"]);
		}
    
		//Makes sure the passwords are the same
		if(empty(trim($_POST["confirm_password"])))
		{
			$confirm_password_err = "Please confirm your password";     
		} 
		else
		{
			$confirm_password = trim($_POST["confirm_password"]);
			if(empty($password_err) && ($password != $confirm_password))
			{
				$confirm_password_err = "The Passwords did not match.";
			}
		}
    
		//Checks for errors before insering into database
		if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
		{
        
			//insert inputs to username and password
			$sql = "INSERT INTO userinfo (username, password) VALUES (?, ?)";
         
			if($stmt = mysqli_prepare($con, $sql))
			{
				//Binds the parameters of the database variables
				mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
				//Set the parameters for the username and password
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); //hashes the password in the database
            
				//Executes the prepared statement
				if(mysqli_stmt_execute($stmt))
				{
					//sends you to the login page
					header("location: login.php");
				} 
				else
				{
					echo "Please try again later.";
				}
				//Close statement
				mysqli_stmt_close($stmt);
			}
		}
		//Close connection
		mysqli_close($con);
	}
?>

<!DOCTYPE html>
<title>Sign Up</title>
<html>
	<style>
		body {font-family: Arial, Helvetica, sans-serif;}
		* {box-sizing: border-box}

		input[type=text], input[type=password] 
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
				<h1>Sign Up</h1>
				<p>Please fill this form to create an account.</p>
				<p>Already have an account? <a href="login.php">Login Here</a>.</p>
		
				<?php 
					if(!empty($login_err))
					{
						echo '<div class="alert alert-danger">' . $login_err . '</div>';
					}        
				?>
		
				<div class="form-group">
					<label for="username"><b>Username</b></label>
					<input type="text" placeholder="Username" name="username" required <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
					<span class="invalid-feedback"><?php echo $username_err; ?></span>
				</div> 
			
				<div class="form-group">
					<label for="password"><b>Password</b></label>
					<input type="password" placeholder="Enter Password" name="password" required <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
					<span class="invalid-feedback"><?php echo $password_err; ?></span>
				</div>
			
				<div class="form-group">
					<label for="password"><b>Confirm Password</b></label>
					<input type="password" placeholder="Confirm Password" name="confirm_password" required <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
					<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
				</div>
			
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Login">
				</div>
			
			</div>
		</form>
	</body>
</html>