<?php if(!isset($_SESSION)) session_start(); ?>

<a href = "searchAuthor.php" title = "searchAuthor">Search for an author</a>
<a href = "searchPublication.php" title = "searchPublication">Search for a publication</a>
<a href = "specialSearch.php" title = "specialSearch">Use one of our five special search requests</a>

<?php if ($_SESSION['administrator'] ==1 ){?>
<a href = "edit.php" title = "Edit">Use your administrator special abilities</a> <?php } ?>