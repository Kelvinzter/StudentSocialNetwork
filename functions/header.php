<?php
    if(Login::isLoggedIn()){
        $UID = Login::isLoggedIn();
        $username = DB::query('SELECT username FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['username'];
        $email = DB::query('SELECT email FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['email'];
        $f_name = DB::query('SELECT f_name FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['f_name'];
        $l_name = DB::query('SELECT l_name FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['l_name'];
        $country = DB::query('SELECT country FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['country'];
        $birthday = DB::query('SELECT birthday FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['birthday'];
        $course = DB::query('SELECT course FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['course'];
        $university = DB::query('SELECT university FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['university'];
        $interest = DB::query('SELECT interest FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['interest'];
        $type = DB::query('SELECT type FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['type'];
        $about = DB::query('SELECT about FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['about'];
        $profile_photo = DB::query('SELECT profile_photo FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['profile_photo'];
        $profile_cover = DB::query('SELECT profile_cover FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['profile_cover'];
    }
?>