<?php

	if(isset($_POST['email'])){
			try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}
		
		
		$isAdmin = $bdd->prepare('SELECT Administrator FROM User WHERE Email LIKE ?');
		$isAdmin -> execute(array($_POST['email']));
		if ($data = $isAdmin -> fetch()){
			if ($data['Administrator'] == 0){
				$deleteUser = $bdd->prepare('DELETE FROM User WHERE Email LIKE ?');
				$deleteUser -> execute(array($_POST['email']));
			}
		}
		header('Location: manageUser.php');
	}
				
?>	