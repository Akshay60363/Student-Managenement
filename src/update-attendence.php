<?php
session_start(); 


if (empty($_SESSION['adminID'])) {
    header('Location: loginadmin.php');
    exit();
}


$db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['enrollmentID'], $_POST['date'], $_POST['status'])) {
        $enrollmentID = $_POST['enrollmentID'];
        $date = $_POST['date'];
        $status = $_POST['status'];

        // Update attendance record
        $updateQuery = "INSERT INTO CourseAttendance (EnrollmentID, Date, Status) VALUES (?, ?, ?)
                        ON DUPLICATE KEY UPDATE Status = VALUES(Status)";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->execute([$enrollmentID, $date, $status]);
    }
}
?>


<form action="update-attendance.php" method="post">
    <label for="enrollmentID"><b>Enrollment ID:</b></label>
    <input type="text" name="enrollmentID" required>

    <label for="date"><b>Date:</b></label>
    <input type="date" name="date" required>

    <label for="status"><b>Status:</b></label>
    <select name="status" required>
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
    </select>

    <button type="submit">Update Attendance</button>
</form>


