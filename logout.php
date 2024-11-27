<?php
session_start();
if(isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id'], $_SESSION['user_username']);
}
header('location: index.php');
$_SESSION['err_msg'] = "You have successfully logout.";
?>
