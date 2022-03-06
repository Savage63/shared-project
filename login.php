<?php
	// Initialize the session
	session_start();
 
	//Check if the user is logged in, if yes then send to userinfo page
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
	{
    	header("location: userinfo.php");
   	 	exit;
	}
 
	// Include config file
	require_once "config.php";
 
	//Initialise Variable in Database to 0
	$username = "";
	$password = "";
	
	$username_err = "";
	$password_err = "";
 
	//Processes Data when Submitted
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
 
    	// Check if username is emptyS
    	if(empty(trim($_POST["username"])))
		{
        		$username_err = "Please enter username.";
    	} 
		else
		{
        		$username = trim($_POST["username"]);
    	}
    
   	 	// Check if password is empty
    	if(empty(trim($_POST["password"])))
		{
        	$password_err = "Please enter your password.";
    	} 
		else
		{
        		$password = trim($_POST["password"]);
    	}
    
    	//Make sure Username and Password is Correct
	   	if(empty($username_err) && empty($password_err))
		{
        	//Selects object from table in database
      	  	$sql = "SELECT id, username, password FROM userinfo WHERE username = ?";
        
	        if($stmt = mysqli_prepare($con, $sql))
			{
      	      	//Binds the variables to the parameters
 	      	    mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            	//Set the parameters for the username
            	$param_username = $username;
      	      
	            //Executes the prepared statement
            	if(mysqli_stmt_execute($stmt))
				{
      	          	//Stores the Username into the database
	                mysqli_stmt_store_result($stmt);
                
                	//Checks if username exists, if yes then verify password
                	if(mysqli_stmt_num_rows($stmt) == 1)
					{                    
      	              	//Bind result variables
 	                   	mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    	if(mysqli_stmt_fetch($stmt))
						{
                  	      	if(password_verify($password, $hashed_password))
							{
      	                      	//Password is correct, so start a new session
   	                         	session_start();
                            
                            	//Store data in session variables
                            	$_SESSION["loggedin"] = true;
                        	    $_SESSION["id"] = $id;
                  	          	$_SESSION["username"] = $username;                            
            	                
      	                      	//Redirect user to userinfo page
   	                         	header("location: userinfo.php");
                        	} 
							else
							{
                            	//Password is not valid, display a generic error message
                            	$login_err = "Invalid username or password.";
                        	}
                    	}
                	} 
					else
					{
                    	//Username doesn't exist, display a generic error message
                    	$login_err = "Invalid username or password.";
                	}
            	} 
				else
				{
                	echo "Oops! Something went wrong. Please try again later.";
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
<title>Login</title>
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
				<h1>Login</h1>
				<p>Please enter your credentials to Sign into your Account.</p>
				<p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
				<hr>
			
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
					<input type="submit" class="btn btn-primary" value="Login">
				</div>
			</div>
		</form>
	</body>
</html>