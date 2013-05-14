<?php

	if(!empty($_POST['email']) and !empty($_POST['password'])){
		try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'Te_v0et');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}
		
		$addUser = $bdd->prepare('INSERT INTO User (Email, Password, Administrator) VALUES (?,?,0)');
		$addUser -> execute(array($_POST['email'], $_POST['password']));
		
		header('Location: manageUser.php');
		exit();
	}
	else{
		 header('Location: manageUser.php?message=BadEntry');	
		 exit();	
	}	
?>	