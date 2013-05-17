
<?php if(!isset($_SESSION)) session_start(); ?>

<!DOCTYPE  html>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Welcome <?php if (!empty($_SESSION['email'])) echo $_SESSION['email']; ?> !</h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		
			<form method = "post" action = "computeAddPublication.php">
				<p>
					<label for = "DBLP_Key"> DBLP_Key :</label>
					<input type = "text" name = "DBLP_Key" id = "DBLP_Key"/>
					
					<br/>
					
					<label for = "Title">  Title :</label>
					<input type = "text" name = "Title" id = "Title"/>
					
					<br/>
					
					<label for = "URL"> URL (optional) :</label>
					<input type = "text" name = "URL" id = "URL"/>
					
					<br/>
					
					<label for = "EE"> EE (optional) :</label>
					<input type = "text" name = "EE" id = "EE"/>
					
					<br/>
					
					<label for = "Year"> Year :</label>
					<input type = "text" name = "Year" id = "Year"/>
					
					<br/>
					
					<label for = "Crossref"> Crossref (optional) :</label>
					<input type = "text" name = "Crossref" id = "Crossref"/>
					
					<br/>
					
					<label for = "Note"> Note (optional) :</label>
					<input type = "text" name = "Note" id = "Note"/>
					
					<br/>
					
					<input type = "submit" value = "Submit"/>	
					
					<br/><br/>
					
					
		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--Footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>