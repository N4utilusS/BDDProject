<!DOCTYPE  html>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Change URL :</h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		
			<form method = "post" action = <?php echo '"computeChangeURL.php?author=' . $_GET['author'] .'"'; ?>>
				<p>
					<label for = "URL"> The new URL :</label>
					<input type = "text" name = "URL" id = "URL"/>
					
					
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