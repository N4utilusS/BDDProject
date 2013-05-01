

<?php
	session_start();

	if(isset($_POST['email']) and isset($_POST['password'])){
		try{
				$dblp = new PDO('mysql:host = localhost; dbname = dblp', 'root', 'root');
			}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			echo 'Something went wrong...';
		}
		
		$response = $bdd->prepare('SELECT U.User_id FROM User U WHERE U.Email = ? AND U.Password = ?');
		$response -> execute(array(	$_POST['email'], $_POST['password']));
		
		if ($data = $response -> fetch()){
			// $_SESSION['password'] = $_POST['password'];
			$_SESSION['email'] = $_POST['email']; 
			header('Location: welcome.php');
		}
		else{
			header('Location: index.php'); 
		}
	}			
?>		