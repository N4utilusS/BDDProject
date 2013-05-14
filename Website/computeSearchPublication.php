
<!DOCTYPE  html>
<?php if(!isset($_SESSION)) session_start(); ?>

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

				if(isset($_POST['publication']) and isset($_POST['type'])){
						try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'Te_v0et');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}
		
					if ($_POST['type'] == "Book") $response = $bdd->prepare('SELECT P.Title, P.Year FROM publication P, book B WHERE B.Publication_id = P.Publication_id AND P.Title LIKE ?');
					else if ($_POST['type'] == "Article") $response = $bdd->prepare('SELECT P.Title, P.Year FROM publication P, article A WHERE A.Publication_id = P.Publication_id AND P.Title LIKE ?');
					else if ($_POST['type'] == "PHDThesis") $response = $bdd->prepare('SELECT P.Title, P.Year FROM publication P, PHD_Thesis PHD WHERE PHD.Publication_id = P.Publication_id AND P.Title LIKE ?');
					else if ($_POST['type'] == "MasterThesis") $response = $bdd->prepare('SELECT P.Title, P.Year FROM publication P, thesis T WHERE T.Publication_id = P.Publication_id AND P.Title LIKE ?');
					$response -> execute(array(	$_POST['publication']));
		
					while ($data = $response -> fetch()){ // Problème: rendre clickable les résultats affichés pour obtenir un détail
						?>
    					<p>
   		    			<strong>Publication</strong> : <?php echo $data['Title']; ?><br />
    					Year : <?php echo $data['Year']; ?>
    					</p>
						<?php
					}
				}
			?>	

		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>