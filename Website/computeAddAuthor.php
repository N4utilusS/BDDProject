<?php if(!isset($_SESSION)) session_start(); ?>


<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Adding the author...  <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		Attention: seules 50 suggestions d'auteurs pré-existants sont affichées: vous devez être précis !
		
		<?php if(!empty($_POST['author']) AND !empty($_GET['publication'])){
					try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}	
					catch(Exception $e){
						die('Error : ' .$e -> getMessage());
						echo 'Something went wrong...';
					}
				}
				else {
					header('Location : addAuthor.php');
					exit();
				}
				
				$exists = false;
				
				
				$response = $bdd->query('SELECT Name FROM author_name WHERE Name LIKE "'. $_POST['author']. '"');
				
				while ($data = $response -> fetch()){ 
						?>
    					<p>
    					<a href= <?php echo '"addAuthorPublication.php?author='.($data['Author_id']). '&amp;publication='. $_GET['publication'].'"';?>> Did you mean :
   		    			<strong><?php echo $data['Name']; ?></strong></a>  ?<br /> 				
    					</p>
						<?php
						$exists = true;
					}
					
					$response->closeCursor(); // Termine le traitement de la requête
		
				if (!exists){
					 $response = $bdd->query('INSERT INTO author_name (Name, Time_stp) VALUES ("'.htmlspecialchars($_POST['author']).'", NOW())');
					 $response = $bdd->query('SELECT Name FROM author_name WHERE Name LIKE "'. $_POST['author']. '"');
					 $data = $response -> fetch();
					 $response = $bdd->query('INSERT INTO author (Author_id, DBLP_www_Key, URL, CROSSREF, Note, Time_stp) VALUES ('.$data['Author_id'].', "' .  htmlspecialchars($_POST['DBLP_Key']) . '", "' . htmlspecialchars($_POST['URL']) . '", "' . 
		htmlspecialchars($_POST['Crossref']) . '", "'. htmlspecialchars($_POST['Note']).'", NOW())');
				     $response = $bdd->query('INSERT INTO author_publication (Author_id, Publication_id, Time_stp) VALUES ('.$data['Author_id'].', '.htmlspecialchars($_POST['author']).', NOW())');
				
					 redirection('detailsPublication.php?publication=' . $_GET['publication']);

					exit();
				}
					 
					 
					 
		
		
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