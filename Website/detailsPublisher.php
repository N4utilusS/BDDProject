<?php if(!isset($_SESSION)) session_start(); ?>


<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Result of your search,  <?php if (isset($_SESSION['email'])) echo $_SESSION['email']; else echo 'Visitor'; ?></h1>
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
				
				
				$names = $bdd->query('SELECT Name FROM Publisher WHERE Publisher_id='.$_GET['publisher']); // On va chercher le nom du publisher pour l'afficher.
				if ($name = $names -> fetch()) { ?> Name of the publisher : 
					<strong><?php echo $name['Name']; ?></strong> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ) {?>
					<a href = <?php echo '"changePublisherName.php?publisher='.$_GET['publisher'].'"';?> title = "changePublisherName"> Change</a> <?php  } ?></a><br /> <br />
				<?php }
					
				
				$response = $bdd->query('SELECT COUNT(distinct PP.Publication_id) 
				FROM Publisher_Publication PP 
				WHERE PP.Publisher_id 
				= "' . $_GET['publisher'] . '"'); // On compte le nombre de résultats de la requète à venir pour pouvoir les afficher par groupes de 50
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct PP.Publication_id)'];
			
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
				

					$response = $bdd->query('SELECT P.Title, P.Year, P.Publication_id
						FROM Publication P, Publisher_Publication PP 
						WHERE P.Publication_id=PP.Publication_id AND PP.Publisher_id
						= "' . $_GET['publisher'] . '"  
						ORDER BY P.Title
						LIMIT ' . $_GET['resultMin'] . ', 50'); // On cherche les détails des publications publiées par le publisher.
						
						?> The list of the publications published by this publisher : <br /> <?php
				
					
		
		
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
