<?php

if (Login::isLoggedIn()) {

    if (isset($_POST['deleteaccount'])) {
        $UID = Login::isLoggedIn();

        DB::query('DELETE FROM user WHERE UID=:UID', array(':UID' => $UID));

        header('Location: index.php');
    }


} else {
    header('Location: index.php');
    exit();
}

?>