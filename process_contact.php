<?php
include('config.php');
extract($_POST);

try {
    $stmt = $con->prepare("INSERT INTO tbl_contact VALUES (NULL, :name, :email, :mobile, :subject)");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'mobile' => $mobile,
        'subject' => $subject
    ]);
    $_SESSION['success'] = "Message sent successfully";
} catch(PDOException $e) {
    $_SESSION['error'] = "Failed to send message: " . $e->getMessage();
}

header('location:contact.php');
exit();
?>