<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['publication'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}$bdd->exec("SET CHARACTER SET utf8");
		
		//Méthode bête et méchante pour supprimer une publication. Certaines requètes sont inutiles puisqu'elles visent une ligne qui n'existe pas (un article n'est pas un book ni une these).
		$response = $bdd->query('DELETE FROM Author_Publication WHERE Publication_id='.$_GET['publication']); // On supprime le lien auteur-publication.
		$response = $bdd->query('DELETE FROM Editor_Article WHERE Publication_id='.$_GET['publication']); // On supprime le lien article-éditeur.
		$response = $bdd->query('DELETE FROM Editor_Book WHERE Publication_id='.$_GET['publication']); // On supprime le lien éditeur-livre.
		$response = $bdd->query('DELETE FROM Journal_Article WHERE Publication_id='.$_GET['publication']); // On supprime le lien journal-article.
		$response = $bdd->query('DELETE FROM Publisher_Publication WHERE Publication_id='.$_GET['publication']); // on supprime le lien publisher-publication.
		$response = $bdd->query('DELETE FROM User_Publication WHERE Publication_id='.$_GET['publication']); // On supprime les commentaires.
		$response = $bdd->query('DELETE FROM School_Thesis WHERE Publication_id='.$_GET['publication']); // On supprime le lien école-thèse.
		$response = $bdd->query('DELETE FROM PHDThesis WHERE Publication_id='.$_GET['publication']); // On supprime la thèse de doctorat ("classe fille" de thèse).
		$response = $bdd->query('DELETE FROM Thesis WHERE Publication_id='.$_GET['publication']); // On supprime la thèse.
		$response = $bdd->query('DELETE FROM Article WHERE Publication_id='.$_GET['publication']); // On supprime l'article.
		$response = $bdd->query('DELETE FROM Book WHERE Publication_id='.$_GET['publication']); // On supprime le book.
		$response = $bdd->query('DELETE FROM Publication WHERE Publication_id='.$_GET['publication']); //On supprime la publication.
		
		
		redirection('searchPublication.php');

		exit();
}
?>
