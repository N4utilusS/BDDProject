<!DOCTYPE  html>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Change DBLP www Key :</h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		
			<form method = "post" action = <?php echo '"computeChangeDBLPwwwKey.php?author=' . $_GET['author'] .'"'; ?>>
				<p>
					<label for = "DBLP"> The new DBLP www Key :</label>
					<input type = "text" name = "DBLP" id = "DBLP"/>
					
					
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