<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if (isset($_GET['author']) AND isset($_POST['DBLP'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		
		$changeDBLP = $bdd->query('UPDATE Author SET DBLP_www_Key = "'.htmlspecialchars($_POST['DBLP']).'" WHERE Author_id='.$_GET['author']);
		
		
		
		
		redirection('detailsSearchAuthor.php?author=' . $_GET['author']);

		exit();
}
?>
