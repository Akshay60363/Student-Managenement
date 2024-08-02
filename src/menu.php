
<ul class="navbar">
    <li><a href="index.php">Home</a></li>

    <?php
    if (!empty($_SESSION['studentID'])) {
        ?>
        
        <li><a href="viewProfile.php">View Profile</a></li>
        <li><a href="viewCourses.php">View Courses</a></li>
        <li><a href="viewResults.php">View Results</a></li>
       
       
        <li><a href="changePassword.php">Change Password</a></li>
		<li><a href="coursenrolement.php">coursenrolement</a></li>
        <li><a href="logOut.php">Log Out</a></li>
    <?php
    } 
    


    else {
        ?>
        
        <li><a href="loginStudent.php">Login</a></li>
        <li><a href="loginadmin.php">admin</a></li>
        
    <?php
    }
    ?>

    
</ul>
