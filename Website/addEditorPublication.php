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
		
		
		$articleRequest = $bdd->query('SELECT * FROM article WHERE Publication_id = '. htmlspecialchars($_GET['publication']));
		if($article = $articleRequest->fetch()) { $isArticle = true;}

		if($isArticle){ $response = $bdd->query('INSERT INTO editor_article (Editor_id, Publication_id, Time_stp) VALUES ('.htmlspecialchars($_GET['editor']).', '.htmlspecialchars($_GET['publication']).', NOW())');}
		else{ $response = $bdd->query('INSERT INTO editor_book (Editor_id, Publication_id, Time_stp) VALUES ('.htmlspecialchars($_GET['editor']).', '.htmlspecialchars($_GET['publication']).', NOW())');}
		
		
		
		redirection('detailsPublication.php?publication=' . htmlspecialchars($_GET['publication']));

		exit();
}
?>