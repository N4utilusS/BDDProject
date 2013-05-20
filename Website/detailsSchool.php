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

				if(isset($_POST['school']) OR $_GET['school']){
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
				}
				$bdd->exec("SET CHARACTER SET utf8");
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				if(isset($_POST['school'])) $_GET['school'] = $_POST['school'];
				
				$names = $bdd->query('SELECT Name FROM School WHERE School_id='.$_GET['school']);
				if ($name = $names -> fetch()) { ?> Name of the school : 
					<strong><?php echo $name['Name']; ?></strong> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ) {?>
					<a href = <?php echo '"changeSchoolName.php?school='.$_GET['school'].'"';?> title = "changeSchoolName"> Change</a> <?php  } ?></a><br /> <br />
				<?php } ?> List of the thesis from this school: <br /> <?php
				
				
				$response = $bdd->query('SELECT COUNT(distinct ST.Publication_id) 
				FROM School_Thesis ST 
				WHERE ST.School_id 
				= "' . $_GET['school'] . '"');
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct ST.Publication_id)'];
			
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
						FROM Publication P, School_Thesis ST 
						WHERE P.Publication_id=ST.Publication_id AND ST.School_id
						= "' . $_GET['school'] . '" 
						ORDER BY P.Title 
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
						<a href= <?php echo '"detailsSchool.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;school=' . $_GET['school'] . '"';?> >50 publications précédentes</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"detailsSchool.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;school=' . $_GET['school'] . '"';?> >50 publications suivantes</a>
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
