<?php
    include_once('header.php');
    
    // Check if the student is logged in
    if (empty($_SESSION['studentID'])) {
        header('Location: loginStudent.php');
    }

    $studentID = $_SESSION['studentID'];

    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

    // Query the ExamResults table to fetch the results for the logged-in student
    $query = "SELECT * FROM ExamResults WHERE StudentID = ?";
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
            <th>Subject</th>
            <th>Marks</th>
            <th>Grade</th>
        </tr>

        <?php foreach ($results as $result): ?>
            <tr>
                <td><?php echo $result['ResultID']; ?></td>
                <td><?php echo $result['Subject']; ?></td>
                <td><?php echo $result['Marks']; ?></td>
                <td><?php echo $result['Grade']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php
    include_once('footer.php');
?>
