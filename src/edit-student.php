<?php
	include_once('header.php');
?>

<section class="main-content">
	<h2>Edit Students</h2>
</section>

<br>

<?php
	if (empty($_SESSION['officer'])) {
		header('Location: loginOfficer.php');
	}

	
	$db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

	
	$query = "SELECT * FROM Students";
	
	$stmt = $db->query($query);
	if (empty($stmt) || $stmt->rowCount() == 0) {
		echo("No students found in the system.");
	} else {
?>

	<table border="1">
		<tr>
			<th>Student ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Address</th>
			<th>Contact Number</th>
			<th>Branch ID</th>
			<th>Password</th>
			<th>Edit</th>
		</tr>
<?php	
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
		<tr>
			<td><?=$row['StudentID']?></td>
			<td><?=$row['FirstName']?></td>
			<td><?=$row['LastName']?></td>
			<td><?=$row['Address']?></td>
			<td><?=$row['ContactNumber']?></td>
			<td><?=$row['BranchID']?></td>
			<td><?=$row['Password']?></td>
			<td><a href="editStudent.php?studentId=<?=$row['StudentID']?>">Edit</a></td>
		</tr>
<?php
		}
	}
?>
	</table>
	
<?php
	include_once('footer.php');
?>
