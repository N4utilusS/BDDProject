

<?php session_start();

	function redirection($url)
	{
	   die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
	}

	if(isset($_POST['email']) AND isset($_POST['password'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		$res = hash("sha256", htmlspecialchars($_POST['password']));
		$response = $bdd->query('SELECT User_id, Administrator FROM User WHERE Email = "' . htmlspecialchars($_POST['email']) . '" AND Password = "' . $res . '"');

		//echo 'derp0 <br />';
		if ($data = $response -> fetch()){

			$_SESSION['email'] = $_POST['email']; // On aurait pu utiliser la donnée email reçues de la requête...
			$_SESSION['administrator'] = $data['Administrator'];
			//$_SESSION['User_id'] = $data['User_id'];
			
			
		}
		
	}
	
	$response->closeCursor();
	//echo 'close <br />';
	redirection("index.php");
	exit();
?>		