<?php
include('classes/DB.php');

$invalid_password = $user_not_registered = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (DB::query('SELECT username FROM user WHERE username = :username', array(':username' => $username))) {

        if (password_verify($password, DB::query('SELECT password FROM user WHERE username = :username', array(':username' => $username))[0]['password'])) {
            header('Location: index.php');
            $cstrong = TRUE;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $user_id = DB::query('SELECT UID FROM user WHERE username=:username', array(':username' => $username))[0]['UID'];
            DB::query('INSERT INTO login_token VALUES (\'\', :token, :user_id)', array(':token' => sha1($token), ':user_id' => $user_id));

            setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            setcookie("SNID_1", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
        } else {
            $invalid_password = "Invalid Password!";
        }
    } else {
        $user_not_registered  = "User does not exist!";
    }
}
