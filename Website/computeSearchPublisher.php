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
				}$bdd->exec("SET CHARACTER SET utf8");
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				if(isset($_POST['publisher'])) $_GET['publisher'] = $_POST['publisher'];
				
				$response = $bdd->query('SELECT COUNT(distinct P.Publisher_id) 
				FROM Publisher P 
				WHERE P.Name 
				LIKE "' . $_GET['publisher'] . '"');  // On compte le nombre de résultats de la requète à venir pour pouvoir les afficher par groupes de 50
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct P.Publisher_id)'];
			
				$response->closeCursor(); // Termine le traitement de la requête
			

				//------------------------------------------------
				// Vérification ou création de resultMin pour pouvoir bien gérer les liens page précédente et suivante.
				//------------------------------------------------
				
				if (!empty($_GET['resultMin'])){	// Existe ?
					$_GET['resultMin'] = (int) $_GET['resultMin'];	// Nombre ?
					if ($_GET['resultMin'] < 0 OR $_GET['resultMin'] >= $entryNumber) $_GET['resultMin'] = 0;
				}
				else {
					$_GET['resultMin'] = 0;	// Créer
				}
				

					$response = $bdd->query('SELECT *
						FROM Publisher P
						WHERE P.Name 
						LIKE "' . $_GET['publisher'] . '"
						ORDER BY Name  
						LIMIT ' . $_GET['resultMin'] . ', 50'); // Sélectionne les info du publisher pour pouvoir les afficher.
				
					
		
		
					while ($data = $response -> fetch()){
						?>
    					<p>
    					<a href= <?php echo '"detailsPublisher.php?publisher='.($data['Publisher_id']).'"';?>>
   		    			<strong><?php echo $data['Name']; ?></strong></a> <br /> 				
    					</p>
						<?php
					}
					
					$response->closeCursor(); // Termine le traitement de la requête

			
					
					if ($_GET['resultMin'] > 0){ ?>
						<a href= <?php echo '"computeSearchPublisher.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;publisher=' . $_GET['publisher'] . '"';?> >50 publishers précédents</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"computeSearchPublisher.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;publisher=' . $_GET['publisher'] . '"';?> >50 publishers suivants</a>
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
