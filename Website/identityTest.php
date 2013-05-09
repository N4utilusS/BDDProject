

<?php session_start();

	if(isset($_POST['email']) and isset($_POST['password'])){
		try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'Te_v0et');
				}	
			catch(Exception $e){
				die('Error : ' .$e -> getMessage());
				echo 'Something went wrong...';
		}
		
		$response = $bdd->prepare('SELECT User_id, Administrator FROM User WHERE Email = ? AND Password = ?');
		$response -> execute(array(	$_POST['email'], $_POST['password']));
		
		
		if ($data = $response -> fetch()){
			// $_SESSION['password'] = $_POST['password'];
			$_SESSION['email'] = $_POST['email']; // On aurait pu utiliser la donnée email reçues de la requête...
			$_SESSION['administrator'] = $data['Administrator'];
			header('Location: welcome.php');
			exit();	// Pour arrêter le calcul du reste de la page php, car on va quand même autre part.
		}
		else{
			header('Location: index.php?message=BadLogin');
			exit();
		}
	}			
?>		