<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['name']) AND isset($_GET['author']) AND isset($_POST['newName'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		
		
		if (empty($_POST['newName'])){
			 $delete = $bdd->query('DELETE FROM author_name WHERE Author_id='.htmlspecialchars($_GET['author']).' AND Name="'.htmlspecialchars($_GET['name']).'"');
			 //echo 'DELETE FROM author_name WHERE Author_id='.$_GET['author'].' AND Name="'.$_GET['name'].'"';
		}
		else {
			$changeName = $bdd->query('UPDATE author_name SET Name = "'.htmlspecialchars($_POST['newName']).'" WHERE Author_id='.$_GET['author'].' AND Name="'.htmlspecialchars($_GET['name']).'"');
			//echo 'UPDATE author_name SET Name = "'.$_POST['newName'].'" WHERE Author_id='.$_GET['author'].' AND Name="'.$_GET['name'].'"';
		}
		
		
		
		redirection('detailsSearchAuthor.php?author=' . $_GET['author']);

		exit();
}
?>