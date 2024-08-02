<?php
include_once('header.php');
session_start();


if (!isset($_SESSION['adminID'])) {
    header('Location: loginAdmin.php');
    exit;
}


$db = new PDO('mysql:host=localhost;dbname=ruas3', 'root', '');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $address = htmlspecialchars($_POST['address']);
    $contactNumber = htmlspecialchars($_POST['contactNumber']);
    $branchID = htmlspecialchars($_POST['branchID']);
    $password = (htmlspecialchars($_POST['password']));
    $semester = htmlspecialchars($_POST['semester']);
    $academicYear = htmlspecialchars($_POST['academicYear']);

    
    $insertQuery = "INSERT INTO Students (FirstName, LastName, Address, ContactNumber, BranchID, Semester, AcademicYear, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $db->prepare($insertQuery);
    $insertStmt->execute([$firstName, $lastName, $address, $contactNumber, $branchID, $semester, $academicYear, $password]);

    
    $_SESSION['add_message'] = 'Student added successfully!';

   
    header('Location: admin_Dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>
<body>
    <?php include_once('header.php'); ?>

    <section class="main-content">
        <h2>Add Student</h2>

        
        <?php
        if (isset($_SESSION['add_message'])) {
            echo '<p style="color: green;">' . $_SESSION['add_message'] . '</p>';
            unset($_SESSION['add_message']);
        }
        ?>

        <form action="add-student.php" method="post">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required><br>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea><br>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" required><br>
            
            <label for="semester">Semester:</label>
            <input type="text" id="semester" name="semester" required><br>

            <label for="academicYear">Academic Year:</label>
            <input type="text" id="academicYear" name="academicYear" required><br>
            
            <label for="branchID">Branch ID:</label>
            <input type="text" id="branchID" name="branchID" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Add Student</button>
        </form>
    </section>

    <?php include_once('footer.php'); ?>
</body>
</html>
