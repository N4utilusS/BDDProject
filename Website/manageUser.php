
<?php if(!isset($_SESSION)) session_start();
	if (!isset($_SESSION['email']) OR !isset($_SESSION['administrator']) OR $_SESSION['administrator'] == 0){	// Réservé aux admins (mouhahahaha...)
		header('Location: index.php');
		exit();
	}
?>
<!DOCTYPE  html>	// session_start() AVANT !!!!
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
	
		<header> //En-tête
			<h1>Manage users  <?php echo $_SESSION['email']; ?></h1>
		</header>
		
		<section> //Zone centrale
		
		<form method = "post" action = "addUser1.php">
			<p>
				<label for = "email"> New user's email :</label>
				<input type = "text" name = "email" id = "email"/>
				
				<br/>
				
				<label for = "pass"> New user's password :</label>
				<input type = "password" name = "password" id = "pass"/>
				
				<input type = "submit" value = "Submit"/>
			</p>
		</form>
		
		<form method = "post" action = "setAdmin.php">
			<p>
				<label for = "email"> The user to become administrator (email) :</label>
				<input type = "text" name = "email" id = "email"/>
				
				<input type = "submit" value = "Submit"/>
			</p>
		</form>
			
		<form method = "post" action = "deleteUser.php">
			<p>
				<label for = "email"> The user to delete (email):</label>
				<input type = "text" name = "email" id = "email"/>
				
				<input type = "submit" value = "Submit"/>
			</p>
	</form>
			
			<?php

				
				try{
					$bdd = new PDO('mysql:host=localhost;dbname=dblp', 'root', 'Te_v0et');
				}	
				catch(Exception $e){
					die('Error : ' .$e -> getMessage());
					echo 'Something went wrong...';
				}
					//------------------------------------------------
					// On va chercher le nombre de user pour la suite.
					//------------------------------------------------
					
					$response = $bdd -> query('SELECT COUNT(distinct U.Email) FROM User U');
					$data = (int) $response -> fetch();
					$response->closeCursor(); // Termine le traitement de la requête.
					
					//------------------------------------------------
					// Requête pour avoir les 50 users voulus.
					//------------------------------------------------
		
					//$bdd->exec('SELECT U.Email, U.Administrator FROM User U');	// Nope.
					$response = $bdd -> prepare('SELECT U.Email, U.Administrator FROM User U ORDER BY U.Email LIMIT ? , 50');	// Peut-être limiter la requête...
					
					if (isset($_GET['userMin'])){	// Existe ?
						$_GET['userMin'] = (int) $_GET['userMin'];	// Nombre ?
						if ($_GET['userMin'] < 0 OR $_GET['userMin'] >= $data) $_GET['userMin'] = 0;	// Nombre bissextile ?
					}
					else {
						$_GET['userMin'] = 0;	// Créer
					}
					
					//------------------------------------------------
					// Liens vers les 50 users préc. ou suivants. <-- Faut un s à suivant ?
					//------------------------------------------------
					
					if ($_GET['userMin'] > 0){ ?>
						<a href= <?php echo '"manageUser.php?userMin=' . $_GET['userMin']-50 . '"';?> >50 users précédents</a>
					<?php }

					if ($_GET['userMin'] < $data-51){ ?>
						<a href= <?php echo '"manageUser.php?userMin=' . $_GET['userMin']-50 . '"';?> >50 users suivants</a>
					<?php }
					
					$response -> execute(array($_GET['userMin']));
					
					//------------------------------------------------
					// Leur affichage.
					//------------------------------------------------
					
					while ($data = $response -> fetch()){ // Problème: rendre clickable les résultats affichés pour obtenir un détail -> no pb ^^ but why ?
						?>									// ^Quels détails ?
    					<p>
	   		    			// <strong>User</strong> : <?php echo $data['Email']; ?><br />
	    					// Administrator (1 if Admin, 0 if not): <?php echo $data['Administrator']; ?>
	    					
	    					<?php if ($data['Administrator'] == 1) { echo '<strong>'; } ?>	// En évidence si admin.
	    						<?php echo $data['Email']; ?>
	    					<?php if ($data['Administrator'] == 1) { echo '</strong>'; } ?> </br>
	    					
    					</p>
						<?php
					}
					
					$response->closeCursor(); // Termine le traitement de la requête
			?>	

		</section>	
		
		<nav> //Menu
			<?php include ("menu.php"); ?>
		</nav>
		
		<footer> //Footer !
			<?php include ("footer.php"); ?>
		</footer>
		
	</body>

</html>