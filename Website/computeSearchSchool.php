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

				if(isset($_POST['school']) OR isset($_GET['school'])){
					try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}	
					catch(Exception $e){
						die('Error : ' .$e -> getMessage());
						echo 'Something went wrong...';
					}
				}
				else {
					header('Location : searchSchool.php');
					exit();
				}$bdd->exec("SET CHARACTER SET utf8");
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				if(!empty($_POST['school'])) $_GET['school'] = $_POST['school'];
				
				$response = $bdd->query('SELECT COUNT(distinct S.School_id) 
				FROM School S 
				WHERE S.Name 
				LIKE "' . $_GET['school'] . '"');  // On compte le nombre de résultats de la requète à venir pour pouvoir les afficher par groupes de 50
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct S.School_id)'];
			
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
						FROM School S
						WHERE S.Name 
						LIKE "' . $_GET['school'] . '"
						ORDER BY Name  
						LIMIT ' . $_GET['resultMin'] . ', 50'); // Sélectionne les info de l'école pour pouvoir les afficher.
				
					
		
		
					while ($data = $response -> fetch()){ 
						?>
    					<p>
    					<a href= <?php echo '"detailsSchool.php?school='.($data['School_id']).'"';?>>
   		    			<strong><?php echo $data['Name']; ?></strong></a> <br /> 				
    					</p>
						<?php
					}
					
					$response->closeCursor(); // Termine le traitement de la requête

			
					
					if ($_GET['resultMin'] > 0){ ?>
						<a href= <?php echo '"computeSearchSchool.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;school=' . $_GET['school'] . '"';?> >50 ecoles précédentes</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"computeSearchSchool.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;school=' . $_GET['school'] . '"';?> >50 ecoles suivantes</a>
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
