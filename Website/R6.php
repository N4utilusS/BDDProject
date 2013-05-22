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
			Les journaux avec leur nombre total d’articles, le nombre d’articles moyen par an et le nombre
d’auteurs moyen par article depuis leur année de création et ce pour tous les journaux dont le nombre de volumes par an est supérieur au nombre de volumes moyen par an des journaux.
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
			
				if (!isset($_SESSION['R6Number'])){
					
					$response = $bdd->query('SELECT COUNT(*)
											FROM (
												SELECT KeptJournal, 
														COUNT(ja3.Publication_id) AS NumberArticle, -- Nbre article depuis 2008.
														COUNT(ja3.Publication_id)/4 AS AvgArticlePerYear, -- Nbre article moyen par an.
														(	SELECT COUNT(ap.Author_id)/COUNT(distinct ap.Publication_id) -- Shit got serious.
															FROM Journal_Article ja4, Author_Publication ap
															WHERE ja4.Journal_name = KeptJournal AND ja4.Publication_id = ap.Publication_id
														) AS AvgAuthorPerArticle -- Moyenne nbre auteur par article pour un journal gardé.
												FROM Journal_Article ja3,	(
												
													SELECT ja2.Journal_name AS KeptJournal-- On a les journaux en question.
													FROM Article ar2, Journal_Article ja2,	(
													
														SELECT AVG(VolCount) AS Average -- Une ligne contenant juste la moyenne du nbre de volume des journaux.
														FROM	(
															SELECT COUNT(distinct ar.Volume) AS VolCount -- Ensemble des nbre de volume par journal.
															FROM Article ar, Journal_Article ja
															WHERE ar.Publication_id = ja.Publication_id
															GROUP BY ja.Journal_name
																) Volume_Amount_For_Each_Journal
																							) av
												
													WHERE ja2.Publication_id = ar2.Publication_id
													GROUP BY ja2.Journal_name, Average
													HAVING COUNT(distinct ar2.Volume) > Average -- Nbre volumes distints > moyenne.
																			) Journals
												
												WHERE ja3.Journal_name = KeptJournal
												GROUP BY KeptJournal
												) req');	// ~8s
					$entry = $response->fetch();
					
					$_SESSION['R6Number'] = (int) $entry['COUNT(*)'];
					
					$response->closeCursor();
				}
				
				
			//------------------------------------------------
			// Vérification ou création de resultMin pour pouvoir bien gérer les liens page précédente et suivante.
			//------------------------------------------------
			
				if (!empty($_GET['resultMin'])){	// Existe ?
					$_GET['resultMin'] = (int) $_GET['resultMin'];	// Nombre ?
					if ($_GET['resultMin'] < 0 OR $_GET['resultMin'] >= $_SESSION['R6Number']) $_GET['resultMin'] = 0;	// Nombre bissextile ?
				}
				else {
					$_GET['resultMin'] = 0;	// Créer
				}
				
			//------------------------------------------------
			// Requête.
			//------------------------------------------------
				
				$response = $bdd->query('SELECT KeptJournal, 
												COUNT(ja3.Publication_id) AS NumberArticle, -- Nbre article depuis 2008.
												COUNT(ja3.Publication_id)/4 AS AvgArticlePerYear, -- Nbre article moyen par an.
												(	SELECT COUNT(ap.Author_id)/COUNT(distinct ap.Publication_id) -- Shit got serious.
													FROM Journal_Article ja4, Author_Publication ap
													WHERE ja4.Journal_name = KeptJournal AND ja4.Publication_id = ap.Publication_id
												) AS AvgAuthorPerArticle -- Moyenne nbre auteur par article pour un journal gardé.
										FROM Journal_Article ja3,	(
										
											SELECT ja2.Journal_name AS KeptJournal-- On a les journaux en question.
											FROM Article ar2, Journal_Article ja2,	(
											
												SELECT AVG(VolCount) AS Average -- Une ligne contenant juste la moyenne du nbre de volume des journaux.
												FROM	(
													SELECT COUNT(distinct ar.Volume) AS VolCount -- Ensemble des nbre de volume par journal.
													FROM Article ar, Journal_Article ja
													WHERE ar.Publication_id = ja.Publication_id
													GROUP BY ja.Journal_name
														) Volume_Amount_For_Each_Journal
																					) av
										
											WHERE ja2.Publication_id = ar2.Publication_id
											GROUP BY ja2.Journal_name, Average
											HAVING COUNT(distinct ar2.Volume) > Average -- Nbre volumes distints > moyenne.
																	) Journals
										
										WHERE ja3.Journal_name = KeptJournal
										GROUP BY KeptJournal
										LIMIT ' . $_GET['resultMin'] . ', 50');
				
			//------------------------------------------------
			// Affichage.
			//------------------------------------------------
				
				while($data = $response->fetch()){ ?>
					<p>
					<a href= <?php echo '"detailsJournal.php?journal=' . $data['KeptJournal'] . '"';?> >
	    			<strong> <?php echo $data['KeptJournal']; ?> </strong> </a> <?php echo ' | ' . $data['NumberArticle'] . ' | ' . $data['AvgArticlePerYear'] . ' | ' . $data['AvgAuthorPerArticle']; ?> <br /> 				
					</p>
				<?php
				}
				
				$response->closeCursor();
				
				if ($_GET['resultMin'] > 0){ ?>
					<a href= <?php echo '"R6.php?resultMin=' . ($_GET['resultMin']-50) . '"';?> >50 entrées précédentes</a>
				<?php }
				
				if ($_GET['resultMin'] < $_SESSION['R6Number']-51){ ?>
					<a href= <?php echo '"R6.php?resultMin=' . ($_GET['resultMin']+50) . '"';?> >50 entrées suivantes</a>
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