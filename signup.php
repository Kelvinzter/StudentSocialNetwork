<?php
    include('functions/createaccount.php');
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up - University Social Network</title>
    <link rel="stylesheet" href="landing.css">
    <link rel="icon" href="res/UoB_Logo.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600, 700&display=swap" rel="stylesheet">

    <style>
        .error {
            color: rgb(228, 13, 13);
        }

        .success {
            color: rgb(26, 209, 26);
        }
    </style>
</head>

<body>
    <img src="res/UoB_Logo_White.png" alt="UoB_Logo">

    <div align="center" style="margin-top: -5%;">
        <span class="success"><?php echo $success;?></span>
        <span class="error"><?php echo $email_in_use;?></span>
        <span class="error"><?php echo $invalid_email;?></span>
        <span class="error"><?php echo $invalid_password;?></span>
        <span class="error"><?php echo $invalid_username;?></span>
        <span class="error"><?php echo $user_exists;?></span>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table>

                <tr>
                    <td align="right"><label for="username" style="margin-left: 6px;">Username</label></td>
                    <td align="left"><input name="uname" type="text" placeholder="Username" style="margin: 1px"
                            autofocus required></td>
                </tr>
                <tr>
                    <td align="right"><label for="password">Password</label></td>
                    <td align="left"><input name="pw" type="password" placeholder="Password" style="margin: 1px"
                            required></td>
                </tr>

                <tr>
                    <td align="right"><label for="email" style="margin-left: 6px;">Email</label></td>
                    <td colspan="3" align=" left"><input name="e-mail" type="email"
                            placeholder="username@bham.ac.uk" style="margin: 1px" required></td>
                </tr>

                <tr>
                    <td align="right"><label for="firstname" style="margin-left: 6px;">First Name</label></td>
                    <td align="left"><input name="firstname" type="text" placeholder="First Name" style="margin: 1px"
                            required></td>
                </tr>

                <tr>
                    <td align="right"><label for="lastname" style="margin-left: 6px;">Last Name</label></td>
                    <td align="left"><input name="lastname" type="text" placeholder="Last Name" style="margin: 1px"
                            required></td>
                </tr>

                <tr>
                    <td align="right"><label for="type" style="margin-left: 6px;">Type</label></td>
                    <td align="left"><select class="select" name="type" style="margin: 1px;">
                                        <option>Student</option>
                                        <option>Lecturer</option>
                                    </select></td>
                </tr>

                <tr>
                    <td align="center"><a href="index.php"><button type="button" name="back">BACK</button></a>
                    <td align="center"><button type="submit" name="createaccount">SIGN UP</button></a>
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