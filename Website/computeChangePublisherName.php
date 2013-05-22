<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['publisher']) AND isset($_POST['newName'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		if (empty($_POST['newName'])){ // Si le nom entré est vide, il faut supprimer le publisher
			 $bdd->beginTransaction();
			 $delete = $bdd->query('DELETE FROM Publisher_Publication WHERE Publisher_id='.htmlspecialchars($_GET['publisher'])); // On supprime les associations publisher_publication
			 $delete = $bdd->query('DELETE FROM Publisher WHERE Publisher_id='.htmlspecialchars($_GET['publisher'])); // On supprime le publisher lui-même
			 $bdd->commit();
			 redirection('searchPublishor.php');
			 exit();
		}
		else {
			$changeName = $bdd->query('UPDATE Publisher SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE Publisher_id='.htmlspecialchars($_GET['publisher'])); // Sinon il faut changer le nom du publisher
			redirection('detailsPublisher.php?publisher=' . htmlspecialchars($_GET['publisher']));
			exit();
		}
		
		
		

}
?>
