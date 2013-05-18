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
		
		
			<form method = "post" action = <?php echo '"computeChangeAuthorName.php?author=' . $_GET['author'] .'&amp;name='.$_GET['name'].'"'; ?>>
				<p>
					<label for = "newName"> The new name (empty name will delete the name) :</label>
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