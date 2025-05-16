<?php
include('../../config.php');
extract($_POST);

try {
    $con->beginTransaction();
    
    $stmt = $con->prepare("INSERT INTO tbl_theatre VALUES (NULL, :name, :address, :place, :state, :pin)");
    $stmt->execute([
        'name' => $name,
        'address' => $address,
        'place' => $place,
        'state' => $state,
        'pin' => $pin
    ]);
    
    $id = $con->lastInsertId();
    
    $stmt = $con->prepare("INSERT INTO tbl_login VALUES (NULL, :id, :username, :password, '1')");
    $stmt->execute([
        'id' => $id,
        'username' => $username,
        'password' => $password
    ]);
    
    $con->commit();
    header('location:add_theatre_2.php?id='.$id);
} catch(PDOException $e) {
    $con->rollBack();
    echo "Error: " . $e->getMessage();
}
exit();
?>