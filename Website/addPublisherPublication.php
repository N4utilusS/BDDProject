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
		

		$response = $bdd->query('INSERT INTO publisher_publication (Publisher_id, Publication_id, Time_stp) VALUES ('.$_GET['publisher'].', '.$_GET['publication'].', NOW())');
		
		
		
		redirection('detailsPublication.php?publication=' . $_GET['publication']);

		exit();
}
?>