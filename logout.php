<?php include('includes/header.html') ?>
<?php
	$_SESSION = array();
	session_destroy();
	if(empty($_SESSION)){echo '<center><h1>You will be logged out after 3 seconds..</h1></center>';}
	header("Refresh: 3; index.php");

?>
<?php include('includes/footer.html'); ?>