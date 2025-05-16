<?php
include('config.php');
session_start();

// Get form input
$email = $_POST["Email"];
$pass = $_POST["Password"];

try {
    // Prepare the SQL query - The email is stored in the username column
    $stmt = $con->prepare("SELECT * FROM tbl_login WHERE username = :email");
    
    // Bind parameter
    $stmt->bindParam(':email', $email);
    
    // Execute the query
    $stmt->execute();
    
    // Check if user exists
    if($stmt->rowCount() > 0) {
        // Fetch user data
        $usr = $stmt->fetch();
        
        // Use password_verify to check hashed password

        if(password_verify($pass, $usr['password'])) {
            if($usr['user_type'] == 2) {
                // Set session with user_id
                $_SESSION['user'] = $usr['user_id'];
                
                if(isset($_SESSION['show'])) {
                    header('location:booking.php');
                } else {
                    header('location:index.php');
                }
                exit;
            } else {
                $_SESSION['error'] = "Login Failed!";
            }
        } else {
            $_SESSION['error'] = "Invalid password!";
            
            // For debugging:
            // echo "Stored hash: " . $usr['password'] . "<br>";
            // echo "Submitted password: " . $pass . "<br>";
            // echo "Verification result: " . (password_verify($pass, $usr['password']) ? "true" : "false");
            // exit;
        }
    } else {
        $_SESSION['error'] = "User not found!";
    }
    
    header("location:login.php");
    
} catch(PDOException $e) {
    // Handle errors
    $_SESSION['error'] = "Database Error: " . $e->getMessage();
    header("location:login.php");
}
?>