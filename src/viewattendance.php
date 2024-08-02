<?php
session_start(); // Start the session

include_once('header.php');

// Check if the student is logged in
if (empty($_SESSION['studentID'])) {
    header('Location: loginstudent.php');
}

$studentID = $_SESSION['studentID'];

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

// Query the Courses table to fetch available courses
$query = "SELECT * FROM Courses";
$courses = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selectedCourse'])) {
        $selectedCourseID = $_POST['selectedCourse'];

        // Query to fetch attendance data for the selected course
        $attendanceQuery = "SELECT Date, Status FROM CourseAttendance
                            JOIN Enrollments ON CourseAttendance.EnrollmentID = Enrollments.EnrollmentID
                            WHERE Enrollments.StudentID = ? AND Enrollments.CourseID = ?";
        $attendanceStmt = $db->prepare($attendanceQuery);
        $attendanceStmt->execute([$studentID, $selectedCourseID]);
        $attendanceData = $attendanceStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<section class="main-content">
    <h2>View Attendance</h2>

    <form action="viewAttendance.php" method="post">
        <label for="selectedCourse"><b>Select Course:</b></label>
        <select id="selectedCourse" name="selectedCourse" required>
            <?php foreach ($courses as $course): ?>
                <option value="<?php echo $course['CourseID']; ?>"><?php echo $course['CourseName']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">View Attendance</button>
    </form>

    <?php if (isset($attendanceData)): ?>
        <h3>Attendance for <?php echo $courses[array_search($selectedCourseID, array_column($courses, 'CourseID'))]['CourseName']; ?>:</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendanceData as $attendance): ?>
                    <tr>
                        <td><?php echo $attendance['Date']; ?></td>
                        <td><?php echo $attendance['Status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php
include_once('footer.php');
?>
