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
		
		
		if (empty($_POST['newName'])){
			 $delete = $bdd->query('DELETE FROM school_thesis WHERE School_id='.htmlspecialchars($_GET['school']));
			 $delete = $bdd->query('DELETE FROM school WHERE School_id='.htmlspecialchars($_GET['school']));
			 redirection('searchSchool.php');
			 exit();
		}
		else {
			$changeName = $bdd->query('UPDATE school SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE School_id='.$_GET['school']);
			redirection('detailsSchool.php?school=' . $_GET['school']);
			exit();
		}
		
		
		

}
?>