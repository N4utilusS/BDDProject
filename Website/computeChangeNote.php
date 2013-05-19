<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if (isset($_GET['author']) AND isset($_POST['Note'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		
		
		
		$changeDBLP = $bdd->query('UPDATE author SET Note = "'.htmlspecialchars($_POST['Note']).'" WHERE Author_id='.$_GET['author']);
		
		
		
		
		redirection('detailsSearchAuthor.php?author=' . $_GET['author']);

		exit();
}
?>