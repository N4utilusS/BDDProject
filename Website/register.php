<!DOCTYPE  html>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
		<header>
			<h1>Register</h1>
		</header>
		
		<section>
			<p>Please enter your Email address and Password:</p>
			
			<form method = "post" action = "addUser.php">
				<p>
					<label for = "email"> Your Email :</label>
					<input type = "text" name = "email" id = "email"/>
					
					<br/>
					
					<label for = "pass"> Your Password :</label>
					<input type = "password" name = "password" id = "pass"/>
					
					<label for = "pass2"> Your Password Again :</label>
					<input type = "password" name = "password1" id = "pass2"/>
					
					<input type = "submit" value = "Submit"/>
				</p>
			</form>
		</section>	
	</body>

</html>