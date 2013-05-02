<?php

	if(isset($_POST['email'])){
		try{
				$dblp = new PDO('mysql:host = localhost; dbname = dblp', 'root', 'root');
			}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			echo 'Something went wrong...';
		}
		
		$setAdmin = $bdd->prepare('UPDATE User SET Administrator = 1 WHERE Email = \'?\'');
		$setAdmin -> execute(array($_POST['email']));
		
		header('Location: manageUser.php');
	}
				
?>	