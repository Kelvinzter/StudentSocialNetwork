<?php
$edit_success = "";

if (Login::isLoggedIn()) {

    if (isset($_POST['updateprofile'])) {
        $UID = Login::isLoggedIn();
        $username = $_POST['username'];
        $email = $_POST['email'];
        $firstName = $_POST['firstname'];
        $lastName = $_POST['lastname'];
        $country = $_POST['country'];
        $birthday = $_POST['birthday'];
        $course = $_POST['course'];
        $university = $_POST['university'];
        $interest = $_POST['interest'];
        $about = $_POST['about'];

        DB::query('UPDATE user SET username=:username WHERE UID=:UID', array(':username' => $username, ':UID' => $UID));
        DB::query('UPDATE user SET email=:email WHERE UID=:UID', array(':email' => $email, ':UID' => $UID));
        DB::query('UPDATE user SET f_name=:firstname WHERE UID=:UID', array(':firstname' => $firstName, ':UID' => $UID));
        DB::query('UPDATE user SET l_name=:lastname WHERE UID=:UID', array(':lastname' => $lastName, ':UID' => $UID));
        DB::query('UPDATE user SET country=:country WHERE UID=:UID', array(':country' => $country, ':UID' => $UID));
        DB::query('UPDATE user SET birthday=:birthday WHERE UID=:UID', array(':birthday' => $birthday, ':UID' => $UID));
        DB::query('UPDATE user SET course=:course WHERE UID=:UID', array(':course' => $course, ':UID' => $UID));
        DB::query('UPDATE user SET university=:university WHERE UID=:UID', array(':university' => $university, ':UID' => $UID));
        DB::query('UPDATE user SET interest=:interest WHERE UID=:UID', array(':interest' => $interest, ':UID' => $UID));
        DB::query('UPDATE user SET about=:about WHERE UID=:UID', array(':about' => $about, ':UID' => $UID));

        $edit_success = "Profile updated successfully!";

    }
} else {
    header('Location: index.php');
    exit();
}
