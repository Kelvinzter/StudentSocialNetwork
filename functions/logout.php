<?php
include('classes/DB.php');
include('classes/Login.php');

if (!Login::isLoggedIn()) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['logout'])) {
    $UID = Login::isLoggedIn();
    header('Location: index.php');
    if (isset($_COOKIE['SNID'])) {
        DB::query('DELETE FROM login_token WHERE token=:token AND UID=:UID', array(':token' => sha1($_COOKIE['SNID']), ':UID' => $UID));
    }
    setcookie('SNID', '1', time() - 3600);
    setcookie('SNID_', '1', time() - 3600);
    exit();
}
