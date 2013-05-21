
<?php session_start(); ?>

<!DOCTYPE  html>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Welcome <?php if (isset($_SESSION['email'])) echo $_SESSION['email']; else echo 'Visitor'; ?> !</h1>
		</header>
		
		<section> <!--Zone centrale-->
			<p>Ca c'est notre site !</p>
			<?php echo '<pre>';
			print_r($_SESSION);
			echo '</pre>'; ?>
		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--Footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>