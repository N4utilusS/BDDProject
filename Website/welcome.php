<!DOCTYPE  html>

<?php if(!isset($_SESSION)) session_start(); ?>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> //En-tête
			<h1>Welcome <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> //Zone centrale
			<p>Ca c'est notre site !</p>			
		</section>	
		
		<nav> //Menu
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> //Footer !
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>