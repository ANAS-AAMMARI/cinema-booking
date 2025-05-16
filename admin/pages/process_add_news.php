<?php
include('../../config.php');
extract($_POST);

$uploaddir = '../news_images/';
$uploadfile = $uploaddir . basename($_FILES['attachment']['name']);
move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadfile);
$flname = "news_images/".basename($_FILES["attachment"]["name"]);

try {
    $stmt = $con->prepare("INSERT INTO tbl_news VALUES (NULL, :name, :cast, :date, :description, :flname)");
    $stmt->execute([
        'name' => $name,
        'cast' => $cast,
        'date' => $date,
        'description' => $description,
        'flname' => $flname
    ]);
    $_SESSION['add'] = 1;
} catch(PDOException $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}
header('location:add_movie_news.php');
exit();
?>