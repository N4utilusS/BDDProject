<!DOCTYPE  html>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Change / delete a name :</h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		
			<form method = "post" action = <?php echo '"computeChangePublisherName.php?publisher=' . $_GET['publisher'].'"'; ?>>
				<p>
					<label for = "newName"> The new name (empty name will delete the publisher) :</label>
					<input type = "text" name = "newName" id = "newName"/>
					
					
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