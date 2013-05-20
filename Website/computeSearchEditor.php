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

				if(isset($_POST['editor']) OR $_GET['editor']){
					try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}	
					catch(Exception $e){
						die('Error : ' .$e -> getMessage());
						echo 'Something went wrong...';
					}
				}
				else {
					header('Location : searchEditor.php');
					exit();
				}
				$bdd->exec("SET CHARACTER SET utf8");
				
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				if(isset($_POST['editor'])) $_GET['editor'] = $_POST['editor'];
				
				$response = $bdd->query('SELECT COUNT(distinct E.Editor_id) 
				FROM Editor E 
				WHERE E.Name 
				LIKE "' . $_GET['editor'] . '"');
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct E.Editor_id)'];
			
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
				

					$response = $bdd->query('SELECT Name, Editor_id
						FROM Editor
						WHERE Name 
						LIKE "' . $_GET['editor'] . '"
						ORDER BY Name  
						LIMIT ' . $_GET['resultMin'] . ', 50');
				
					
		
		
					while ($data = $response -> fetch()){ // Problème: rendre clickable les résultats affichés pour obtenir un détail
						?>
    					<p>
    					<a href= <?php echo '"detailsEditor.php?editor='.($data['Editor_id']).'"';?>>
   		    			<strong><?php echo $data['Name']; ?></strong></a> <br /> 				
    					</p>
						<?php
					}
					
					$response->closeCursor(); // Termine le traitement de la requête

			
					
					if ($_GET['resultMin'] > 0){ ?>
						<a href= <?php echo '"computeSearchEditor.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;editor=' . $_GET['editor'] . '"';?> >50 éditeurs précédents</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"computeSearchEditor.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;editor=' . $_GET['editor'] . '"';?> >50 éditeurs suivants</a>
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
