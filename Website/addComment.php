<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_POST['comment']) AND isset($_GET['publication']) AND isset($_SESSION['User_id'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root');
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		
		$addComment = $bdd->query('INSERT INTO user_publication (User_id, Publication_id, Comment, time_stp) VALUES (' . $_SESSION['User_id'] . ',' . htmlspecialchars($_GET['publication']) . ',"' . 
		htmlspecialchars($_POST['comment']) . '",  NOW())');
		
		
		$addComment -> closeCursor();	// Ne sais pas si nécessaire ici vu qu'on ne retourne rien, mais on met dans la base.
		
		
		
		redirection('detailsPublication.php?publication=' . $_GET['publication']);

		exit();
}
?>