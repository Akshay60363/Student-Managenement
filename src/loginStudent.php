<?php
    include_once('header.php');
    
    if (isset($_POST['username'])) {
        $studentID = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        
        // Connect to the database
        $db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

        // Query the Students table, check if credentials are valid
        $query = "SELECT COUNT(*) FROM Students WHERE StudentID = '$studentID' AND Password = '$password'";
        $login_result = $db->query($query)->fetchColumn();
        
        if ($login_result > 0) {
            // Successfully logged in
            $_SESSION['studentID'] = $studentID;
            
            // Redirect to home
            header('Location: index.php');
        } else {
            echo("<br>Invalid credentials<br>");
        }
    }
?>

<section class="main-content">
    <h2>Student Login</h2>
</section>

<form action="loginStudent.php" method="post">
    <div class="login-container">
        <label for="username"><b>Student ID</b></label>
        <input type="text" placeholder="Enter Student ID" name="username" id="username" required>
        <br><br>
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" id="password" required>
        <br><br>
        <?php    
            if (isset($_POST['username'])) {
                echo("<br>Invalid credentials<br>");
            }
        ?>
        <button type="submit">Login</button>
    </div>
</form>

<?php
    include_once('footer.php');
?>
