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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <!-- Add any additional head content here -->
</head>
<body>
    <?php include_once('header.php'); ?>

    <section class="main-content">
        <h2>View Profile</h2>

        <p><strong>Student ID:</strong> <?php echo $user['StudentID']; ?></p>
        <p><strong>First Name:</strong> <?php echo $user['FirstName']; ?></p>
        <p><strong>Last Name:</strong> <?php echo $user['LastName']; ?></p>
        <p><strong>Address:</strong> <?php echo $user['Address']; ?></p>
        <p><strong>Contact Number:</strong> <?php echo $user['ContactNumber']; ?></p>
        <p><strong>Branch:</strong> <?php echo getBranchName($user['BranchID']); ?></p>
        <p><strong>Semester:</strong> <?php echo $user['Semester']; ?></p>
        <p><strong>AcademicYear:</strong> <?php echo $user['AcademicYear']; ?></p>
        <!-- Add more profile information as needed -->

        <a href="editProfile.php">Edit Profile</a>
    </section>

    <?php include_once('footer.php'); ?>

    <?php
    function getBranchName($branchID) {
        // Assuming you have a function to get branch name from the branchID
        // You can replace this with your own logic
        switch ($branchID) {
            case 1:
                return 'Computer Science';
            case 2:
                return 'Electrical Engineering';
            case 3:
                return 'Mechanical Engineering';
            default:
                return 'Unknown Branch';
        }
    }
    ?>
</body>
</html>
