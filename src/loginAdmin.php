<?php
    include_once('header.php');
    
    if (isset($_POST['username'])) {
        $adminID = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        
        
        $db = new PDO('mysql:host=localhost;dbname=ruas3', "root", "");

        
        $query = "SELECT COUNT(*) FROM admins WHERE AdminID = '$adminID' AND Password = '$password'";
        $login_result = $db->query($query)->fetchColumn();
        
        if ($login_result > 0) {
            
            $_SESSION['adminID'] = $adminID;
            
            
            header('Location: admin_dashboard.php');
        } else {
            echo("<br>Invalid admin credentials<br>");
        }
    }
?>

<section class="main-content">
    <h2>Admin Login</h2>
</section>

<form action="loginadmin.php" method="post">
    <div class="login-container">
        <label for="username"><b>Admin ID</b></label>
        <input type="text" placeholder="Enter Admin ID" name="username" id="username" required>
        <br><br>
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" id="password" required>
        <br><br>
        <?php    
            if (isset($_POST['username'])) {
                echo("<br>Invalid admin credentials<br>");
            }
        ?>
        <button type="submit">Login</button>
    </div>
</form>

<?php
    include_once('footer.php');
?>
