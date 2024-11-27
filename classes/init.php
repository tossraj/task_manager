<?php
if (!isset($_SESSION)) {
    session_start();
}

date_default_timezone_set('Asia/Kolkata');
require_once 'config.php';

if (SIS_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

include_once COREPATH.'/classes/database.php';
include_once COREPATH.'/classes/Admin.php';
include_once COREPATH.'/classes/User.php';

$sisdb = new sisdb();
$admin = new Admin();
$user = new User();

function msg() {
    if(isset($_SESSION['err_msg'])) {
        echo '<div class="alert alert-warning" style="background: #fbc6c6;">' . $_SESSION['err_msg'] . '</div>';
        unset($_SESSION['err_msg']);
    }
}

function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
