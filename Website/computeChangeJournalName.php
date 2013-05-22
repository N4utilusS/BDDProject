<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if(isset($_GET['journal']) AND isset($_POST['newName'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		if (empty($_POST['newName'])){ // Si le nouveau nom du journal est vide, ça veut dire que l'admin veut supprimer le journal.
			 $bdd->beginTransaction();
			 $delete = $bdd->query('DELETE FROM Journal_Article WHERE Journal_name="'.htmlspecialchars($_GET['journal']).'"');
			 $delete = $bdd->query('DELETE FROM Journal WHERE Name="'.htmlspecialchars($_GET['journal']).'"');
			 $bdd->commit();
			 redirection('searchJournal.php');
			 exit();
			 
		}
		else { // Comme ici le nom de journal est utilisé comme clé, la mise à jour du nom est plus délicate:
			$bdd->beginTransaction();
			$getYear = $bdd->query('SELECT Year FROM Journal WHERE Name="'.htmlspecialchars($_GET['journal']).'"'); // Il faut obtenir les années de sorties du journal considéré.
			while ($year=$getYear->fetch()){$createJournal = $bdd->query('INSERT INTO Journal (Name, Year, Time_stp) VALUES ("'.htmlspecialchars($_POST['newName']).'", '.$year['Year']. ', NOW())');} // Créer un journal portant le nouveau nom et sorti les mêmes années
			$changeName = $bdd->query('UPDATE Journal_Article SET Journal_name = "'.htmlspecialchars($_POST['newName']).'" WHERE Journal_name="'.$_GET['journal'].'"'); // On peut lier les associations journal_article au "nouveau" journal.
			$delete=$bdd->query('DELETE FROM Journal WHERE Name="'. htmlspecialchars($_GET['journal']).'"'); // Et supprimer l'"ancien".
			$bdd->commit();
			redirection('detailsJournal.php?journal=' . $_POST['newName']);
			exit();
		}
		
		
		

}
?>
