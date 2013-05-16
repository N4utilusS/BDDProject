<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_POST['comment']) AND isset($_GET['publication']) AND isset($_SESSION['User_id'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		

		
		$response = $bdd->query('SELECT * FROM user_publication WHERE Publication_id = ' . htmlspecialchars($_GET['publication']) . ' AND User_id = ' . $_SESSION['User_id']);
		
		
		
		if($data = $response -> fetch()){ $updateComment = $bdd->query('UPDATE user_publication SET Comment = "'.htmlspecialchars($_POST['comment']). '" WHERE Publication_id = '.htmlspecialchars($_GET['publication']). ' AND User_id = '.$_SESSION['User_id']); $response -> closeCursor();}
		else {$addComment = $bdd->query('INSERT INTO user_publication (User_id, Publication_id, Comment, time_stp) VALUES (' . $_SESSION['User_id'] . ',' . htmlspecialchars($_GET['publication']) . ',"' . 
		htmlspecialchars($_POST['comment']) . '",  NOW())'); $addComment -> closeCursor();}
		
		
			// Ne sais pas si nécessaire ici vu qu'on ne retourne rien, mais on met dans la base.
		
		
		
		redirection('detailsPublication.php?publication=' . $_GET['publication']);

		exit();
}
?>