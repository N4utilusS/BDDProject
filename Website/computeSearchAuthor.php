
<!DOCTYPE  html>
<?php if(!isset($_SESSION)) session_start(); ?>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> //En-tête
			<h1>Result of your search,  <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> //Zone centrale
		
			<?php

				if(isset($_POST['author'])){
					try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'Te_v0et');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}
					$response = $bdd->prepare('SELECT P.Title, P.Year 
						FROM publication P, author A, author_publication AP, author_name AN 
						WHERE P.Publication_id=AP.Publication_id AND A.Author_id=AP.Author_id AND A.Author_id=AN.Author_id AND AN.Name LIKE ?');
					$response -> execute(array(	$_POST['author'])); // Trouver un moyen de rajouter % après ce que rentre l'user et un autre truc similaire mais pour obtenir ce qui il y a avant.
		
					while ($data = $response -> fetch()){ // Problème: rendre clickable les résultats affichés pour obtenir un détail
						?>
    					<p>
   		    			<strong>Publication</strong> : <?php echo $data['Title']; ?><br />
    					Year : <?php echo $data['Year']; ?>
    					</p>
						<?php
					}
				}
			?>	

		</section>	
		
		<nav> //Menu
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> //Footer !
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>