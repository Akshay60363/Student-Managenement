<?php
    include_once('header.php');
    
    // Check if the student is logged in
    if (empty($_SESSION['studentID'])) {
        header('Location: loginStudent.php');
    }

    $studentID = $_SESSION['studentID'];

    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

    // Query the ExamResults and Courses tables to fetch the results for the logged-in student
    $query = "SELECT er.ResultID, er.Marks, er.Grade, er.CourseID, c.CourseName
              FROM ExamResults er
              JOIN Courses c ON er.CourseID = c.CourseID
              WHERE er.StudentID = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$studentID]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="main-content">
    <h2>Exam Results</h2>
</section>

<?php if (empty($results)): ?>
    <p>No exam results found for the logged-in student.</p>
<?php else: ?>
    <table border="1">
        <tr>
            <th>Result ID</th>
            <th>Marks</th>
            <th>Grade</th>
            <th>Course ID</th>
            <th>Course Name</th>
        </tr>

        <?php foreach ($results as $result): ?>
            <tr>
                <td><?php echo $result['ResultID']; ?></td>
                <td><?php echo $result['Marks']; ?></td>
                <td><?php echo $result['Grade']; ?></td>
                <td><?php echo $result['CourseID']; ?></td>
                <td><?php echo $result['CourseName']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php
    include_once('footer.php');
?>
