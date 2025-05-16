<?php
session_start();
include('../../config.php');

try {
    $stmt = $con->prepare("DELETE FROM tbl_movie WHERE movie_id = :mid");
    $stmt->execute(['mid' => $_GET['mid']]);
    $_SESSION['success'] = "Movie deleted successfully";
} catch(PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}
header("location:index.php");
exit();
?>