<?php if(!isset($_SESSION)) session_start(); ?>

<!DOCTYPE  html>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>About this site. <?php if (isset($_SESSION['email'])) echo $_SESSION['email']; else echo 'Visitor'; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
			<p>Là on explique des trucs</p>
			<iframe width="1280" height="720" src="http://www.youtube.com/embed/z9Uz1icjwrM?rel=0amp;autoplay=1" frameborder="0" allowfullscreen></iframe>
		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--Footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>