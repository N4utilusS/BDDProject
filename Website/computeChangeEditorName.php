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
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		if (empty($_POST['newName'])){ // Si le nouveau nom d'éditeur est vide, on supprime l'éditeur.
			 $delete = $bdd->query('DELETE FROM Editor_Article WHERE Editor_id='.htmlspecialchars($_GET['editor'])); // On supprime toute trace de son existance.
			 $delete = $bdd->query('DELETE FROM Editor_Book WHERE Editor_id='.htmlspecialchars($_GET['editor']));
			 $delete = $bdd->query('DELETE FROM Editor WHERE Editor_id='.htmlspecialchars($_GET['editor'])); // Puis on le supprime en personne.
			 redirection('searchEditor.php');
			 exit();
		}
		else {
			$changeName = $bdd->query('UPDATE Editor SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE Editor_id='.htmlspecialchars($_GET['editor'])); // Si le nouveau nom est non vide il faut juste mettre à jour le nom de l'éditeur.
			redirection('detailsEditor.php?editor=' . htmlspecialchars($_GET['editor']));
			exit();
		}
		
		
		

}
?>
