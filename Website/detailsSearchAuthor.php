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
				}$bdd->exec("SET CHARACTER SET utf8");
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				if(isset($_POST['author'])) $_GET['author'] = $_POST['author'];
				
				$information = $bdd->query('SELECT * FROM Author WHERE Author_id='.$_GET['author']);
				$names = $bdd->query('SELECT Name FROM Author_Name WHERE Author_id='.$_GET['author']);
				$data = $information -> fetch();
				
				
				
				if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ) {?>	<!--L'admin peut supprimer l'auteur, ou ajouter un nom supplémentaire pour l'auteur-->
						<a href = <?php echo '"deleteAuthor.php?author='.$_GET['author'].'"';?> title = "deleteAuthor">Delete this author from the DBLP</a><br />
						<form method = "post" action = <?php echo '"addAuthorName.php?author=' . $_GET['author'] . '"'; ?>>
						<p>
							<label for = "name"> New name to add :</label>
							<input type = "text" name = "name" id = "name"/>

							<input type = "submit" value = "Submit"/>
						</p>
						</form>		<?php } ?>
						 
				
				
    			<p> <!--Informations personnelles et options d'édition pour admin-->
   		    	Informations personnelles de: <?php while ($name = $names ->fetch()){ ?><strong><br /> <?php echo $name['Name']; ?> </strong> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?> 	
						<a href = <?php echo '"changeAuthorName.php?author='.$_GET['author']. '&amp;name='.$name['Name'].'"';?> title = "changeAuthorName"> Change</a> <?php  } ?></a><?php } ?><br /> <br /> 
   		        DBLP_www_Key: <?php echo $data['DBLP_www_Key']; if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeDBLPwwwKey.php?author='.$_GET['author'].'"';?> title = "changeDBLPwwwKey"> Change</a><br /> <?php } ?>
   		        URL: <?php echo $data['URL']; if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeURL.php?author='.$_GET['author'].'"';?> title = "changeURL"> Change</a> <br /> <?php } ?>
   		        Crossref: <?php echo $data['Crossref']; if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeCrossref.php?author='.$_GET['author'].'"';?> title = "changeCrossref"> Change</a> <br /> <?php } ?>
   		        Note: <?php echo $data['Note']; if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeNote.php?author='.$_GET['author'].'"';?> title = "changeNote"> Change</a> <br />  <?php } ?> 				
    			</p>
    			
    			Liste des publications auxquelles il a participé:
    			
				<?php
				
				$response = $bdd->query('SELECT COUNT(distinct P.Publication_id) 
				FROM Publication P, Author A, Author_Publication AP, Author_Name AN 
				WHERE P.Publication_id=AP.Publication_id AND A.Author_id=AP.Author_id AND A.Author_id=AN.Author_id AND A.Author_id 
				= ' . $_GET['author']);
					
				$entry = $response -> fetch();
				$entryNumber = (int) $entry['COUNT(distinct P.Publication_id)'];
			
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
						FROM Publication P, Author A, Author_Publication AP, Author_Name AN 
						WHERE P.Publication_id=AP.Publication_id AND A.Author_id=AP.Author_id AND A.Author_id=AN.Author_id AND A.Author_id 
						= ' . $_GET['author'] . '
						ORDER BY P.Title  
						LIMIT ' . htmlspecialchars($_GET['resultMin']) . ', 50');
				
					
		
		
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
						<a href= <?php echo '"detailsSearchAuthor.php?resultMin=' . ($_GET['resultMin']-50) . '&amp;author=' . $_GET['author'] . '"';?> >50 publications précédentes</a>
					<?php }
					
					if ($_GET['resultMin'] < $entryNumber-51){ ?>
						<a href= <?php echo '"detailsSearchAuthor.php?resultMin=' . ($_GET['resultMin']+50) . '&amp;author=' . $_GET['author'] . '"';?> >50 publications suivantes</a>
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
