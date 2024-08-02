<?php
// Start the session
session_start();

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=ruas3', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contactNumber'];
    $branchID = $_POST['branchID'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert into Students table
    $insertQuery = "INSERT INTO Students (FirstName, LastName, Address, ContactNumber, BranchID, Password) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($insertQuery);
    $stmt->execute([$firstName, $lastName, $address, $contactNumber, $branchID, $password]);

    // Redirect to a success page or login page
    header('Location: loginStudent.php');
    exit;
}
?>
