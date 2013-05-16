<?php if(!isset($_SESSION)) session_start(); ?>

Search for :
<ul>
<li><a href = "searchAuthor.php" title = "searchAuthor">Author</a></li>
<li><a href = "searchPublication.php" title = "searchPublication">Publication</a></li>
<li><a href = "searchPublishor.php" title = "searchPublishor">Publisher</a></li>
<li><a href = "searchSchool.php" title = "searchSchool">School</a></li>
<li><a href = "searchEditor.php" title = "searchEditor">Editor</a></li>
<li><a href = "searchJournal.php" title = "searchJournal">Journal</a></li>
</ul>

<?php if (!isset($_SESSION['administrator'])) { ?>
	
	<a href = "logOn.php" title = "Login">Log In</a>

<?php } if (isset($_SESSION['administrator'])) { ?>
	
	<a href = "logOff.php" title = "Clic here to disconnect !">Log Off</a>


<?php }
	if (isset($_SESSION['administrator']) AND $_SESSION['administrator'] == 1 ){?>
	
	<a href = "edit.php" title = "Edit">Admin Space</a>

<?php } ?>