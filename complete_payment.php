<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
session_start();
if(!isset($_SESSION['user']))
{
    header('location:login.php');
    exit();
}
include('config.php');
extract($_POST);
if($otp=="123456")
{
    $bookid = "BKID".rand(1000000,9999999);
    try {
        $stmt = $con->prepare("INSERT INTO tbl_bookings VALUES (NULL, :bookid, :theatre, :user, :show, :screen, :seats, :amount, :date, CURDATE(), '1')");
        $stmt->execute([
            'bookid' => $bookid,
            'theatre' => $_SESSION['theatre'],
            'user' => $_SESSION['user'],
            'show' => $_SESSION['show'],
            'screen' => $_SESSION['screen'],
            'seats' => $_SESSION['seats'],
            'amount' => $_SESSION['amount'],
            'date' => $_SESSION['date']
        ]);
        $_SESSION['success'] = "Booking Successfully Completed";
    } catch(PDOException $e) {
        $_SESSION['error'] = "Booking Failed: " . $e->getMessage();
    }
}
else
{
    $_SESSION['error'] = "Payment Failed";
}
?>
<body><table align='center'><tr><td><STRONG>Transaction is being processed,</STRONG></td></tr><tr><td><font color='blue'>Please wait <i class="fa fa-spinner fa-pulse fa-fw"></i>
<span class="sr-only"></font></td></tr><tr><td>(Please do not press 'Refresh' or 'Back' button )</td></tr></table><h2>
<script>
    setTimeout(function(){ window.location="profile.php"; }, 5000);
</script>