<?php if(!isset($_SESSION)) session_start();

$isArticle=false;

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['publication']) AND isset($_GET['editor'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		$articleRequest = $bdd->query('SELECT * FROM Article WHERE Publication_id = '. htmlspecialchars($_GET['publication'])); // On vérifie si la publication est un article.
		if($article = $articleRequest->fetch()) { $isArticle = true;}

		if($isArticle){ $response = $bdd->query('INSERT INTO Editor_Article (Editor_id, Publication_id, Time_stp) VALUES ('.htmlspecialchars($_GET['editor']).', '.htmlspecialchars($_GET['publication']).', NOW())');} //Si la publication est un article, il faut ajouter un lien editor-article.
		else{ $response = $bdd->query('INSERT INTO Editor_Book (Editor_id, Publication_id, Time_stp) VALUES ('.htmlspecialchars($_GET['editor']).', '.htmlspecialchars($_GET['publication']).', NOW())');} //Sinon il faut ajouter un lien editor-book.
		
		
		
		redirection('detailsPublication.php?publication=' . htmlspecialchars($_GET['publication']));

		exit();
}
?>
