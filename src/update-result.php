<?php
include_once('header.php');
session_start();

if (!isset($_SESSION['adminID'])) {
    header('Location: loginadmin.php');
    exit();
}

$db = new PDO('mysql:host=localhost;dbname=ruas3', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentID = htmlspecialchars($_POST['studentID']);
    $courseID = htmlspecialchars($_POST['courseID']);
    $marks = htmlspecialchars($_POST['marks']);
    $grade = htmlspecialchars($_POST['grade']);

    $checkQuery = "SELECT * FROM ExamResults WHERE StudentID = ? AND CourseID = ?";
    $checkStmt = $db->prepare($checkQuery);
    $checkStmt->execute([$studentID, $courseID]);
    $existingResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingResult) {
        $updateQuery = "UPDATE ExamResults SET Marks = ?, Grade = ? WHERE StudentID = ? AND CourseID = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->execute([$marks, $grade, $studentID, $courseID]);
        $message = 'Student result updated successfully!';
    } else {
        $insertQuery = "INSERT INTO ExamResults (StudentID, CourseID, Marks, Grade) VALUES (?, ?, ?, ?)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->execute([$studentID, $courseID, $marks, $grade]);
        $message = 'New result added successfully!';
    }

    $_SESSION['update_result_message'] = $message;
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update or Add Student Result</title>
    <!-- Add any additional head content here -->
</head>
<body>
    <?php include_once('header.php'); ?>

    <section class="main-content">
        <h2>Update or Add Student Result</h2>

        <?php
        if (isset($_SESSION['update_result_message'])) {
            echo '<p style="color: green;">' . $_SESSION['update_result_message'] . '</p>';
            unset($_SESSION['update_result_message']);
        }
        ?>

        <form action="update-result.php" method="post">
            <label for="studentID">Student ID:</label>
            <input type="text" id="studentID" name="studentID" required><br>

            <label for="courseID">Course ID:</label>
            <input type="text" id="courseID" name="courseID" required><br>

            <label for="marks">Marks:</label>
            <input type="text" id="marks" name="marks" required><br>

            <label for="grade">Grade:</label>
            <input type="text" id="grade" name="grade" required><br>

            <button type="submit">Update or Add Result</button>
        </form>
    </section>

    <?php include_once('footer.php'); ?>
</body>
</html>
