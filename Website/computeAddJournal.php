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
			<h1>Adding the journal...  <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
		
		
		<?php if(!empty($_POST['Name']) AND !empty($_GET['publication']) AND isset($_POST['Year'])){
					try{	
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}	
					catch(Exception $e){
						die('Error : ' .$e -> getMessage());
						echo 'Something went wrong...';
					}
				}
				else {
					header('Location : addJournal.php');
					exit();
				}
				$bdd->exec("SET CHARACTER SET utf8");
				
				$exists = false;
				
				
				$response = $bdd->query('SELECT DISTINCT Name FROM Journal WHERE Name LIKE "'. $_POST['Name']. '%"'); // On cherche les journaux dont le nom matche avec celui rentré.
				
				while ($data = $response -> fetch()){
						?>
    					<p>
    					<a href= <?php echo '"addJournalArticle.php?journal='.($data['Name']). '&amp;publication='. $_GET['publication'].'"';?>> Did you mean :
   		    			<strong><?php echo $data['Name']; ?></strong> </a>  ?<br /> 				
    					</p>
						<?php
						$exists = true;
					}
					
					$response->closeCursor(); // Termine le traitement de la requête
		
				if ($exists==false){ // Si le nom ne matche pas, le journal n'existe pas encore et il faut le créer.
					
					$response = $bdd->query('INSERT INTO Journal (Name, Year, Time_stp) VALUES ("' .htmlspecialchars($_POST['Name']).'",'.htmlspecialchars($_POST['Year']).', NOW())'); // On crée le journal.
					$response = $bdd->query('INSERT INTO Journal_Article (Journal_name, Publication_id, Time_stp) VALUES ("'.htmlspecialchars($_POST['Name']).'", '.($_GET['publication']).', NOW())');	// Et on l'associe à l'article. 
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
