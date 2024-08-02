<?php
    include_once('header.php');
    
    // Check if the student is logged in
    if (empty($_SESSION['studentID'])) {
        header('Location: loginStudent.php');
    }
    
    if (isset($_POST['new_password'])) {
        $new_password = htmlspecialchars($_POST['new_password']);
        $old_password = htmlspecialchars($_POST['old_password']);
        $studentID = $_SESSION['studentID'];
        
        // Connect to the database
        $db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

        // Query the Students table, check if credentials are valid
        $query = "UPDATE Students SET Password = ? WHERE StudentID = ? AND Password = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$new_password, $studentID, $old_password]);

        // Check if the password was successfully updated
        $rowsAffected = $stmt->rowCount();
        if ($rowsAffected > 0) {
            $message = 'Password updated successfully';
        } else {
            $message = 'Invalid current password. Please try again.';
        }
    }
?>

<section class="main-content">
    <h2>Change Password</h2>
</section>

<?php
    if (isset($message)) {
        echo '<p>' . $message . '</p>';
    }
?>

<form action="changePassword.php" method="post" onsubmit="return confirm('Confirm changes?');">
    <div class="login-container">
        <label for="password"><b>Current Password</b></label>
        <input type="password" placeholder="Enter Current Password" name="old_password" id="old_password" required>
        <br><br>
        <label for="password"><b>New Password</b></label>
        <input type="password" placeholder="Enter New Password" name="new_password" id="new_password" required>
        <br><br>
        <button type="submit">Save</button>
    </div>
</form>

<?php
    include_once('footer.php');
?>
