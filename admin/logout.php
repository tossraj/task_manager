<?php
session_start();
if(isset($_SESSION['admin_id'])) {
    unset($_SESSION['admin_id'], $_SESSION['admin_username']);
}
header('location: login.php');
$_SESSION['err_msg'] = "You have successfully logout.";
?>
