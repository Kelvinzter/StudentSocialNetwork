<?php
include('classes/DB.php');
include('classes/Mail.php');

//error messages
$email_in_use = $invalid_email = $invalid_password = $invalid_username = $user_exists = "";

//success message
$success = "";

if (isset($_POST['createaccount'])) {
    $username = $_POST['uname'];
    $password = $_POST['pw'];
    $email = $_POST['e-mail'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $type = $_POST['type'];


    if (!DB::query('SELECT email FROM user WHERE email=:email', array(':email' => $email))) {

        if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

            if (strlen($password) >= 6 && strlen($password) <= 60) {

                if (preg_match('/[a-zA-Z0-9_]+@bham.ac.uk/', $email)) {


                    if (!DB::query('SELECT username FROM user WHERE username=:username', array(':username' => $username))) {

                        DB::query('INSERT INTO user VALUES 
                        (\'\', :username, :password, :email, :f_name, :l_name, :country, :birthday, :course, :university, :interest, :type, :about,
                        :profile_photo, :profile_cover)', 
                        array(
                        ':username' => $username, 
                        ':password' => password_hash($password, PASSWORD_BCRYPT), 
                        ':email' => $email,
                        ':f_name' => $firstname, 
                        ':l_name' => $lastname,
                        ':country'=> "",
                        ':birthday'=> "",
                        ':course' => "",
                        ':university' => "",
                        ':interest' => "",
                        ':type' => $type,
                        ':about' => "",
                        ':profile_photo'=> "res/default-profile.png",
                        ':profile_cover'=> "res/default-cover.jpg"));

                        
                        //Mail::sendMail('Welcome to the University Social Network!', 'Your account has been successfully created!', $email);
                        $success = "Account created successfully!";
                    } else {
                        $user_exists = "Username already in use!";
                    }
                } else {
                    $invalid_email = "Invalid email";
                }
            } else {
                $invalid_password = "Password must be at least 6 characters long!";
            }
        } else {
            $invalid_username = "Username can only consist of letters, numbers and _!";
        }
    } else {
        $email_in_use = "Email already in use!";
    }
}
