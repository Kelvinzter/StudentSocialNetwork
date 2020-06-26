<?php
include('classes/DB.php');
include('classes/Mail.php');

if (isset($_POST['resetpassword'])) {
    $cstrong = TRUE;
    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
    $email = $_POST['email'];
    $UID = DB::query('SELECT UID FROM user WHERE email=:email', array(':email' => $email))[0]['UID'];
    DB::query('INSERT INTO password_token VALUES (\'\', :token, :UID)', array(':token' => sha1($token), ':UID' => $UID));
    Mail::sendMail('Forgot Password', "<a href='http://localhost/USN/changepassword.php?token=$token'>http://localhost/USN/changepassword.php?token=$token</a>", $email);

    echo 'Email Sent!';
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password - University Social Network</title>
    <link rel="stylesheet" href="landing.css">
    <link rel="icon" href="res/UoB_Logo.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600, 700&display=swap" rel="stylesheet">
</head>

<body>
    <img src="res/UoB_Logo_White.png" alt="UoB_Logo">

    <div align="center" style="margin-top: -5%;">
        <p style="margin-top: 5%;">
            Enter your email and we'll email you a link to change your password.
        </p>
    </div>

    <div align="center">
        <table>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <tr>
                    <td align="right"><label for="email" style="margin-left: 6px;">EMAIL</label></td>
                    <td align="left"><input type="email" name="email" type="text" placeholder="Email" style="margin: 1px; width: 200px;" required></td>
                </tr>

                <tr>
                    <td align="center"><button type="submit" name="resetpassword" value="Reset Password">SEND LINK</button>
            </form>
            </td>
            <td align="center"><a href="index.php"><button type="button">SIGN IN</button></a></td>
            <td align="center"><a href="signup.php"><button type="button">SIGN UP</button></a></td>
            </tr>
        </table>
    </div>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>