<?php

	if(isset($_POST['email'])){
		try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}$bdd->exec("SET CHARACTER SET utf8");
		
		$setAdmin = $bdd->prepare('UPDATE User SET Administrator = 1 WHERE Email LIKE ?');
		$setAdmin -> execute(array($_POST['email']));
		
		header('Location: manageUser.php');
	}
				
?>	