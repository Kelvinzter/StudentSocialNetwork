<?php
include('functions/logout.php');


function getNotifications(){
    $UID = Login::isLoggedIn();

    if (DB::query('SELECT * FROM notification WHERE receiver=:UID', array(':UID'=>$UID))) {
        $notifications = DB::query('SELECT * FROM notification WHERE receiver=:UID ORDER BY id DESC', array(':UID'=>$UID));

        foreach($notifications as $n){
            if($n['type'] == 1){
                $sender = DB::query('SELECT UID, f_name, l_name, profile_photo FROM user WHERE UID = :sender', array(':sender' => $n['sender']));
                
                foreach($sender as $s){
                    $userID = $s['UID'];
                    $f_name = $s['f_name'];
                    $l_name = $s['l_name'];
                    $profile_photo = $s['profile_photo'];
                    $date_posted = $n['date'];
                    $date_posted = new DateTime($date_posted);
                    $date_posted = date_format($date_posted, 'F jS Y');

                    echo
                    '
                    <div class="well">
                    <img src= '.$profile_photo.' class="img-circle" height="50px" width="50px" style="vertical-align:middle;">
                    <span style="color: white; font-size:20px; font-weight:bold; vertical-align:middle; padding:2px;">
                    <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$userID.'">
                        '.$f_name.' '.$l_name.' </a> just posted!</span><small style="color:white; font-weight:normal; font-size:14px; vertical-align:middle; float:right;">'.$date_posted.'</small>

                    </div>
                    ';
                }
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notifications - University Social Network</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="icon" href="res/UoB_Logo.png">
    <link rel="stylesheet" href="profile.css">

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

    <div class="container" style="margin-top: 50px">
        <div class="row">
            <div class="col-sm-12">
                <h1>Notifications</h1>
                <hr>
                <?php echo getNotifications() ?>
            </div>
        </div>

    </div>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>