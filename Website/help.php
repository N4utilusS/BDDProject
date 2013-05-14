<?php if(!isset($_SESSION)) session_start(); ?>

<!DOCTYPE  html>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Help ! <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
			<p>Là on vous aide</p>			
		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>