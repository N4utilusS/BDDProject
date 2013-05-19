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
			Les ID des auteurs qui ont chacun publiée au moins une fois chaque année entre 2008 et 2010 inclus.
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
				
				$response = $bdd->query('SELECT COUNT(*)
										FROM (
											SELECT DISTINCT AN.Name
											FROM Author A, Author_Name AN, Article AR1, Publication P1, Author_Publication AP1, Publication P2, Author_Publication AP2, Article AR2
											WHERE A.Author_id = AN.Author_id
											AND A.Author_id = AP1.Author_id
											AND A.Author_id = AP2.Author_id
											AND AR1.Publication_id = P1.Publication_id
											AND P1.Publication_id = AP1.Publication_id
											AND AR2.Publication_id = P2.Publication_id
											AND P2.Publication_id = AP2.Publication_id
											AND P1.Year = P2.Year
											AND P1.Publication_id != P2.Publication_id
											) req');
				$entry = $response->fetch();
				
				$entryNumber = (int) $entry['COUNT(*)'];
				
				$response->closeCursor();
				
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
				
				$response = $bdd->query('SELECT DISTINCT AN.Name
										FROM Author A, Author_Name AN, Article AR1, Publication P1, Author_Publication AP1, Publication P2, Author_Publication AP2, Article AR2
										WHERE A.Author_id = AN.Author_id
											AND A.Author_id = AP1.Author_id
											AND A.Author_id = AP2.Author_id
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
					<a href= <?php echo '"R1.php?resultMin=' . ($_GET['resultMin']-50) . '"';?> >50 entrées précédentes</a>
				<?php }
				
				if ($_GET['resultMin'] < $entryNumber-51){ ?>
					<a href= <?php echo '"R1.php?resultMin=' . ($_GET['resultMin']+50) . '"';?> >50 entrées suivantes</a>
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