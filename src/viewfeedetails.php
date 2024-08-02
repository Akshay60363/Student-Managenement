<?php
    include_once('header.php');
    
    // Check if the student is logged in
    if (empty($_SESSION['studentID'])) {
        header('Location: loginStudent.php');
    }

    $studentID = $_SESSION['studentID'];

    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

    // Query the FeePayments table to fetch the fee details for the logged-in student
    $query = "SELECT * FROM FeePayments WHERE StudentID = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$studentID]);
    $feeDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="main-content">
    <h2>Fee Details</h2>
</section>

<?php if (empty($feeDetails)): ?>
    <p>No fee details found for the logged-in student.</p>
<?php else: ?>
    <table border="1">
        <tr>
            <th>Payment ID</th>
            <th>Amount</th>
            <th>Payment Date</th>
        </tr>

        <?php foreach ($feeDetails as $fee): ?>
            <tr>
                <td><?php echo $fee['PaymentID']; ?></td>
                <td><?php echo $fee['Amount']; ?></td>
                <td><?php echo $fee['PaymentDate']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php
    include_once('footer.php');
?>
