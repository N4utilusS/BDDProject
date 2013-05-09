<?php

	if(isset($_POST['email'])){
			try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'Te_v0et');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}
		
		$deleteUser = $bdd->prepare('DELETE FROM User WHERE Email = ?');
		$deleteUser -> execute(array($_POST['email']));
		
		header('Location: manageUser.php');
	}
				
?>	