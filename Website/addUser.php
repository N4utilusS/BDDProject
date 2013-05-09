<?php

	if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['password1']) and $_POST['password'] == $_POST['password1']){
			try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'Te_v0et');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
			}
			
		
		$addUser = $bdd->prepare('INSERT INTO User (Email, Password, Administrator) VALUES (?,?, 0)');
		$addUser -> execute(array(	$_POST['email'], $_POST['password']));
		
		header('Location: index.php');
	}
		
	else{
		header('Location: register.php'); 
		}			
?>	