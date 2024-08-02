<!-- Menu -->
<ul class="navbar">
    <li><a href="index.php">Home</a></li>

    <?php
    if (!empty($_SESSION['studentID'])) {
        ?>
        <!-- Student -->
        <li><a href="viewProfile.php">View Profile</a></li>
        <li><a href="viewCourses.php">View Courses</a></li>
        <li><a href="viewResults.php">View Results</a></li>
        <li><a href="viewFeeDetails.php">View Fee Details</a></li>
        <li><a href="viewAttendance.php">View Attendance</a></li>
        <li><a href="changePassword.php">Change Password</a></li>
		<li><a href="coursenrolement.php">coursenrolement</a></li>
    <?php
    } else {
        ?>
        <!-- Guest -->
        <li><a href="loginStudent.php">Login</a></li>
        <li><a href="registerStudent.php">Register</a></li>
    <?php
    }
    ?>

    <li><a href="logOut.php">Log Out</a></li>
</ul>
