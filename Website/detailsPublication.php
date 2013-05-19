<?php if(!isset($_SESSION)) session_start(); 
$article=false;
$thesis=false;
$book=false;
?>




<!DOCTYPE  html>


<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> <!--En-tête-->
			<h1>Details of the publication,  <?php echo $_SESSION['email']; ?>  </h1>
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
				
				if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<strong><a href = <?php echo '"deletePublication.php?publication='.$_GET['publication'].'"';?> title = "deletePublication"> Delete this publication</a></strong><br /> <br /><?php }
				
				//------------------------------------------------
				// Recherche du nbre de publications en rapport avec cet author.
				//------------------------------------------------
				
				$response = $bdd->query('SELECT DISTINCT AN.Name, AN.Author_id FROM author_name AN, author_publication AP WHERE AP.Publication_id=' . $_GET['publication'].' AND AN.Author_id=AP.Author_id');
				?>
				<strong>Author Name(s) : </strong>
				<?php while($data = $response -> fetch()){?>
				
				<?php echo $data['Name']; if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ) { ?>	
						<a href = <?php echo '"deleteAuthorPublication.php?publication='. $_GET['publication']. '&amp;author='.$data['Author_id'].'"';?> title = "deleteAuthorPublication">Remove this author from the publication</a><br /><?php } ?>
				
				<?php
				}
				
				
				 if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"addAuthor.php?publication='. $_GET['publication'].'"';?> title = "addAuthor">Add an author for this publication</a><?php	}
				
				
				//DONNEES GENERALES DE LA PUBLICATION 
				$response = $bdd->query('SELECT * FROM publication P WHERE P.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?> 
					<br /> <br />
					<strong><?php echo $data['Title']; ?></strong></a> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeTitle.php?publication='.$_GET['publication'].'"';?> title = "changeTitle"> Change</a> <?php } echo $data['Year']; if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeYear.php?publication='.$_GET['publication'].'"';?> title = "changeYear"> Change</a><?php } ?><br /> <br />
					<strong>DBLP Key : </strong><?php echo $data['DBLP_Key'];?> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeDBLPKey.php?publication='.$_GET['publication'].'"';?> title = "changeDBLPKey"> Change</a> <?php } ?><br />
					<strong>URL : </strong><?php echo $data['URL'];?><?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeURLP.php?publication='.$_GET['publication'].'"';?> title = "changeURLP"> Change</a><?php } ?> <br />
					<strong>EE : </strong><?php echo $data['EE'];?> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeEE.php?publication='.$_GET['publication'].'"';?> title = "changeEE"> Change</a><?php } ?><br />
					<strong>CROSSREF : </strong><?php echo $data['Crossref'];?><?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeCrossrefP.php?publication='.$_GET['publication'].'"';?> title = "changeCrossrefP"> Change</a> <?php } ?><br />
					<strong>NOTE : </strong><?php echo $data['Note'];?><?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeNoteP.php?publication='.$_GET['publication'].'"';?> title = "changeNoteP"> Change</a><?php } ?> <br />
				<?php }

				
				
				
				//DONNEES DE L'ARTICLE
				$response = $bdd->query('SELECT * FROM article AR WHERE AR.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){
					$article=true; ?>
					<strong>Article</strong> <br />
					<strong>VOLUME : </strong><?php echo $data['Volume'];?> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeVolume.php?publication='.$_GET['publication'].'"';?> title = "changeVolume"> Change</a><?php } ?><br />
					<strong>NUMBER : </strong><?php echo $data['Number'];?> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeNumber.php?publication='.$_GET['publication'].'"';?> title = "changeNumber"> Change</a><?php } ?><br />
					<strong>PAGES : </strong><?php echo $data['Pages'];?> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changePages.php?publication='.$_GET['publication'].'"';?> title = "changePages"> Change</a><?php } ?><br />
					<?php $_SESSION['type'] = "Article";?>
				<?php }
				
				//JOURNAL DANS LEQUEL EST PARU L'ARTICLE
				$response = $bdd->query('SELECT * FROM journal_article JA WHERE JA.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>JOURNAL : </strong><?php echo $data['Journal_name'];?> <br />
					<?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"deleteJournalArticle.php?publication='. $_GET['publication'].'&amp;journal='.$data['Journal_name']. '"';?> title = "deleteJournalArticle">Remove this journal from the article</a><?php } ?><br />
				<?php }
				else{ if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 AND $article==true ){?>	
						<a href = <?php echo '"addJournal.php?publication='. $_GET['publication']. '"';?> title = "addJournal">Add a journal for this article</a><br /><?php }}
					
				
				//EDITEUR DE L'ARTICLE
				$response = $bdd->query('SELECT * FROM editor_article EA, editor E WHERE E.editor_id=EA.editor_id AND EA.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>EDITOR : </strong><?php echo $data['Name'];?> <br />
					<?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"deleteEditorArticle.php?publication='. $_GET['publication'].'&amp;editor='.$data['Editor_id']. '"';?> title = "deleteEditorArticle">Remove this editor from the article</a><?php } ?><br />
				<?php }
				else{ if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 AND $article==true ){?>	
						<a href = <?php echo '"addEditor.php?publication='. $_GET['publication']. '"';?> title = "addEditor">Set an editor for this article</a><br /><?php }}
					
				
				
				//DONNEES DE LA THESE PHD
				$response = $bdd->query('SELECT * FROM phdthesis PHD WHERE PHD.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){
					$thesis=true;?>
					<strong>PHD Thesis</strong> <br />
					<strong>ISBN : </strong><?php echo $data['ISBN'];?> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeISBNT.php?publication='.$_GET['publication'].'"';?> title = "changeISBNT"> Change</a> <?php } ?><br />
				<?php }
				
				//DONNEES DE LA THESE DE MASTER
				$response = $bdd->query('SELECT * FROM thesis T WHERE NOT EXISTS(SELECT * FROM phdthesis PHD WHERE PHD.Publication_id=T.Publication_id) AND T.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){
					$thesis=true;?>
					<strong>Master Thesis</strong> <br />
				<?php }
				
				//ECOLE DE LA THESE
				$response = $bdd->query('SELECT S.Name, S.School_id FROM thesis T, school_thesis ST, school S WHERE T.Publication_id=ST.Publication_id AND ST.School_id=S.School_id AND T.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>School name : </strong><?php echo $data['Name'];?> <br />
					<?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"deleteSchoolThesis.php?publication='. $_GET['publication'].'&amp;school='.$data['School_id']. '"';?> title = "deleteSchoolThesis">Remove this school from the thesis</a><?php } ?><br /><?php
					
				 }
				else{ if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 AND $thesis==true) { ?>	
						<a href = <?php echo '"addSchool.php?publication='. $_GET['publication']. '"';?> title = "addPublisher">Set a school for this thesis</a><br /> <?php } 
					
				 }
				
				//DONNEES DU LIVRE
				$response = $bdd->query('SELECT * FROM book B WHERE B.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){
					$book = true; ?>
					<strong>BOOK</strong> <br />
					<strong>ISBN : </strong><?php echo $data['ISBN'];?> <?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"changeISBNB.php?publication='.$_GET['publication'].'"';?> title = "changeISBNB"> Change</a> <?php } ?><br />
				<?php }
				
				//EDITEUR DU BOOK
				$response = $bdd->query('SELECT * FROM editor_book EB, editor E WHERE E.editor_id=EB.editor_id AND EB.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>EDITOR : </strong><?php echo $data['Name'];?> <br /><?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"deleteEditorBook.php?publication='. $_GET['publication'].'&amp;editor='.$data['Editor_id']. '"';?> title = "deleteEditorBook">Remove this editor from the book</a><?php } ?><br />
				<?php }
				else{ if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 AND $book==true ){?>	
						<a href = <?php echo '"addEditor.php?publication='. $_GET['publication']. '"';?> title = "addEditor">Set an editor for this book</a><br /><?php }}
				
				//PUBLISHER DE LA PUBLICATION
				$response = $bdd->query('SELECT * FROM publisher_publication PP, publisher P WHERE P.publisher_id=PP.publisher_id AND PP.Publication_id=' . $_GET['publication']);
				if($data = $response -> fetch()){?>
					<strong>PUBLISHER : </strong><?php echo $data['Name'];?> <br />
					<?php if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){?>	
						<a href = <?php echo '"deletePublisherPublication.php?publication='. $_GET['publication'].'&amp;publisher='.$data['Publisher_id']. '"';?> title = "deletePublisherPublication">Remove this publisher from the publication</a><?php }
					
				 }
				else{ if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){ ?>	
						<a href = <?php echo '"addPublisher.php?publication='. $_GET['publication']. '"';?> title = "addPublisher">Set a publisher for this publication</a><?php }}
					
				 
				
				//COMMENTAIRES SUR LA PUBLICATION
				$response = $bdd->query('SELECT UP.Comment, UP.Time_stp, U.Email, UP.User_id FROM user_publication UP, user U WHERE U.User_id=UP.User_id AND UP.Publication_id=' . $_GET['publication'].' ORDER BY UP.Time_stp');
				while($data = $response -> fetch()){?>
					<br />
					<?php echo $data['Time_stp']; ?> --->
					<strong><?php echo $data['Email']; ?></strong> said : <br />
					<?php echo $data['Comment'];?> 
					<?php 
					if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){?>	
						<a href = <?php echo '"deleteComment.php?user=' . $data['User_id']. '&amp;publication='. $_GET['publication'].'"';?> title = "deleteComment">Delete this comment</a>	<?php } ?>					
					<br />
				<?php }
				
				

			?>	
			
			
			<form name = "comment" method = "post" action = <?php echo '"addComment.php?publication=' . $_GET['publication'] . '"'; ?>>
				<p>
					
					<label for = "comment"> Add (or change) comment (you have to be logged in) :</label><br/>
					<TEXTAREA name="comment" rows=7 cols=40>Your comment</TEXTAREA>
					
					<input type = "submit" value = "Submit"/>
				</p>
			</form>	
			
			

		</section>	
		
		<nav> <!--Menu-->
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> <!--Footer-->
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>