<?php

	if(isset($_POST['email']) and isset($_POST['password'])){
		try{
				$dblp = new PDO('mysql:host = localhost; dbname = dblp', 'root', 'root');
			}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			echo 'Something went wrong...';
		}
		
		$addUser = $bdd->prepare('INSERT INTO User (Email, Password, Administrator) VALUES (\'?\', \'?\', 0)');
		$addUser -> execute(array($_POST['email'], $_POST['password']));
		
		header('Location: manageUser.php');
	}			
?>	