<?php
   
    include_once('header.php'); 

    
    if (!isset($_SESSION['adminID'])) {
        header('Location: loginadmin.php'); 
        exit();
    }
?>


<section class="main-content">
    <h2>Welcome to the Admin Dashboard, <?php echo $_SESSION['adminID']; ?>!</h2>
    
    <p>This is a sample admin dashboard. You can customize it based on your requirements.</p>

    
    <div class="add-student-link">
        <h3><a href="add-student.php">Add Student</a></h3>
        
    </div>

    
    <div class="edit-student-link">
        <h3><a href="edit-student.php">Edit Student Details</a></h3>
        
    </div>
    <div class="update-result-link">
        <h3><a href="update-result.php">update result of student</a></h3>
        
    </div>
    
    
</section>

<?php
    include_once('footer.php'); 
?>
