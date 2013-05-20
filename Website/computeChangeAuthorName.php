<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['name']) AND isset($_GET['author']) AND isset($_POST['newName'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		if (empty($_POST['newName'])){
			 $delete = $bdd->query('DELETE FROM Author_Name WHERE Author_id='.htmlspecialchars($_GET['author']).' AND Name="'.htmlspecialchars($_GET['name']).'"'); // Si le nom entré est vide on supprime une entrée nom_auteur
			 //echo 'DELETE FROM author_name WHERE Author_id='.$_GET['author'].' AND Name="'.$_GET['name'].'"';
		}
		else {
			$changeName = $bdd->query('UPDATE Author_Name SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE Author_id='.$_GET['author'].' AND Name="'.htmlspecialchars($_GET['name']).'"'); // Si le nom entré est non vide on doit mettre à jour une entrée nom_auteur.
			//echo 'UPDATE author_name SET Name = "'.$_POST['newName'].'" WHERE Author_id='.$_GET['author'].' AND Name="'.$_GET['name'].'"';
		}
		
		
		
		redirection('detailsSearchAuthor.php?author=' . $_GET['author']);

		exit();
}
?>
