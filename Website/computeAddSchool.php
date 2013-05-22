<?php if(!isset($_SESSION)) session_start(); ?>


<!DOCTYPE  html>

<?php function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}?>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Adding the publisher...  <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		
		<?php if(!empty($_POST['Name']) AND !empty($_GET['publication'])){
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
				$bdd->exec("SET CHARACTER SET utf8");
				
				
				$exists = false;
				
				
				$response = $bdd->query('SELECT DISTINCT Name, School_id FROM School WHERE Name LIKE "'. $_POST['Name']. '%"'); // On va chercher les écoles dont le nom matche avec le nom entré.
				
				while ($data = $response -> fetch()){
						?>
    					<p>
    					<a href= <?php echo '"addSchoolThesis.php?school='.($data['School_id']). '&amp;publication='. $_GET['publication'].'"';?>> Did you mean :
   		    			<strong><?php echo $data['Name']; ?></strong></a>  ?<br /> 				
    					</p>
						<?php
						$exists = true;
					}
					
					$response->closeCursor(); // Termine le traitement de la requête
		
				if ($exists==false){ // Si aucune école ne matche, l'école entrée n'existe pas et il faut la créer.
					
					$bdd->beginTransaction();
					$response = $bdd->query('INSERT INTO School (Name, Time_stp) VALUES ("' .htmlspecialchars($_POST['Name']).'", NOW())'); // On la crée.
					$last_insert_id = $bdd->lastInsertId();
					$response = $bdd->query('INSERT INTO School_Thesis (School_id, Publication_id, Time_stp) VALUES ('.$last_insert_id.', '.htmlspecialchars($_GET['publication']).', NOW())'); // Et on se sert de l'ID pour créer un lien entre l'école et la publication.	 
				    $bdd->commit();
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
