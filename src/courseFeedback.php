<?php
session_start();


if (empty($_SESSION['studentID'])) {
    header('Location: loginStudent.php');
}


$studentID = $_SESSION['studentID'];
$query = "SELECT Enrollments.EnrollmentID, Courses.CourseName
          FROM Enrollments
          JOIN Courses ON Enrollments.CourseID = Courses.CourseID
          WHERE Enrollments.StudentID = ?";
$stmt = $db->prepare($query);
$stmt->execute([$studentID]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedbackText = htmlspecialchars($_POST['feedbackText']);
    $rating = htmlspecialchars($_POST['rating']);
    $enrollmentID = htmlspecialchars($_POST['enrollmentID']);

    
    header('Location: courseFeedback.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Feedback</title>
   
</head>
<body>
    <?php include_once('header.php'); ?>

    <section class="main-content">
        <h2>Course Feedback</h2>

        <form action="courseFeedback.php" method="post">
           
            <label for="selectedCourse">Select Course:</label>
            <select id="selectedCourse" name="enrollmentID" required>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course['EnrollmentID']; ?>"><?php echo $course['CourseName']; ?></option>
                <?php endforeach; ?>
            </select><br>

        
            <label for="feedbackText">Feedback Text:</label>
            <textarea id="feedbackText" name="feedbackText" required></textarea><br>

            <label for="rating">Rating:</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required><br>

            <button type="submit">Submit Feedback</button>
        </form>
    </section>

    <?php include_once('footer.php'); ?>
</body>
</html>
