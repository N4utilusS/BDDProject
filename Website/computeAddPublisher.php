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
				
				
				$response = $bdd->query('SELECT DISTINCT Name, Publisher_id FROM Publisher WHERE Name LIKE "'. $_POST['Name']. '%"'); // Vérifie si le nom du publisher matche avec celui d'un publisher préexistant.
				
				while ($data = $response -> fetch()){
						?>
    					<p>
    					<a href= <?php echo '"addPublisherPublication.php?publisher='.($data['Publisher_id']). '&amp;publication='. $_GET['publication'].'"';?>> Did you mean :
   		    			<strong><?php echo $data['Name']; ?></strong></a>  ?<br /> 				
    					</p>
						<?php
						$exists = true;
					}
					
					$response->closeCursor(); // Termine le traitement de la requête
		
				if ($exists==false){ // Si le nom entré ne matche avec rien d'existant, le publisher n'existe pas et il faut le créer.
					
					$response = $bdd->query('INSERT INTO Publisher (Name, Time_stp) VALUES ("' .htmlspecialchars($_POST['Name']).'", NOW())'); // On le crée
					$response = $bdd->query('SELECT Publisher_id FROM Publisher WHERE Name = "'. $_POST['Name']. '"'); // On va chercher son ID
					$data = $response -> fetch();
					$response = $bdd->query('INSERT INTO Publisher_Publication (Publisher_id, Publication_id, Time_stp) VALUES ('.$data['Publisher_id'].', '.($_GET['publication']).', NOW())'); // Et on le lie à la publication.	 
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
