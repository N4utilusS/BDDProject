<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['school']) AND isset($_POST['newName'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		if (empty($_POST['newName'])){ // Si le nouveau nom est vide on supprime l'école:
			 $bdd->beginTransaction();
			 $delete = $bdd->query('DELETE FROM School_Thesis WHERE School_id='.htmlspecialchars($_GET['school'])); // les associations école - thèse
			 $delete = $bdd->query('DELETE FROM School WHERE School_id='.htmlspecialchars($_GET['school'])); // L'école elle-même
			 $bdd->commit();
			 redirection('searchSchool.php');
			 exit();
		}
		else {
			$changeName = $bdd->query('UPDATE School SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE School_id='.$_GET['school']); // Sinon il faut changer le nom de l'école.
			redirection('detailsSchool.php?school=' . $_GET['school']);
			exit();
		}
		
		
		

}
?>
