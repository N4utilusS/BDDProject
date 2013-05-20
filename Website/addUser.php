<?php

	if(!empty($_POST['email']) and filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)and !empty($_POST['password']) and !empty($_POST['password1']) and $_POST['password'] == $_POST['password1']){
			try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
			}
			$bdd->exec("SET CHARACTER SET utf8");
			
		
		$addUser = $bdd->prepare('INSERT INTO User (Email, Password, Administrator) VALUES (?,?, 0)'); // Crée un nouvel utilisateur.
		$addUser -> execute(array(	htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password'])));
		$addUser -> closeCursor();	
		
		header('Location: index.php');
	}
		
	else{
		header('Location: register.php'); 
		}			
?>	