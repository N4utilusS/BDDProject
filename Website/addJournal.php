<?php if(!isset($_SESSION)) session_start(); ?>

<!DOCTYPE  html>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Add a journal,  <?php if (isset($_SESSION['email'])) echo $_SESSION['email']; else echo 'Visitor'; ?> !</h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		
		
		
		
		
			<form method = "post" action = <?php echo '"computeAddJournal.php?publication=' . $_GET['publication'] . '"'; ?>>
				<p>

						
					<label for = "Name">  Name :</label>
					<input type = "text" name = "Name" id = "Name"/><br/><br/>
					
					<label for = "Year"> Year :</label>
					<input type = "text" name = "Year" id = "Year"/><br/><br/>

					<input type = "submit" value = "Submit"/>	<br/><br/>
					
					
		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--Footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>