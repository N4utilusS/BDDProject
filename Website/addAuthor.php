<?php if(!isset($_SESSION)) session_start(); ?>

<!DOCTYPE  html>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Add an author,  <?php if (!empty($_SESSION['email'])) echo $_SESSION['email']; ?> !</h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		
		
		
		
		
			<form method = "post" action = <?php echo '"computeAddAuthor.php?publication=' . $_GET['publication'] . '"'; ?>>
				<p>
					<label for = "DBLP_Key"> DBLP_Key :</label>
					<input type = "text" name = "DBLP_Key" id = "DBLP_Key"/><br/><br/>
						
					<label for = "Name">  Name :</label>
					<input type = "text" name = "Name" id = "Name"/><br/><br/>
					
					<label for = "URL"> URL (optional) :</label>
					<input type = "text" name = "URL" id = "URL"/><br/><br/>
			
					<label for = "Crossref"> Crossref (optional) :</label>
					<input type = "text" name = "Crossref" id = "Crossref"/><br/><br/>
					
					<label for = "Note"> Note (optional) :</label>
					<input type = "text" name = "Note" id = "Note"/><br/><br/>
					
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