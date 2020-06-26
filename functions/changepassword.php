<?php
$password_not_match = $incorrect_password = $invalid_password = "";
$password_success = "";
if (Login::isLoggedIn()) {

    if (isset($_POST['changepw'])) {
        $oldPW = $_POST['oldPassword'];
        $newPW = $_POST['newPassword'];
        $newPWRepeat = $_POST['newPasswordRepeat'];
        $UID = Login::isLoggedIn();

        if (password_verify($oldPW, DB::query('SELECT password FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['password'])) {

            if ($newPW == $newPWRepeat) {

                if (strlen($newPW) >= 6 && strlen($newPW) <= 60) {

                    DB::query('UPDATE user SET password=:newPW WHERE UID=:UID', array(':newPW' => password_hash($newPW, PASSWORD_BCRYPT), ':UID' => $UID));
                    $password_success  = "Password changed successfully!";
                } else{
                    $invalid_password = "Password must be at least 6 characters long!";
                }
            } else {
                $password_not_match ="Passwords don\'t match!";
            }
        } else {
            $incorrect_password = "Incorrect old password";
        }
    }
} else {
    header('Location: index.php');
    exit();
}
?>

