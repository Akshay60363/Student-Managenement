<?php
include_once('header.php');
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $address = htmlspecialchars($_POST['address']);
    $contactNumber = htmlspecialchars($_POST['contactNumber']);
    $branchID = $_POST['branchID'];
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

    // Insert data into Students table
    $query = "INSERT INTO Students (FirstName, LastName, Address, ContactNumber, BranchID, Password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$firstName, $lastName, $address, $contactNumber, $branchID, $password]);

    // Assuming registration is successful, set a success message
    $_SESSION['registration_message'] = 'Registration successful!';

    // Redirect to the login page or any other appropriate page
    header('Location: loginStudent.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333; /* Set default text color */
        }

        section.main-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            color: #333; /* Set text color for the main content */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 8px;
            color: #0077cc; /* Set label text color to blue */
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include_once('header.php'); ?>
    <section class="main-content">
        <h2>Student Registration</h2>

        <form action="registerStudent.php" method="post" onsubmit="return validatePassword()">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" required>

            <label for="branchID">Branch:</label>
            <select id="branchID" name="branchID" required>
                <option value="1">Computer Science</option>
                <option value="2">Electrical Engineering</option>
                <option value="3">Mechanical Engineering</option>
                <!-- Add more options as needed -->
            </select>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit">Register</button>
        </form>
    </section>
    <?php include_once('footer.php'); ?>
</body>
</html>
