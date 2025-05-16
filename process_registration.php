<?php
    session_start();
    include('config.php');
    extract($_POST);
    
    try {
        // Start a transaction for both insertions
        $con->beginTransaction();
        
        // Insert into registration table with prepared statement
        $stmt1 = $con->prepare("INSERT INTO tbl_registration VALUES(NULL, :name, :email, :phone, :age, :gender)");
        $stmt1->bindParam(':name', $name);
        $stmt1->bindParam(':email', $email);
        $stmt1->bindParam(':phone', $phone);
        $stmt1->bindParam(':age', $age);
        $stmt1->bindParam(':gender', $gender);
        $stmt1->execute();
        
        // Get the last inserted ID
        $id = $con->lastInsertId();
        
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert into login table with prepared statement
        $stmt2 = $con->prepare("INSERT INTO tbl_login VALUES(NULL, :id, :email, :password, '2')");
        $stmt2->bindParam(':id', $id);
        $stmt2->bindParam(':email', $email);
        $stmt2->bindParam(':password', $hashed_password);
        $stmt2->execute();
        
        // Commit the transaction
        $con->commit();
        
        // Set the session and redirect
        // $_SESSION['user'] = $id;
        header('location:login.php');
        
    } catch(PDOException $e) {
        // Rollback the transaction if something failed
        $con->rollBack();
        
        // Handle the error
        $_SESSION['error'] = "Registration failed: " . $e->getMessage();
        header('location:registration.php');
    }
?>