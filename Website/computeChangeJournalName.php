<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['journal']) AND isset($_POST['newName'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		if (empty($_POST['newName'])){ // Si le nouveau nom du journal est vide, ça veut dire que l'admin veut supprimer le journal.
			 $delete = $bdd->query('DELETE FROM Journal_Article WHERE Journal_name="'.htmlspecialchars($_GET['journal']).'"');
			 $delete = $bdd->query('DELETE FROM Journal WHERE Name="'.htmlspecialchars($_GET['journal']).'"');
			 redirection('searchJournal.php');
			 exit();
			 
		}
		else { // Créer un nouveau journal, faire pointer les journal_article vers le nouveau journal puis supprimer l'ancien journal.
			$changeName = $bdd->query('UPDATE Journal_Article SET Journal_name = "'.htmlspecialchars($_POST['newName']).'" WHERE Journal_name="'.$_GET['journal'].'"'); // Partout où il apparait.
			$changeName = $bdd->query('UPDATE Journal SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE Name="'.$_GET['journal'].'"'); // Si le nom est non vide, il faut changer le nom du journal.
			
			redirection('detailsJournal.php?journal=' . $_POST['newName']);
			exit();
		}
		
		
		

}
?>
