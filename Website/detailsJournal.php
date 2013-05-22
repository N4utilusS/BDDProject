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

				if(isset($_POST['journal']) OR $_GET['journal']){
					try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}	
					catch(Exception $e){
						die('Error : ' .$e -> getMessage());
						echo 'Something went wrong...';
					}
				}
				else {
					header('Location : searchJournal.php');
					exit();
				}$bdd->exec("SET CHARACTER SET utf8");
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				if(isset($_POST['journal'])) $_GET['journal'] = $_POST['journal'];
				
				$names = $bdd->query('SELECT Name FROM Journal WHERE Name="'.$_GET['journal'].'"');
				if ($name = $names -> fetch()) { ?> Name of the journal : 
					<strong><?php echo $name['Name']; ?></strong> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ) {?>
					<a href = <?php echo '"changeJournalName.php?journal='.$_GET['journal'].'"';?> title = "changeJournalName"> Change</a> <?php  } ?></a><br /> <br />
				<?php }


				?> These are the articles paruted in the journal : <br /> <?php
				
				
				$response = $bdd->query('SELECT COUNT(distinct JA.Publication_id) 
				FROM Journal_Article JA 
				WHERE JA.Journal_name 
				= "' . $_GET['journal'] . '"'); // On compte le nombre de résultats de la requète à venir pour pouvoir les afficher par groupes de 50
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct JA.Publication_id)'];
			
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
						FROM Publication P, Journal_Article JA
						WHERE P.Publication_id=JA.Publication_id AND JA.Journal_name
						= "' . $_GET['journal'] . '"  
						ORDER BY P.Title
						LIMIT ' . $_GET['resultMin'] . ', 50'); // On sélectionne les publications liées au journal pour les afficher.
				
					
		
		
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
						<a href= <?php echo '"detailsJournal.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;journal=' . $_GET['journal'] . '"';?> >50 publications précédentes</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"detailsJournal.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;journal=' . $_GET['journal'] . '"';?> >50 publications suivantes</a>
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
