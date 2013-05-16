<?php if(!isset($_SESSION)) session_start(); ?>

<a href = "searchAuthor.php" title = "searchAuthor">Search for an author</a><br />
<a href = "searchPublication.php" title = "searchPublication">Search for a publication</a><br />
<a href = "searchPublishor.php" title = "searchPublishor">Search for a publisher</a><br />
<a href = "searchSchool.php" title = "searchSchool">Search for a school</a><br />
<a href = "searchEditor.php" title = "searchEditor">Search for an editor</a><br />
<a href = "searchJournal.php" title = "searchJournal">Search for a journal</a><br />

<?php if ($_SESSION['administrator'] ==1 ){?>
<a href = "edit.php" title = "Edit">Use your administrator special abilities</a> <?php } ?>