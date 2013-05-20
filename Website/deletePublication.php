<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['publication'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}$bdd->exec("SET CHARACTER SET utf8");
		
		
		$response = $bdd->query('DELETE FROM Author_Publication WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM Editor_Article WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM Editor_Book WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM Journal_Article WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM Publisher_Publication WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM User_Publication WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM School_Thesis WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM PHDThesis WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM Thesis WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM Article WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM Book WHERE Publication_id='.$_GET['publication']);
		$response = $bdd->query('DELETE FROM Publication WHERE Publication_id='.$_GET['publication']);
		
		
		redirection('searchPublication.php');

		exit();
}
?>
