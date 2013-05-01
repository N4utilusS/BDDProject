<!DOCTYPE  html>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> //En-tête
			<h1>About this site. <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> //Zone centrale
			<p>Là on explique des trucs</p>			
		</section>	
		
		<nav> //Menu
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> //Footer !
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>