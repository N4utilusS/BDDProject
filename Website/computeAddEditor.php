<?php if(!isset($_SESSION)) session_start();
$isArticle=false; ?>


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
			<h1>Adding the editor...  <?php echo $_SESSION['email']; ?></h1>
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
				
				$exists = false;
				
				$articleRequest = $bdd->query('SELECT * FROM article WHERE Publication_id = '. htmlspecialchars($_GET['publication']));
				if($article = $articleRequest->fetch()) $isArticle = true;
				$response = $bdd->query('SELECT DISTINCT Name, Editor_id FROM editor WHERE Name LIKE "'. htmlspecialchars($_POST['Name']). '%"');
				
				while ($data = $response -> fetch()){
						?>
    					<p>
    					<a href= <?php echo '"addEditorPublication.php?editor='.($data['Editor_id']). '&amp;publication='. $_GET['publication'].'"';?>> Did you mean :
   		    			<strong><?php echo $data['Name']; ?></strong></a>  ?<br /> 				
    					</p>
						<?php
						$exists = true;
					}
					
					$response->closeCursor(); // Termine le traitement de la requête
		
				if ($exists==false){
					
					$response = $bdd->query('INSERT INTO editor (Name, Time_stp) VALUES ("' .htmlspecialchars($_POST['Name']).'", NOW())');
					$response = $bdd->query('SELECT Editor_id FROM editor WHERE Name = "'. htmlspecialchars($_POST['Name']). '"');
					$data = $response -> fetch();
					if ($isArticle) $response = $bdd->query('INSERT INTO editor_article (Editor_id, Publication_id, Time_stp) VALUES ('.$data['Editor_id'].', '.htmlspecialchars($_GET['publication']).', NOW())');
					else $response = $bdd->query('INSERT INTO editor_book (Editor_id, Publication_id, Time_stp) VALUES ('.$data['Editor_id'].', '.htmlspecialchars($_GET['publication']).', NOW())');		 
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