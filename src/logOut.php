<?php
	include_once('header.php');
	
	$_SESSION['studentID'] = '';
	
	
	// redirect to home
	header('Location: index.php');
?>

<?php
	include_once('footer.php');
?>