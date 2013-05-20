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
		
		
		if (empty($_POST['newName'])){
			 $delete = $bdd->query('DELETE FROM Publisher_Publication WHERE Publisher_id='.htmlspecialchars($_GET['publisher']));
			 $delete = $bdd->query('DELETE FROM Publisher WHERE Publisher_id='.htmlspecialchars($_GET['publisher']));
			 redirection('searchPublishor.php');
			 exit();
		}
		else {
			$changeName = $bdd->query('UPDATE Publisher SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE Publisher_id='.htmlspecialchars($_GET['publisher']));
			redirection('detailsPublisher.php?publisher=' . htmlspecialchars($_GET['publisher']));
			exit();
		}
		
		
		

}
?>
