<?php

	if(!empty($_POST['email']) and !empty($_POST['password']) and filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root');
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