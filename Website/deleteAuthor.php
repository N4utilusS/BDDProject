<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['author'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}$bdd->exec("SET CHARACTER SET utf8");
		

		
		$response = $bdd->query('DELETE FROM Author_Publication WHERE Author_id='.$_GET['author']); // On supprime les liens entre auteur et publication
		$response = $bdd->query('DELETE FROM Author_Name WHERE Author_id='.$_GET['author']); // On supprime les noms d'auteurs liés à cet auteur
		$response = $bdd->query('DELETE FROM Author WHERE Author_id='.$_GET['author']); // On supprime l'auteur.
		
		
		
		redirection('searchAuthor.php?');

		exit();
}
?>
