<?php
session_start();
include('config.php');

try {
    $stmt = $con->prepare("DELETE FROM tbl_bookings WHERE book_id = :book_id");
    $stmt->execute(['book_id' => $_GET['id']]);
    
    $_SESSION['success'] = "Booking Cancelled Successfully";
} catch(PDOException $e) {
    $_SESSION['error'] = "Cancellation Failed: " . $e->getMessage();
}

header('location:profile.php');
exit();
?>