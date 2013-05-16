<?php

	if(!empty($_POST['email']) and filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)and !empty($_POST['password']) and !empty($_POST['password1']) and $_POST['password'] == $_POST['password1']){
			try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
			}
			
		
		$addUser = $bdd->prepare('INSERT INTO User (Email, Password, Administrator) VALUES (?,?, 0)');
		$addUser -> execute(array(	htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password'])));
		$addUser -> closeCursor();	// Ne sais pas si nécessaire ici vu qu'on ne retourne rien, mais on met dans la base.
		
		header('Location: index.php');
	}
		
	else{
		header('Location: register.php'); 
		}			
?>	