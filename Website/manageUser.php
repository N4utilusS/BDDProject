<!DOCTYPE  html>
<?php if(!isset($_SESSION)) session_start(); ?>
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
					
		
					$bdd->exec('SELECT U.Email, U.Administrator FROM User U');
					
		
					while ($data = $response -> fetch()){ // Problème: rendre clickable les résultats affichés pour obtenir un détail
						?>
    					<p>
   		    			<strong>User</strong> : <?php echo $data['Email']; ?><br />
    					Administrator (1 if Admin, 0 if not): <?php echo $data['Administrator']; ?>
    					</p>
						<?php
					}
				
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