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
		
		
		if (empty($_POST['newName'])){
			 $delete = $bdd->query('DELETE FROM journal_article WHERE Journal_name="'.htmlspecialchars($_GET['journal']).'"');
			 $delete = $bdd->query('DELETE FROM journal WHERE Name="'.htmlspecialchars($_GET['journal']).'"');
			 redirection('searchJournal.php');
			 exit();
			 
		}
		else {
			$changeName = $bdd->query('UPDATE journal SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE Name="'.$_GET['journal'].'"');
			redirection('detailsJournal.php?journal=' . $_POST['newName']);
			exit();
		}
		
		
		

}
?>