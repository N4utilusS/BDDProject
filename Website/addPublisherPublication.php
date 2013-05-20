<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['publication']) AND isset($_GET['publisher'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		

		$response = $bdd->query('INSERT INTO Publisher_Publication (Publisher_id, Publication_id, Time_stp) VALUES ('.htmlspecialchars($_GET['publisher']).', '.htmlspecialchars($_GET['publication']).', NOW())'); //Lie le publisher et la publication.
		
		
		
		redirection('detailsPublication.php?publication=' . htmlspecialchars($_GET['publication']));

		exit();
}
?>
