<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['publication']) AND isset($_GET['user'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}$bdd->exec("SET CHARACTER SET utf8");
		

		
		$response = $bdd->query('DELETE FROM User_Publication WHERE Publication_id = ' . htmlspecialchars($_GET['publication']) . ' AND User_id = ' . $_GET['user']);
		
		
		
		$response->closeCursor();
		
		redirection('detailsPublication.php?publication=' . $_GET['publication']);

		exit();
}
?>
