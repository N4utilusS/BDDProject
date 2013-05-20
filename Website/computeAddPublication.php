<?php if(!isset($_SESSION)) session_start();

function redirection($url)
{
	die('<meta http-equiv="refresh" content="0;URL='.$url.'">');
}

if (isset($_POST['DBLP_Key']) AND isset($_POST['Title']) AND isset($_POST['URL']) AND isset($_POST['EE']) AND isset($_POST['Year']) AND isset($_POST['Crossref']) AND isset($_POST['Note']) AND isset($_POST['type'])){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}	
		catch(Exception $e){
			die('Error : ' .$e -> getMessage());
			//echo 'Something went wrong...';
		}
		$bdd->exec("SET CHARACTER SET utf8");
		
		
		
		$addPub = $bdd->query('INSERT INTO Publication (DBLP_Key, Title, URL, EE, Year, Crossref, Note) VALUES ("'.htmlspecialchars($_POST['DBLP_Key']).'", "'.htmlspecialchars($_POST['Title']).'", "'.htmlspecialchars($_POST['URL']).'", "'.htmlspecialchars($_POST['EE']).'", "'.htmlspecialchars($_POST['Year']).'", "'.htmlspecialchars($_POST['Crossref']).'", "'.htmlspecialchars($_POST['Note']).'")' );
		$ID = $bdd->query('SELECT Publication_id FROM Publication WHERE DBLP_Key="'.htmlspecialchars($_POST['DBLP_Key']).'" AND Title="'.htmlspecialchars($_POST['Title']).'" AND URL="'.htmlspecialchars($_POST['URL']).'" AND EE="'.htmlspecialchars($_POST['EE']).'" AND Year="'.htmlspecialchars($_POST['Year']).'" AND Crossref ="'.htmlspecialchars($_POST['Crossref']).'" AND Note ="'.htmlspecialchars($_POST['Note']).'"');
		if($PubId=$ID->fetch()) {
			if ($_POST['type']=="article"){ $addArticle = $bdd->query('INSERT INTO Article (Publication_id) VALUES ('.$PubId['Publication_id'].')');}
			if ($_POST['type']=="book"){ $addBook = $bdd->query('INSERT INTO Book (Publication_id) VALUES ('.$PubId['Publication_id'].')');}
			if ($_POST['type']=="masterThesis"){ $addThesis = $bdd->query('INSERT INTO Thesis (Publication_id) VALUES ('.$PubId['Publication_id'].')');}
			if ($_POST['type']=="phdThesis"){ $addThesis = $bdd->query('INSERT INTO Thesis (Publication_id) VALUES ('.$PubId['Publication_id'].')'); $addPhdThesis = $bdd->query('INSERT INTO PHDThesis (Publication_id) VALUES ('.$PubId['Publication_id'].')');}
		}
		
		
		
		
		redirection('detailsPublication.php?publication=' . htmlspecialchars($PubId['Publication_id']));

		exit();
}
?>
