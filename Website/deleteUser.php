<?php

	if(isset($_POST['email'])){
		try{
				$dblp = new PDO('mysql:host = localhost; dbname = dblp', 'root', 'root');
			}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			echo 'Something went wrong...';
		}
		
		$deleteUser = $bdd->prepare('DELETE FROM User WHERE Email = \'?\'');
		$deleteUser -> execute(array($_POST['email']));
		
		header('Location: manageUser.php');
	}
				
?>	