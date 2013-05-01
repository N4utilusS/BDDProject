<!DOCTYPE  html>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
		<header>
			<h1>Connection...</h1>
			<a href = "register.php" title = "Register !">Register</a>
		</header>
		
		<section>
			<p>Please enter your Email address and Password:</p>
			
			<form method = "post" action = "identityTest.php">
				<p>
					<label for = "email"> Your Email :</label>
					<input type = "text" name = "email" id = "email"/>
					
					<br/>
					
					<label for = "pass"> Your Password :</label>
					<input type = "password" name = "password" id = "pass"/>
					
					<input type = "submit" value = "Submit"/>
				</p>
			</form>
		</section>	
	</body>

</html>