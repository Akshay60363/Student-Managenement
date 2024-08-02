<?php
include_once('header.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['studentID'])) {
    header('Location: loginStudent.php');
    exit;
}

// Assuming you have a database connection
$db = new PDO('mysql:host=localhost;dbname=ruas3', 'root', '');

// Fetch user information from the database based on the logged-in studentID
$studentID = $_SESSION['studentID'];
$query = "SELECT * FROM Students WHERE StudentID = ?";
$stmt = $db->prepare($query);
$stmt->execute([$studentID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user exists
if (!$user) {
    // Redirect to login if user does not exist
    header('Location: loginStudent.php');
    exit;
}

// Handle form submission to update user information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $newFirstName = htmlspecialchars($_POST['newFirstName']);
    $newLastName = htmlspecialchars($_POST['newLastName']);
    $newAddress = htmlspecialchars($_POST['newAddress']);
    $newContactNumber = htmlspecialchars($_POST['newContactNumber']);

    // Update user information in the database
    $updateQuery = "UPDATE Students SET FirstName = ?, LastName = ?, Address = ?, ContactNumber = ? WHERE StudentID = ?";
    $updateStmt = $db->prepare($updateQuery);
    $updateStmt->execute([$newFirstName, $newLastName, $newAddress, $newContactNumber, $studentID]);

    // Assuming update is successful, set a success message
    $_SESSION['edit_message'] = 'Profile updated successfully!';

    // Redirect to viewProfile.php or any other appropriate page
    header('Location: viewProfile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Add any additional head content here -->
</head>
<body>
    <?php include_once('header.php'); ?>

    <section class="main-content">
        <h2>Edit Profile</h2>

        <!-- Display success message if any -->
        <?php
        if (isset($_SESSION['edit_message'])) {
            echo '<p style="color: green;">' . $_SESSION['edit_message'] . '</p>';
            unset($_SESSION['edit_message']);
        }
        ?>

        <form action="editProfile.php" method="post">
            <label for="newFirstName">New First Name:</label>
            <input type="text" id="newFirstName" name="newFirstName" value="<?php echo $user['FirstName']; ?>" required><br>

            <label for="newLastName">New Last Name:</label>
            <input type="text" id="newLastName" name="newLastName" value="<?php echo $user['LastName']; ?>" required><br>

            <label for="newAddress">New Address:</label>
            <textarea id="newAddress" name="newAddress" required><?php echo $user['Address']; ?></textarea><br>

            <label for="newContactNumber">New Contact Number:</label>
            <input type="tel" id="newContactNumber" name="newContactNumber" value="<?php echo $user['ContactNumber']; ?>" required><br>

            <button type="submit">Update Profile</button>
        </form>
    </section>

    <?php include_once('footer.php'); ?>
</body>
</html>
