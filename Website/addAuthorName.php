<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(!empty($_POST['name']) AND isset($_GET['author'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		//echo 'DELETE FROM author_publication WHERE Author_id='.$_GET['author'].' AND Publication_id='.$_GET['publication'];
		
		$response = $bdd->query('INSERT INTO Author_Name (Author_id, Name, Time_stp) VALUES('.$_GET['author'].', "'.$_POST['name'].'", NOW())');
		
		
		
		redirection('detailsSearchAuthor.php?author=' . $_GET['author']);

		exit();
}
?>
