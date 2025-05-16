<?php
include('../../config.php');
extract($_POST);
try {
    $stmt = $con->prepare("INSERT INTO tbl_show_time VALUES (NULL, :screen, :sname, :time)");
    $stmt->execute([
        'screen' => $screen,
        'sname' => $sname,
        'time' => $time
    ]);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>