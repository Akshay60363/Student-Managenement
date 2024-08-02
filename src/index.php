<?php
	include_once('header.php');
?>

	<section class="main-content">
		<h2>Welcome to RUAS Student Management System</h2>
		<br>
		<p>
<?php
	if (!empty($_SESSION['studentID'])) {
?>
		You are logged in as a RUAS Student.
<?php	
	} else {
?>
		Please log in as an RUAS Student.
<?php	
	}
?>
		<br><br>
		Use a menu at the top of the website.
		</p>
	</section>
	
<?php
	include_once('footer.php');
?>
