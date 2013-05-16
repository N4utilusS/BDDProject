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
		
		<section> <!--Zone centrale-->
		
			<?php
			
			//------------------------------------------------
			// Connection avec la base de données.
			//------------------------------------------------

				if(isset($_POST['publisher']) OR $_GET['publisher']){
					try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}	
					catch(Exception $e){
						die('Error : ' .$e -> getMessage());
						echo 'Something went wrong...';
					}
				}
				else {
					header('Location : searchPublishor.php');
					exit();
				}
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				if(isset($_POST['publisher'])) $_GET['publisher'] = $_POST['publisher'];
				
				$response = $bdd->query('SELECT COUNT(distinct PP.Publication_id) 
				FROM publisher_publication PP 
				WHERE PP.Publisher_id 
				= "' . $_GET['publisher'] . '"');
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct PP.Publication_id)'];
			
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
				

					$response = $bdd->query('SELECT P.Title, P.Year, P.Publication_id
						FROM publication P, publisher_publication PP 
						WHERE P.Publication_id=PP.Publication_id AND PP.Publisher_id
						= "' . $_GET['publisher'] . '"  
						LIMIT ' . $_GET['resultMin'] . ', 50');
				
					
		
		
					while ($data = $response -> fetch()){ // Problème: rendre clickable les résultats affichés pour obtenir un détail
						?>
    					<p>
    					<a href= <?php echo '"detailsPublication.php?publication='.($data['Publication_id']).'"';?>>
   		    			<strong><?php echo $data['Title']; ?></strong></a> <?php echo $data['Year'];?> <br /> 				
    					</p>
						<?php
					}
					
					$response->closeCursor(); // Termine le traitement de la requête

			
					
					if ($_GET['resultMin'] > 0){ ?>
						<a href= <?php echo '"detailsPublisher.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;publisher=' . $_GET['publisher'] . '"';?> >50 publications précédentes</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"detailsPublisher.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;publisher=' . $_GET['publisher'] . '"';?> >50 publications suivantes</a>
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