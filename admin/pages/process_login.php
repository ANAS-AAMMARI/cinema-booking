<?php
include('../../config.php');
session_start();

try {
    // First get the user by username only
    $stmt = $con->prepare("SELECT * FROM tbl_login WHERE username = :email");
    $stmt->execute([
        'email' => $_POST["Email"]
    ]);
    
    if($stmt->rowCount() > 0) {
        $usr = $stmt->fetch();
        // Verify the password hash
        if(password_verify($_POST["Password"], $usr['password'])) {
            if($usr['user_type'] == 0) {
                $_SESSION['admin'] = $usr['user_id'];
                header('location:index.php');
            } else {
                $_SESSION['error'] = "Access Denied!";
                header("location:../index.php");
            }
        } else {
            $_SESSION['error'] = "Invalid Password!";
            header("location:../index.php");
        }
    } else {
        $_SESSION['error'] = "Invalid Username!";
        header("location:../index.php");
    }
} catch(PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header("location:../index.php");
}
exit();
?>