<?php if(!isset($_SESSION)) session_start(); ?>
<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>R1 <?php if (isset($_SESSION['email'])) echo $_SESSION['email']; else echo 'Visitor'; ?></h1>
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
			
				if (!isset($_SESSION['R5Number'])){	// Le nbre n'est rafraichi que lorsqu'on se reconnecte.
					
					$response = $bdd->query('SELECT COUNT(*)
											FROM (
												SELECT ap.Author_id
												FROM Author_Publication ap, Journal_Article ja, 
													(SELECT MAX(DistinctJ) AS Max
													FROM (
														SELECT COUNT(distinct ja2.Journal_name) AS DistinctJ
														FROM Author_Publication ap2, Journal_Article ja2
														WHERE ap2.Publication_id = ja2.Publication_id
														GROUP BY ap2.Author_id
														) DistinctJPerAuthor
													) MaxOfAllAuthor
												WHERE ap.Publication_id = ja.Publication_id
												GROUP BY ap.Author_id, Max
												HAVING COUNT(distinct ja.Journal_name) >= Max
												) req');	// ~20s
					$entry = $response->fetch();
					
					$_SESSION['R5Number'] = (int) $entry['COUNT(*)'];
					
					$response->closeCursor();
				}
				
				
			//------------------------------------------------
			// Vérification ou création de resultMin pour pouvoir bien gérer les liens page précédente et suivante.
			//------------------------------------------------
			
				if (!empty($_GET['resultMin'])){	// Existe ?
					$_GET['resultMin'] = (int) $_GET['resultMin'];	// Nombre ?
					if ($_GET['resultMin'] < 0 OR $_GET['resultMin'] >= $_SESSION['R5Number']) $_GET['resultMin'] = 0;	// Nombre bissextile ?
				}
				else {
					$_GET['resultMin'] = 0;	// Créer
				}
				
			//------------------------------------------------
			// Requête.
			//------------------------------------------------
				
				$response = $bdd->query('SELECT ap.Author_id
										FROM Author_Publication ap, Journal_Article ja, 
											(SELECT MAX(DistinctJ) AS Max
											FROM (
												SELECT COUNT(distinct ja2.Journal_name) AS DistinctJ
												FROM Author_Publication ap2, Journal_Article ja2
												WHERE ap2.Publication_id = ja2.Publication_id
												GROUP BY ap2.Author_id
												) DistinctJPerAuthor
											) MaxOfAllAuthor
										WHERE ap.Publication_id = ja.Publication_id
										GROUP BY ap.Author_id, Max
										HAVING COUNT(distinct ja.Journal_name) >= Max
										LIMIT ' . $_GET['resultMin'] . ', 50');	// ~10s
				
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
				echo '<pre>';
				print_r($_SESSION);
				echo '</pre>';
				
				$response->closeCursor();
				
				if ($_GET['resultMin'] > 0){ ?>
					<a href= <?php echo '"R5.php?resultMin=' . ($_GET['resultMin']-50) . '"';?> >50 entrées précédentes</a>
				<?php }
				
				if ($_GET['resultMin'] < $_SESSION['R5Number']-51 AND $_SESSION['R5Number']-51 > 0){ ?>
					<a href= <?php echo '"R5.php?resultMin=' . ($_GET['resultMin']+50) . '"';?> >50 entrées suivantes</a>
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