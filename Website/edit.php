<!DOCTYPE  html>
<?php if(!isset($_SESSION)) session_start(); ?>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Edit <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
			<p>What do you want to do ?</p>
			<!--Là faudrait réfléchir...-->
			
			<a href = "manageUser.php" title = "manageUser">Manage the users</a> </br></br>
			<a href = "addPublication.php" title = "addPublication">Add a publication</a> </br></br>
		
		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--Footer !-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>