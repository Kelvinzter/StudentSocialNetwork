<?php
include('functions/logout.php');
include('functions/header.php');
include('functions/editprofile.php');
include('functions/changepassword.php');
include('functions/deleteaccount.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings - University Social Network</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <link rel="icon" href="res/UoB_Logo.png">
    <link rel="stylesheet" href="profile.css">

    <style>
        .tabs-left {
            border: 1px solid white;
            padding-top: 0px;
        }

        .tabs-left>li {
            float: none;
            margin-bottom: 0px;
            margin-right: -1px;
            margin-left: -1px;
        }

        .tabs-left>li>a {
            border-radius: 0 0 0 0;
            margin-right: 0;
            display: block;
            color: white;
            
        }

        .tabs-left>li>a:hover {
            border-radius: 0 0 0 0;
            margin-right: 0;
            display: block;
            color: black;
            background-color: white;
        }

        .tabs-left>li.active>a,
        .tabs-left>li.active>a:hover,
        .tabs-left>li.active>a:focus {
            color: black;
            border-bottom-color: white;
            border-right-color: transparent;
        }

        .button-submit {
            margin: auto;
            margin-right: auto;
            margin-left: auto;
            background-color: transparent;
            border: 2px solid white;
            border-radius: 0;
            color: white;
            padding: 20px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
        }

        .button-submit:hover {
            background-color: white;
            border-radius: 0;
            color: black;
            cursor: pointer;
        }

        label {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            font-size: 20px;
            display: inline-block;
            color: white;
            margin-left: auto;
            margin-right: 10px;
        }

        input {
            background-color: black;
            border-radius: 0;
            border: 2px solid white;
            padding-left: 5px;
            color: white;
            height: 30px;
            width: 250px;
            font-family: 'Roboto', sans-serif;
            margin-left: auto;
            margin-right: auto;
        }

        table {
            border-collapse: separate;
            border-spacing: 30px;
        }

        td {
            color: white;
            font-family: 'Roboto', sans-serif;
        }

        .error {
            color: rgb(228, 13, 13);
        }

        .success {
            color: rgb(26, 209, 26);
        }

        textarea {
            border: 2px solid white;
            padding: 5px;
            resize: none;
            width: 150%;
            background: black;
            color: white;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"><img src="res/UoB_Logo.png" class="logo"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <form action = "<?php echo htmlspecialchars("results.php"); ?>" method = "POST" class="navbar-form navbar-left" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="search_user" required>
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="search_user_btn">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="profile.php"><strong>PROFILE</strong></a></li>
                    <li><a href="messages.php"><strong>MESSAGES</strong></a></li>
                    <li><a href="notifications.php"><strong>NOTIFICATIONS</strong></a></li>
                    <li><a href="settings.php"><strong>SETTINGS</strong></a></li>
                    <li><a href="forum.php"><strong>FORUM</strong></a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><strong>USER</strong>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <li><input type="submit" name="logout" value="Log Out"/></li>
                            </form>
                        </ul>
                    </li>
                        
                  </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <!-- Tabs -->
            <div class="col-sm-12">
                <h1>Settings</h1>
                <hr>
                <!-- Nav Tabs -->
                <div class="col-sm-3">
                    <ul class="nav nav-tabs tabs-left sideways" id="myTab" data-tabs="tabs">
                        <li class="active"><a data-toggle="tab" href="#edit-profile">Edit Profile</a></li>
                        <li><a data-toggle="tab" href="#changepassword">Change Password</a></li>
                        <li><a data-toggle="tab" href="#deleteaccount">Delete Account</a></li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="col-sm-9">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" align="center" id="edit-profile">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <h1>Edit Profile</h1>
                                <span class="success"><?php echo $edit_success;?></span>
                                <table>

                                    <tr>
                                        <td align="right"><label for="username"
                                                style="margin-left: 6px;">Username</label></td>
                                        <td align="left"><input name="username" type="text"
                                                value="<?php echo $username;?>" style="margin: 1px" required></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="email" style="margin-left: 6px;">Email</label>
                                        </td>
                                        <td align="left"><input name="email" type="email" value="<?php echo $email;?>"
                                                style="margin: 1px" readonly></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="firstname">First Name</label></td>
                                        <td align="left"><input name="firstname" type="text"
                                                value="<?php echo $f_name;?>" style="margin: 1px" required></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="lastname" style="margin-left: 6px;">Last
                                                Name</label></td>
                                        <td align=" left"><input name="lastname" type="text"
                                                value="<?php echo $l_name;?>" style="margin: 1px" required></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="country" style="margin-left: 6px;">Country</label>
                                        </td>
                                        <td align=" left"><input name="country" type="text"
                                                value="<?php echo $country;?>" style="margin: 1px" ></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="birthday"
                                                style="margin-left: 6px;">Birthday</label></td>
                                        <td align="left"><input name="birthday" type="date"
                                                value="<?php echo $birthday;?>" style="margin: 1px" ></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="course" style="margin-left: 6px;">Course</label>
                                        </td>
                                        <td align="left"><input name="course" type="text" value="<?php echo $course;?>"
                                                style="margin: 1px" ></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="university"
                                                style="margin-left: 6px;">University</label></td>
                                        <td align="left"><input name="university" type="text"
                                                value="<?php echo $university;?>" style="margin: 1px" ></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="about"
                                                style="margin-left: 6px;">About</label></td>
                                        <td align="left"><textarea class="autoExpand" rows="3" data-min-rows="3" name="about"><?php echo $about;?></textarea>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right"><label for="interest"
                                                style="margin-left: 6px;">Interests</label></td>
                                        <td align="left"><textarea class="autoExpand" rows="3" data-min-rows="3" name="interest"><?php echo $interest;?></textarea>
                                    </tr>

                                    <tr>
                                        <td colspan="2" align="center"><button class="button-submit" type="submit"
                                                name="updateprofile">UPDATE PROFILE</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <div class="tab-pane fade in" align="center" id="changepassword">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <h1>Change Password</h1>
                                <span class="success"><?php echo $password_success;?></span>
                                <span class="error"><?php echo $invalid_password;?></span>
                                <span class="error"><?php echo $password_not_match;?></span>
                                <span class="error"><?php echo $incorrect_password;?></span>
                                <table>

                                    <tr>
                                        <td align="right"><label for="oldPassword" style="margin-left: 6px;">Old
                                                Password</label></td>
                                        <td align="left"><input name="oldPassword" type="password"
                                                placeholder="Old Password" style="margin: 1px" autofocus required></td>
                                    </tr>
                                    <tr>
                                        <td align="right"><label for="newPassword">New Password</label></td>
                                        <td align="left"><input name="newPassword" type="password"
                                                placeholder="New Password" style="margin: 1px" required></td>
                                    </tr>

                                    <tr>
                                        <td align="right"><label for="newPasswordRepeat"
                                                style="margin-left: 6px;">Confirm
                                                New Password</label>
                                        </td>
                                        <td align=" left"><input name="newPasswordRepeat" type="password"
                                                placeholder="Confirm New Password" style="margin: 1px" required></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" align="center"><button class="button-submit" type="submit"
                                                name="changepw">CHANGE
                                                PASSWORD</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <div class="tab-pane fade in" align="center" id="deleteaccount">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <h1>Delete Account</h1>
                                <br>
                                <span class="error">WARNING: Once you press the button, your account will be permanently deleted.</span>
                         
                                <table>

                                    <tr>
                                        <td colspan="2" align="center"><button class="button-submit" type="submit"
                                                name="deleteaccount">DELETE ACCOUNT</button>
                                        </td>
                                    </tr>

                                </table>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })

        $(document)
    .one('focus.autoExpand', 'textarea.autoExpand', function(){
        var savedValue = this.value;
        this.value = '';
        this.baseScrollHeight = this.scrollHeight;
        this.value = savedValue;
    })
    .on('input.autoExpand', 'textarea.autoExpand', function(){
        var minRows = this.getAttribute('data-min-rows')|0, rows;
        this.rows = minRows;
        rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 16);
        this.rows = minRows + rows;
    });
    
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>

</body>

</html>