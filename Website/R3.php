<?php if(!isset($_SESSION)) session_start(); ?>
<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>R1 <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
			Les ID des auteurs qui ont écrit au moins deux articles pendant la même année.
			<?php
			
			//------------------------------------------------
			// Connection avec la base de données.
			//------------------------------------------------
			
				try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				}	
				catch(Exception $e){
					die('Error : ' .$e -> getMessage());
					echo 'Something went wrong...';
				}
				
			//------------------------------------------------
			// Recherche du nbre de publications en rapport avec cet author.
			//------------------------------------------------
			
				if (!isset($_SESSION['R2Number'])){
					
					$response = $bdd->query('SELECT COUNT(*)
											FROM (
												SELECT DISTINCT AP1.Author_id
												FROM Author_Publication AP1, Author_Publication AP2, Article AR1, Publication P1, Publication P2, Article AR2
												WHERE AP1.Author_id = AP2.Author_id
												AND AR1.Publication_id = P1.Publication_id
												AND P1.Publication_id = AP1.Publication_id
												AND AR2.Publication_id = P2.Publication_id
												AND P2.Publication_id = AP2.Publication_id
												AND P1.Year = P2.Year
												AND P1.Publication_id != P2.Publication_id
												) req');
					$entry = $response->fetch();
					
					$_SESSION['R2Number'] = $entryNumber = (int) $entry['COUNT(*)'];
					
					$response->closeCursor();
				}
				else $entryNumber = (int) $_SESSION['R2Number'];
				
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
				
			//------------------------------------------------
			// Requête.
			//------------------------------------------------
				
				$response = $bdd->query('SELECT DISTINCT AP1.Author_id
										FROM Author_Publication AP1, Author_Publication AP2, Article AR1, Publication P1, Publication P2, Article AR2
										WHERE AP1.Author_id = AP2.Author_id
										AND AR1.Publication_id = P1.Publication_id
										AND P1.Publication_id = AP1.Publication_id
										AND AR2.Publication_id = P2.Publication_id
										AND P2.Publication_id = AP2.Publication_id
										AND P1.Year = P2.Year
										AND P1.Publication_id != P2.Publication_id
										LIMIT ' . $_GET['resultMin'] . ', 50');
				
			//------------------------------------------------
			// Affichage.
			//------------------------------------------------
				
				while($data = $response->fetch()){ ?>
					<p>
					<a href= <?php echo '"detailsSearchAuthor.php?author=' . $data['Author_id'] . '"';?> >
	    			<strong> <?php echo $data['Author_id']; ?> </strong> </a> <br /> 				
					</p>
				<?php
				}
				
				$response->closeCursor();
				
				if ($_GET['resultMin'] > 0){ ?>
					<a href= <?php echo '"R2.php?resultMin=' . ($_GET['resultMin']-50) . '"';?> >50 entrées précédentes</a>
				<?php }
				
				if ($_GET['resultMin'] < $entryNumber-51){ ?>
					<a href= <?php echo '"R2.php?resultMin=' . ($_GET['resultMin']+50) . '"';?> >50 entrées suivantes</a>
			<?php }
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