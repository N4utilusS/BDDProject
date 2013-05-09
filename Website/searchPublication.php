<!DOCTYPE  html>
<?php if(!isset($_SESSION)) session_start(); ?>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> //En-tête
			<h1>Let's search for a publication <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> //Zone centrale
			<p>Enter the name of your publication</p>
			
			<form method = "post" action = "computeSearchPublication.php">
				<p>
					<label for = "publication"> Your publication :</label>
					<input type = "text" name = "publication" id = "publication"/>
					
					<br/>
					
					<input type = "radio" name = "type" value = "Article" id = "Article"/>
					<label for = "Article">Article</label><br/>
					
					<input type = "radio" name = "type" value = "Book" id = "Book"/>
					<label for = "Book">Book</label><br/>
					
					<input type = "radio" name = "type" value = "PHDThesis" id = "PHDThesis"/>
					<label for = "PHDThesis">PHD Thesis</label><br/>
					
					<input type = "radio" name = "type" value = "MasterThesis" id = "MasterThesis"/>
					<label for = "MasterThesis">Master Thesis</label><br/>
					
					<input type = "submit" value = "Submit"/>
				</p>
			</form>			
		</section>	
		
		<nav> //Menu
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> //Footer !
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>