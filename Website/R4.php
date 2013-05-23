<?php if(!isset($_SESSION)) session_start(); ?>
<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>R4 <?php if (isset($_SESSION['email'])) echo $_SESSION['email']; else echo 'Visitor'; ?></h1>
		</header>
		
		<section> <!--Zone centrale-->
			Les articles qui n’ont aucun docteur parmi leurs auteurs, <br />
			où un docteur est défini comme un auteur pour lequel <br />
			la base de données contient une thèse de doctorat dont il est le seul auteur.
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
			// Vérification ou création de resultMin pour pouvoir bien gérer les liens page précédente et suivante.
			//------------------------------------------------
			
				if (!empty($_GET['resultMin'])){	// Existe ?
					$_GET['resultMin'] = (int) $_GET['resultMin'];	// Nombre ?
					if ($_GET['resultMin'] < 0) $_GET['resultMin'] = 0;	// Nombre bissextile ?
				}
				else {
					$_GET['resultMin'] = 0;	// Créer
				}
				
			//------------------------------------------------
			// Requête.
			//------------------------------------------------
				
				$response = $bdd->query('SELECT ar2.Publication_id
										FROM Article ar2
										WHERE ar2.Publication_id NOT IN	(
										
										SELECT ap3.Publication_id
										FROM Author_Publication ap3, Article ar
										WHERE ap3.Publication_id = ar.Publication_id AND ap3.Author_id IN	(
										
										SELECT ap2.Author_id
										FROM Author_Publication ap2
										WHERE ap2.Publication_id IN	(
										
										SELECT ap.Publication_id
										FROM Author_Publication ap, PHDThesis pt
										WHERE ap.Publication_id = pt.Publication_id
										GROUP BY ap.Publication_id
										HAVING COUNT(*) = 1			)
																											)
																		)
										LIMIT ' . $_GET['resultMin'] . ', 50');
											
			//------------------------------------------------
			// Affichage.
			//------------------------------------------------
				
				while($data = $response->fetch()){ ?>
					<p>
					<a href= <?php echo '"detailsPublication.php?publication=' . $data['Publication_id'] . '"';?> >
	    			<strong> <?php echo $data['Publication_id']; ?> </strong> </a> <br /> 				
					</p>
				<?php
				}
				
				$response->closeCursor();
				
				if ($_GET['resultMin'] > 0){ ?>
					<a href= <?php echo '"R4.php?resultMin=' . ($_GET['resultMin']-50) . '"';?> >50 entrées précédentes</a>
				<?php }
				?>
					
					<a href= <?php echo '"R4.php?resultMin=' . ($_GET['resultMin']+50) . '"';?> >50 entrées suivantes</a>
					<!-- Pas de test sur le nombre d'entrées retournées car met trop de temps à s'exécuter. -->
		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>