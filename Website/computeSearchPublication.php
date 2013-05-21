
<!DOCTYPE  html>
<?php if(!isset($_SESSION)) session_start(); ?>

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

				if(isset($_POST['publication'])  or isset($_GET['publication']) ){
						try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}$bdd->exec("SET CHARACTER SET utf8");
				}
				
				
				else {header('Location : searchPublication.php');
					exit();}
				
				//------------------------------------------------
				// Recherche du nbre de publications correspondant à la recherche.
				//------------------------------------------------
				
				
				if(isset($_POST['publication'])) $_GET['publication'] = $_POST['publication'];
				
				$response = $bdd->query('SELECT COUNT(distinct P.Publication_id) FROM Publication P	WHERE P.Title LIKE "' . $_GET['publication'].'"'); // On compte le nombre de résultats de la requète à venir pour pouvoir les afficher par groupes de 50
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct P.Publication_id)'];
			
				$response->closeCursor(); // Termine le traitement de la requête
				
				//------------------------------------------------
				// Vérification ou création de resultMin pour pouvoir bien gérer les liens page précédente et suivante.
				//------------------------------------------------
				
				if (!empty($_GET['resultMin'])){
					$_GET['resultMin'] = (int) $_GET['resultMin'];	
					if ($_GET['resultMin'] < 0 OR $_GET['resultMin'] >= $entryNumber) $_GET['resultMin'] = 0;	
				}
				else {
					$_GET['resultMin'] = 0;	// Créer
				}

				
		
					$response = $bdd->query('SELECT DISTINCT P.Title, P.Year, P.Publication_id FROM Publication P WHERE P.Title LIKE "' . $_GET['publication'] . '" ORDER BY P.Title LIMIT ' . $_GET['resultMin'] . ', 50'); // On cherche les détails de la publication pour pouvoir les afficher.
		
					while ($data = $response -> fetch()){ 
						?>
    					<p>
    					<a href= <?php echo '"detailsPublication.php?publication='.($data['Publication_id']).'"';?>>
   		    			<strong><?php echo $data['Title']; ?></strong></a> <?php echo $data['Year'];?> <br /> 				
    					</p>
						<?php
					}
					
					$response->closeCursor(); // Termine le traitement de la requête
					
					if ($_GET['resultMin'] > 0){ ?>
						<a href= <?php echo '"computeSearchPublication.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;publication=' . $_GET['publication'] . '"';?> >50 publications précédentes</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"computeSearchPublication.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;publication=' . $_GET['publication'] . '"';?> >50 publications suivantes</a>
					<?php }
				

			?>	

		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>
