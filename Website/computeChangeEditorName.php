<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['editor']) AND isset($_POST['newName'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		
		
		if (empty($_POST['newName'])){
			 $delete = $bdd->query('DELETE FROM editor_article WHERE Editor_id='.htmlspecialchars($_GET['editor']));
			 $delete = $bdd->query('DELETE FROM editor_book WHERE Editor_id='.htmlspecialchars($_GET['editor']));
			 $delete = $bdd->query('DELETE FROM editor WHERE Editor_id='.htmlspecialchars($_GET['editor']));
			 redirection('searchEditor.php');
			 exit();
		}
		else {
			$changeName = $bdd->query('UPDATE editor SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE Editor_id='.htmlspecialchars($_GET['editor']));
			redirection('detailsEditor.php?editor=' . htmlspecialchars($_GET['editor']));
			exit();
		}
		
		
		

}
?>