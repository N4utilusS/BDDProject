<?php if(!isset($_SESSION)) session_start(); ?>
<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>R1 <?php if (isset($_SESSION['email'])) echo $_SESSION['email']; else echo 'Visitor'; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
			Les auteurs Y qui sont à une distance 2 d’un auteur X.
			Un auteur Y est à une distance 1 d’un auteur X si ces deux auteurs ont co-écrit un article.
			
			<form method = "post" action = "R3.php">
				<p>
					<label for = "author"> The Author X :</label>
					<input type = "text" name = "author" id = "author"/>
					
					<br/>
					
					<input type = "submit" value = "Submit"/>
				</p>
			</form>
			
		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>