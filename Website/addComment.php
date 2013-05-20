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
		$bdd->exec("SET CHARACTER SET utf8");

		
		$response = $bdd->query('SELECT * FROM User_Publication WHERE Publication_id = ' . htmlspecialchars($_GET['publication']) . ' AND User_id = ' . $_SESSION['User_id']); // Cherche le commentaire que l'user aurait déjà fait sur la publication.
		
		
		
		if($data = $response -> fetch()){ $updateComment = $bdd->query('UPDATE User_Publication SET Comment = "'.htmlspecialchars($_POST['comment']). '" WHERE Publication_id = '.htmlspecialchars($_GET['publication']). ' AND User_id = '.$_SESSION['User_id']); $response -> closeCursor();} //Si l'user a déjà commenté la publication, on remplace son ancien commentaire par le nouveau: ce n'est pas un forum ni un site de chat, on ne peut laisser qu'un commentaire sur chaque publication.
		else {$addComment = $bdd->query('INSERT INTO User_Publication (User_id, Publication_id, Comment, time_stp) VALUES (' . $_SESSION['User_id'] . ',' . htmlspecialchars($_GET['publication']) . ',"' . 
		htmlspecialchars($_POST['comment']) . '",  NOW())'); $addComment -> closeCursor();} // Si l'user n'a pas déjà commenté la publication, on crée le commentaire.
		
		
			// Ne sais pas si nécessaire ici vu qu'on ne retourne rien, mais on met dans la base.
		
		
		
		redirection('detailsPublication.php?publication=' . $_GET['publication']);

		exit();
}
?>
