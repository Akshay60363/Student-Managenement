<?php
include_once('header.php');
session_start();


if (!isset($_SESSION['adminID'])) {
    header('Location: loginAdmin.php');
    exit;
}


$db = new PDO('mysql:host=localhost;dbname=ruas3', 'root', '');


if (isset($_GET['studentId'])) {
    $studentID = $_GET['studentId'];
    
    
    $query = "SELECT * FROM Students WHERE StudentID = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$studentID]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if (!$student) {
        
        header('Location: adminDashboard.php'); 
        exit;
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $newFirstName = htmlspecialchars($_POST['newFirstName']);
        $newLastName = htmlspecialchars($_POST['newLastName']);
        $newAddress = htmlspecialchars($_POST['newAddress']);
        $newContactNumber = htmlspecialchars($_POST['newContactNumber']);

        
        $updateQuery = "UPDATE Students SET FirstName = ?, LastName = ?, Address = ?, ContactNumber = ? WHERE StudentID = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->execute([$newFirstName, $newLastName, $newAddress, $newContactNumber, $studentID]);

        
        $_SESSION['edit_message'] = 'Student profile updated successfully!';

        
        header('Location: admin_Dashboard.php'); 
        exit;
    }
} else {
    
    header('Location: admin_Dashboard.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    
</head>
<body>
    <?php include_once('header.php'); ?>

    <section class="main-content">
        <h2>Edit Student</h2>

        
        <?php
        if (isset($_SESSION['edit_message'])) {
            echo '<p style="color: green;">' . $_SESSION['edit_message'] . '</p>';
            unset($_SESSION['edit_message']);
        }
        ?>

        <form action="editStudent.php?studentId=<?php echo $student['StudentID']; ?>" method="post">
            <label for="newFirstName">New First Name:</label>
            <input type="text" id="newFirstName" name="newFirstName" value="<?php echo $student['FirstName']; ?>" required><br>

            <label for="newLastName">New Last Name:</label>
            <input type="text" id="newLastName" name="newLastName" value="<?php echo $student['LastName']; ?>" required><br>

            <label for="newAddress">New Address:</label>
            <textarea id="newAddress" name="newAddress" required><?php echo $student['Address']; ?></textarea><br>

            <label for="newContactNumber">New Contact Number:</label>
            <input type="tel" id="newContactNumber" name="newContactNumber" value="<?php echo $student['ContactNumber']; ?>" required><br>

            <button type="submit">Update Student</button>
        </form>
    </section>

    <?php include_once('footer.php'); ?>
</body>
</html>
