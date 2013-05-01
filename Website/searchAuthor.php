<!DOCTYPE  html>

<?php session_start();?>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> //En-tête
			<h1>Let's search for an author <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> //Zone centrale
			<p>Enter the name of your author</p>
			
			<form method = "post" action = "computeSearchAuthor.php">
				<p>
					<label for = "author"> Your author :</label>
					<input type = "text" name = "author" id = "author"/>
					
					<br/>
					
					<input type = "submit" value = "Submit"/>
				</p>
			</form>			
		</section>	
		
		<nav> //Menu
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> //Footer !
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>