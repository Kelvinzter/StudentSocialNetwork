<?php
include('functions/login.php');
include('classes/Login.php');

if (Login::isLoggedIn()) {
    header('Location: home.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In - University Social Network</title>
    <link rel="stylesheet" href="landing.css">
    <link rel="icon" href="res/UoB_Logo.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600, 700&display=swap" rel="stylesheet">

    <style>
        .error {
            color: rgb(228, 13, 13);
        }
    </style>
</head>

<body>
    <img src="res/UoB_Logo_White.png" alt="UoB_Logo">

    <div align="center">
        <span class="error"><?php echo $invalid_password;?></span>
        <span class="error"><?php echo $user_not_registered;?></span>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table>
                <tr>
                    <td align="right"><label for="username" style="margin-left: 6px;">Username</label></td>
                    <td align="left"><input name="username" type="text" placeholder="Username" style="margin: 1px" autofocus required></td>
                </tr>
                <tr>
                    <td align="right"><label for="username">Password</label></td>
                    <td align="left"><input name="password" type="password" placeholder="Password" style="margin: 1px" required></td>
                </tr>

                <tr>
                    <td align="left"><button type="submit" name="login">LOG IN</button></td>
                    <td align="right"><a href="signup.php"><button type="button">SIGN UP</button></a></td>
                </tr>

                <tr>
                    <td colspan="2" align="center"><a href="forgotpass.php" style="color:white">FORGOT PASSWORD?</a>
                    </td>
                </tr>
        </form>
    </div>

    
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>