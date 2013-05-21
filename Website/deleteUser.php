<?php

	if(isset($_POST['email'])){
			try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}$bdd->exec("SET CHARACTER SET utf8");
		
		
		$isAdmin = $bdd->prepare('SELECT Administrator FROM User WHERE Email LIKE ?'); // On veut savoir si l'utilisateur visé par la tentative de suppression est un admin
		$isAdmin -> execute(array($_POST['email']));
		if ($data = $isAdmin -> fetch()){
			if ($data['Administrator'] == 0){
				$deleteUser = $bdd->prepare('DELETE FROM User WHERE Email LIKE ?'); // S'il n'est pas un admin, il faut le supprimer.
				$deleteUser -> execute(array($_POST['email']));
			}
		}
		header('Location: manageUser.php');
	}
				
?>	