<?php if(!isset($_SESSION)) session_start(); ?>


<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Details of the publication,  <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
		
			<?php
			
			//------------------------------------------------
			// Connection avec la base de données.
			//------------------------------------------------

				if(isset($_GET['publication'])){
					try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'Te_v0et', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}	
					catch(Exception $e){
						die('Error : ' .$e -> getMessage());
						echo 'Something went wrong...';
					}
				}
				else {
					header('Location : welcome.php');
					exit();
				}
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				$response = $bdd->query('SELECT DISTINCT AN.Name FROM author_name AN, author_publication AP WHERE AP.Publication_id=' . $_GET['publication'].' AND AN.Author_id=AP.Author_id');
				?>
				<strong>Author Name(s) : </strong>
				<?php while($data = $response -> fetch()){?>
				
				<?php echo $data['Name'];?>
				
				<?php
				}
				$response = $bdd->query('SELECT * FROM publication P WHERE P.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong><?php echo $data['Title']; ?></strong></a> <?php echo $data['Year'];?> <br />
					<strong>URL : </strong><?php echo $data['URL'];?> <br />
					<strong>EE : </strong><?php echo $data['EE'];?> <br />
					<strong>CROSSREF : </strong><?php echo $data['Crossref'];?> <br />
					<strong>NOTE : </strong><?php echo $data['Note'];?> <br />
				<?php }

				
				
				
				
				$response = $bdd->query('SELECT * FROM article AR WHERE AR.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){
					
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