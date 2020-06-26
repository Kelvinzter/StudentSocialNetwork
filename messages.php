<?php
include('functions/logout.php');

$sender = Login::isLoggedIn();

if(isset($_GET['UID'])){
    if(DB::query('SELECT UID FROM user WHERE UID=:receiver', array(':receiver' => $_GET['UID']))){
    $receiver = $_GET['UID'];
    $getReceiver = DB::query('SELECT * FROM user WHERE UID=:receiver', array(':receiver' => $receiver));

    foreach($getReceiver as $r){
        $receiverID = $r['UID'];
        $receiverName = $r['username'];
    }
  } else{
      header('Location: messages.php');
      exit();
  }

} else if(isset($_GET['UID']) == NULL){
    $receiverID = NULL;
}

if(isset($_POST['sendMessage'])){
    $message = htmlspecialchars($_POST['messagebody']);

    if(strlen($message) > 0 && strlen($message) < 256){
        DB::query('INSERT INTO message VALUES(\'\', :body, :sender, :receiver, NOW())', array(':body'=> $message, ':sender' => $sender, ':receiver' => $receiverID));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Messages - University Social Network</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="icon" href="res/UoB_Logo.png">
    <link rel="stylesheet" href="profile.css">
    <style>
         

        textarea {
            border: 1px solid white;
            padding: 5px;
            resize: none;
            width: 100%;
            background: black;
            color: white;
        }

        #scroll-messages{
            max-height: 410px;
            overflow: auto;
        }

        #select_user{
            max-height: 500px;
            overflow: auto;
        }

        #black{
            background-color: black;
            color: white;
            border: 1px solid white;
            width: 40%;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 5px;
            float: right;
            margin-right: 10px;
        }

        #white{
            background-color: white;
            color: black;
            border: 1px solid black;
            width: 40%;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 5px;
            float: left;
            margin-left: 10px;
            overflow: hidden;
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

    <div class="container" style="margin-top: 50px">
        <div class="row">
            <div class="col-sm-12">
        <h1>Messages</h1>
        <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3" id="select_user">
            <?php 
                $users = DB::query('SELECT * FROM user WHERE NOT UID=:sender ', array(':sender' => $sender));

                foreach($users as $u){
                    $userID = $u['UID'];
                    $f_name = $u['f_name'];
                    $l_name = $u['l_name'];
                    $userImage = $u['profile_photo'];
                

                echo'
                <div class="container-fluid">
                    <img src= '.$userImage.' class="img-circle" height="50px" width="50px" style="vertical-align:middle;">
                    <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "messages.php?UID='.$userID.'">
                    <span style="color: white; font-size:20px; font-weight:bold; vertical-align:middle; padding:2px;">
                        '.$f_name.' '.$l_name.'</span> 
                    </a>
                    <hr>
                    <br>
                </div>
                ';
                }
            ?>
            </div>

            <div class="col-sm-9">
            <?php
                if(isset($_GET['UID'])){
                $UID = $_GET['UID'];

                $user = DB::query('SELECT * FROM user WHERE UID=:UID', array(':UID' => $UID));
                foreach($user as $u){
                    $userID = $u['UID'];
                    $userImage = $u['profile_photo'];
                    $f_name = $u['f_name'];
                    $l_name = $u['l_name'];

                echo '
                <div class="well" style="padding:10px;">
                    <img src= '.$userImage.' class="img-circle" height="30px" width="30px" style="vertical-align:middle;">
                    <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$userID.'">
                    <span style="color: white; font-size:20px; font-weight:bold; vertical-align:middle; padding:2px;">
                        '.$f_name.' '.$l_name.'</span> 
                    </a>
                </div>
                ';
                }
            }
            ?>
                <div class="messages" id="scroll-messages">
                    <?php
                        $messages = DB::query('SELECT * FROM message
                        WHERE (receiver=:receiver AND sender=:sender)
                        OR (receiver=:sender AND sender=:receiver)  
                        ORDER BY 1 ASC', array(':receiver' => $receiverID, ':sender' => $sender));

                         foreach($messages as $m){
                             $receiver = $m['receiver'];
                             $senderID = $m['sender'];
                             $message = $m['body'];
                             $message_date = $m['date'];
                            ?>

                            <div id="loaded_messages">
                                <p>
                                <?php
                                    if($receiver == $receiverID AND $senderID == $sender){
                                        echo '
                                        <div class="message" id="black" data-toggle="tooltip" title="'.$message_date.'">
                                        '.$message.'
                                        </div><br><br>
                                        ';
                                    } else if($senderID == $receiverID AND $receiver == $sender){
                                        echo '
                                        <div class="message" id="white" data-toggle="tooltip" title="'.$message_date.'">
                                        '.$message.'
                                        </div><br><br>
                                        ';
                                    }
                                ?>
                                </p>
                            </div>
                            <?php
                         }
                        
                    ?>
                    
                </div>

                <?php
                    if(isset($_GET['UID']) == NULL){

                        echo'
                        <p style="text-align: center;">Select someone to start a conversation</p>
                        ';
                    }
                    else{
                        echo '
                        <form action="' . htmlspecialchars('messages.php?UID='.$receiverID.'') . '" method="POST" enctype="multipart/form-data">
                        <textarea class="autoExpand" rows="2" data-min-rows="2" name="messagebody" placeholder="Type a message..."></textarea>
                        <br>
                        <p style="text-align:right;"><button class="btn btn-primary btn-sm" type="submit" name="sendMessage">Send</button></p>
                        </form>
                        <br>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>


<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

    var div = document.getElementById("scroll-messages");
    div.scrollTop = div.scrollHeight;
</script>
</body>

</html>