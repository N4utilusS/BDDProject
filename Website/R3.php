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
			
				if (isset($_POST['author'])) {
					$_SESSION['R3Author'] = $_POST['author'];
					
					$response = $bdd->query('SELECT COUNT(*)
											FROM (
												SELECT distinct ap4.Author_id
												FROM Author_Publication ap1, Author_Publication ap2, Author_Publication ap3, Author_Publication ap4
												WHERE ap1.Author_id = ' . $_SESSION['R3Author'] . '
													AND ap1.Publication_id = ap2.Publication_id
													AND ap3.Publication_id = ap4.Publication_id
													AND ap1.Publication_id != ap3.Publication_id
													AND ap1.Author_id != ap2.Author_id
													AND ap3.Author_id != ap4.Author_id
													AND ap1.Author_id != ap4.Author_id
													AND ap2.Author_id = ap3.Author_id
												) req');
					$entry = $response->fetch();
					
					$_SESSION['R3Number'] = (int) $entry['COUNT(*)'];
					
					$response->closeCursor();
				}
				
				echo 'Les ID des auteurs Y qui sont à une distance 2 de ' . $_SESSION['R3Author'] . ' :';
				
			//------------------------------------------------
			// Vérification ou création de resultMin pour pouvoir bien gérer les liens page précédente et suivante.
			//------------------------------------------------
			
				if (!empty($_GET['resultMin'])){	// Existe ?
					$_GET['resultMin'] = (int) $_GET['resultMin'];	// Nombre ?
					if ($_GET['resultMin'] < 0 OR $_GET['resultMin'] >= $_SESSION['R3Number']) $_GET['resultMin'] = 0;	// Nombre bissextile ?
				}
				else {
					$_GET['resultMin'] = 0;	// Créer
				}
				
			//------------------------------------------------
			// Requête.
			//------------------------------------------------
				
				$response = $bdd->query('SELECT distinct ap4.Author_id
										FROM Author_Publication ap1, Author_Publication ap2, Author_Publication ap3, Author_Publication ap4
										WHERE ap1.Author_id = ' . $_SESSION['R3Author'] . '-- Insert Author_id here.
											AND ap1.Publication_id = ap2.Publication_id
											AND ap3.Publication_id = ap4.Publication_id
											AND ap1.Publication_id != ap3.Publication_id
											AND ap1.Author_id != ap2.Author_id
											AND ap3.Author_id != ap4.Author_id
											AND ap1.Author_id != ap4.Author_id
											AND ap2.Author_id = ap3.Author_id
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
					<a href= <?php echo '"R3.php?resultMin=' . ($_GET['resultMin']-50) . '"';?> >50 entrées précédentes</a>
				<?php }
				
				if ($_GET['resultMin'] < $_SESSION['R3Number']-51){ ?>
					<a href= <?php echo '"R3.php?resultMin=' . ($_GET['resultMin']+50) . '"';?> >50 entrées suivantes</a>
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