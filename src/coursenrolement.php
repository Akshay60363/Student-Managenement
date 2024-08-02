<?php
    session_start(); 

    include_once('header.php');
    
    
    if (empty($_SESSION['studentID'])) {
        header('Location: loginstudent.php');
    }

    $studentID = $_SESSION['studentID'];

    
    $db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

    
    $query = "SELECT * FROM Courses";
    $courses = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['selectedCourses'])) {
            $selectedCourses = $_POST['selectedCourses'];

            foreach ($selectedCourses as $selectedCourseID) {
               
                $enrollmentQuery = "SELECT COUNT(*) FROM Enrollments WHERE StudentID = ? AND CourseID = ?";
                $enrollmentStmt = $db->prepare($enrollmentQuery);
                $enrollmentStmt->execute([$studentID, $selectedCourseID]);
                $enrollmentCount = $enrollmentStmt->fetchColumn();

                if ($enrollmentCount == 0) {
                    
                    $enrollmentInsertQuery = "INSERT INTO Enrollments (StudentID, CourseID, EnrollmentDate) VALUES (?, ?, NOW())";
                    $enrollmentInsertStmt = $db->prepare($enrollmentInsertQuery);

                    
                    if ($enrollmentInsertStmt->execute([$studentID, $selectedCourseID])) {
                        $_SESSION['enrollment_message'] = 'Enrollment successful for CourseID: ' . $selectedCourseID;
                    } else {
                        $_SESSION['enrollment_message'] = 'Error during enrollment. Please try again.';
                    }
                } else {
                    $_SESSION['enrollment_message'] = 'You are already enrolled in CourseID: ' . $selectedCourseID;
                }
            }

            
            header('Location: coursenrolement.php');
            exit;
        }
    }
?>

<section class="main-content">
    <h2>Course Enrollment</h2>

    <?php
    // Display session message if set
    if (isset($_SESSION['enrollment_message'])) {
        echo '<div class="message">' . $_SESSION['enrollment_message'] . '</div>';
        unset($_SESSION['enrollment_message']); // Clear the message
    }
    ?>
</section>

<form action="coursenrolement.php" method="post">
    <div class="enrollment-container">
        <label><b>Select Courses:</b></label><br>
        <?php foreach ($courses as $course): ?>
            <input type="checkbox" name="selectedCourses[]" value="<?php echo $course['CourseID']; ?>">
            <?php echo $course['CourseName']; ?><br>
        <?php endforeach; ?>
        <br>
        <button type="submit">Enroll</button>
    </div>
</form>

<?php
    include_once('footer.php');
?>
