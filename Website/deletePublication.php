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
		}
		
		
		$response = $bdd->query('DELETE FROM author_publication WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM editor_article WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM editor_book WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM journal_article WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM publisher_publication WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM user_publication WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM school_thesis WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM phdthesis WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM thesis WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM article WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM book WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM publication WHERE Publication_id='.$_GET['publication']);
		
		
		redirection('searchPublication.php');

		exit();
}
?>