<?php
include('../../config.php');
extract($_POST);

try {
    $stmt = $con->prepare("INSERT INTO tbl_screens VALUES (NULL, :theatre, :name, :seats, :charge)");
    $stmt->execute([
        'theatre' => $theatre,
        'name' => $name,
        'seats' => $seats,
        'charge' => $charge
    ]);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>