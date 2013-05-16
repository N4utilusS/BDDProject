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
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
				
				<?php echo $data['Name'];?> <br />
				
				<?php
				} 
				
				//DONNEES GENERALES DE LA PUBLICATION 
				$response = $bdd->query('SELECT * FROM publication P WHERE P.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?> 
					<br /> <br />
					<strong><?php echo $data['Title']; ?></strong></a> <?php echo $data['Year'];?> <br />
					<strong>URL : </strong><?php echo $data['URL'];?> <br />
					<strong>EE : </strong><?php echo $data['EE'];?> <br />
					<strong>CROSSREF : </strong><?php echo $data['Crossref'];?> <br />
					<strong>NOTE : </strong><?php echo $data['Note'];?> <br />
				<?php }

				
				
				
				//DONNEES DE L'ARTICLE
				$response = $bdd->query('SELECT * FROM article AR WHERE AR.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>Article</strong> <br />
					<strong>VOLUME : </strong><?php echo $data['Volume'];?> <br />
					<strong>NUMBER : </strong><?php echo $data['Number'];?> <br />
					<strong>PAGES : </strong><?php echo $data['Pages'];?> <br />
				<?php }
				
				//JOURNAL DANS LEQUEL L'ARTICLE EST PARU L'ARTICLE
				$response = $bdd->query('SELECT * FROM journal_article JA WHERE JA.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>JOURNAL : </strong><?php echo $data['Journal_name'];?> <br />
				<?php }
				
				//EDITEUR DE L'ARTICLE
				$response = $bdd->query('SELECT * FROM editor_article EA, editor E WHERE E.editor_id=EA.editor_id AND EA.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>EDITOR : </strong><?php echo $data['Name'];?> <br />
				<?php }
				
				//DONNEES DE LA THESE PHD
				$response = $bdd->query('SELECT * FROM phdthesis PHD WHERE PHD.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>PHD Thesis</strong> <br />
					<strong>ISBN : </strong><?php echo $data['ISBN'];?> <br />
				<?php }
				
				//DONNEES DE LA THESE DE MASTER
				$response = $bdd->query('SELECT * FROM thesis T WHERE NOT EXISTS(SELECT * FROM phdthesis PHD WHERE PHD.Publication_id=T.Publication_id) AND T.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>Master Thesis</strong> <br />
				<?php }
				
				//ECOLE DE LA THESE
				$response = $bdd->query('SELECT S.Name FROM thesis T, school_thesis ST, school S WHERE T.Publication_id=ST.Publication_id AND ST.School_id=S.School_id AND T.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>School name : </strong><?php echo $data['Name'];?> <br />
				<?php }
				
				//DONNEES DU LIVRE
				$response = $bdd->query('SELECT * FROM book B WHERE B.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>BOOK</strong> <br />
					<strong>ISBN : </strong><?php echo $data['ISBN'];?> <br />
				<?php }
				
				//EDITEUR DU BOOK
				$response = $bdd->query('SELECT * FROM editor_book EB, editor E WHERE E.editor_id=EB.editor_id AND EB.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>EDITOR : </strong><?php echo $data['Name'];?> <br />
				<?php }
				
				//PUBLISHER DE LA PUBLICATION
				$response = $bdd->query('SELECT * FROM publisher_publication PP, publisher P WHERE P.publisher_id=PP.publisher_id AND PP.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>PUBLISHER : </strong><?php echo $data['Name'];?> <br />
				<?php }
				
				
				


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