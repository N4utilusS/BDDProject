<?php if(!isset($_SESSION)) session_start(); ?>


<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Result of your search,  <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> <!--Zone centrale--> Les noms d'auteurs suivis de leur ID interne à la base de donnée, si deux noms sont associés à la même ID, ils désignent la même personne.
		
			<?php
			
			//------------------------------------------------
			// Connection avec la base de données.
			//------------------------------------------------
			

				if(isset($_POST['author']) OR $_GET['author']){
					try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}	
					catch(Exception $e){
						die('Error : ' .$e -> getMessage());
						echo 'Something went wrong...';
					}
				}
				else {
					header('Location : searchAuthor.php');
					exit();
				}
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				if(isset($_POST['author'])) $_GET['author'] = $_POST['author'];
				
				$response = $bdd->query('SELECT COUNT(distinct AN.Name) 
				FROM author_name AN 
				WHERE AN.Name 
				LIKE "' . $_GET['author'] . '"');
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct AN.Name)'];
			
				$response->closeCursor(); // Termine le traitement de la requête
			

				//------------------------------------------------
				// Vérification ou création de resultMin pour pouvoir bien gérer les liens page précédente et suivante.
				//------------------------------------------------
				
				if (!empty($_GET['resultMin'])){	// Existe ?
					$_GET['resultMin'] = (int) $_GET['resultMin'];	// Nombre ?
					if ($_GET['resultMin'] < 0 OR $_GET['resultMin'] >= $entryNumber) $_GET['resultMin'] = 0;	// Nombre bissextile ?
				}
				else {
					$_GET['resultMin'] = 0;	// Créer
				}
				

					$response = $bdd->query('SELECT Name, Author_id
						FROM author_name
						WHERE Name 
						LIKE "' . $_GET['author'] . '"
						ORDER BY Name  
						LIMIT ' . $_GET['resultMin'] . ', 50');
				
					
		
		
					while ($data = $response -> fetch()){ // Problème: rendre clickable les résultats affichés pour obtenir un détail
						?>
    					<p>
    					<a href= <?php echo '"detailsSearchAuthor.php?author='.($data['Author_id']).'"';?>>
   		    			<strong><?php echo $data['Name']; ?></strong></a> <?php echo $data['Author_id']; ?><br /> 				
    					</p>
						<?php
					}
					
					$response->closeCursor(); // Termine le traitement de la requête

			
					
					if ($_GET['resultMin'] > 0){ ?>
						<a href= <?php echo '"computeSearchAuthor.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;author=' . $_GET['author'] . '"';?> >50 auteurs précédents</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"computeSearchAuthor.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;author=' . $_GET['author'] . '"';?> >50 auteurs suivants</a>
					<?php }

				
			?>	

		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--Footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>