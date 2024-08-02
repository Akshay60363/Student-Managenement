<?php
// Start the session
session_start();

// Include the header file
include_once('header.php');

// Check if the student is logged in
if (empty($_SESSION['studentID'])) {
    // Redirect to the student login page if not logged in
    header('Location: loginStudent.php');
    exit;
}

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

// Query to fetch courses from the Courses table
$query = "SELECT * FROM Courses";
$courses = $db->query($query);

?>

<section class="main-content">
    <h2>Available Courses</h2>
</section>

<br>

<?php if ($courses->rowCount() > 0): ?>
    <table border="1">
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Department</th>
            <th>Duration</th>
            <th>Credits</th>
            <th>Faculty Name</th>
        </tr>

        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo $course['CourseID']; ?></td>
                <td><?php echo $course['CourseName']; ?></td>
                <td><?php echo $course['Department']; ?></td>
                <td><?php echo $course['Duration']; ?></td>
                <td><?php echo $course['Credits']; ?></td>
                <td><?php echo $course['facultyname']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No courses available at the moment.</p>
<?php endif; ?>

<?php
// Include the footer file
include_once('footer.php');
?>
