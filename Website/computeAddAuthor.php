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
			<h1>Adding the author...  <?php echo $_SESSION['email']; ?></h1>
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
				
				
				$response = $bdd->query('SELECT DISTINCT Name, Author_id FROM Author_Name WHERE Name LIKE "'. $_POST['Name']. '%"');
				
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
		
				if ($exists==false){
					
					$response = $bdd->query('INSERT INTO Author (DBLP_www_Key, URL, CROSSREF, Note, Time_stp) VALUES ("' .  htmlspecialchars($_POST['DBLP_Key']) . '", "' . htmlspecialchars($_POST['URL']) . '", "' . 
					htmlspecialchars($_POST['Crossref']) . '", "'. htmlspecialchars($_POST['Note']).'", NOW())');
					$response = $bdd->query('SELECT Author_id FROM Author WHERE Note = "'. $_POST['Note']. '" AND DBLP_www_Key="'.  htmlspecialchars($_POST['DBLP_Key']) . '" AND URL ="'.htmlspecialchars($_POST['URL']) . '" AND Crossref ="'.htmlspecialchars($_POST['Crossref']) . '"');
					$data = $response -> fetch();
					$response = $bdd->query('INSERT INTO Author_Name (Author_id, Name, Time_stp) VALUES ('.$data['Author_id'].', "'.htmlspecialchars($_POST['Name']).'", NOW())');	 
				    $response = $bdd->query('INSERT INTO Author_Publication (Author_id, Publication_id, Time_stp) VALUES ('.$data['Author_id'].', '.$_GET['publication'].', NOW())');
				
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
