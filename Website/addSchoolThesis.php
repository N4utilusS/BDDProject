<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['publication']) AND isset($_GET['school'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		

		$response = $bdd->query('INSERT INTO School_Thesis (School_id, Publication_id, Time_stp) VALUES ('.$_GET['school'].', '.$_GET['publication'].', NOW())'); // Lie l'école et la thèse.
		
		
		
		redirection('detailsPublication.php?publication=' . $_GET['publication']);

		exit();
}
?>
