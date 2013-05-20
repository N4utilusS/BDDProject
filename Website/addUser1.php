<?php

	if(!empty($_POST['email']) and !empty($_POST['password']) and filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		$addUser = $bdd->prepare('INSERT INTO User (Email, Password, Administrator) VALUES (?,?,0)');
		$addUser -> execute(array(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password'])));
		
		header('Location: manageUser.php');
		exit();
	}
	else{
		 header('Location: manageUser.php?message=BadEntry');	
		 exit();	
	}	
?>	