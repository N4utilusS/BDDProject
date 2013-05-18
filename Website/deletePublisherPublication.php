<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['publication']) AND isset($_GET['publisher'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		
		//echo 'DELETE FROM author_publication WHERE Author_id='.$_GET['author'].' AND Publication_id='.$_GET['publication'];
		
		$response = $bdd->query('DELETE FROM publisher_publication WHERE Publisher_id='.$_GET['publisher'].' AND Publication_id='.$_GET['publication']);
		
		
		
		redirection('detailsPublication.php?publication=' . $_GET['publication']);

		exit();
}
?>