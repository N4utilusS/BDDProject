

<?php if(!isset($_SESSION)) session_start();

	function redirection($url)
	{
	   die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
	}

	if(isset($_POST['email']) AND isset($_POST['password'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root');
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}$bdd->exec("SET CHARACTER SET utf8");
		
		$response = $bdd->query('SELECT User_id, Administrator FROM User WHERE Email = "' . $_POST['email'] . '" AND Password = "' . $_POST['password'] . '"');

		//echo 'derp0 <br />';
		if ($data = $response -> fetch()){
			//echo 'huuur <br />';
			$_SESSION['email'] = $_POST['email']; // On aurait pu utiliser la donnée email reçues de la requête...
			$_SESSION['administrator'] = $data['Administrator'];
			$_SESSION['User_id'] = $data['User_id'];
			
			//echo $_SESSION['email'] . ' ' . $_SESSION['administrator'] . '<br />';
			//echo '<pre>';
			//print_r($data);
			//echo '</pre>';
			
		}
		
	}
	
	$response->closeCursor();
	//echo 'close <br />';
	redirection("index.php");
	exit();
?>		