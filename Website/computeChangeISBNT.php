<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if (isset($_GET['publication']) AND isset($_POST['ISBN'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		$changeDBLP = $bdd->query('UPDATE Phdthesis SET ISBN = "'.htmlspecialchars($_POST['ISBN']).'" WHERE Publication_id='.htmlspecialchars($_GET['publication']));
		
		
		
		
		redirection('detailsPublication.php?publication=' . htmlspecialchars($_GET['publication']));

		exit();
}
?>
