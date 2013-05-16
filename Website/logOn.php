<!DOCTYPE  html>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Log In :</h1>
		</header>
		
		<section> <!--Zone centrale-->
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
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--Footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>