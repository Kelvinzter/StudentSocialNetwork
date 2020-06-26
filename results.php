<?php
include('functions/logout.php');
include('functions/header.php');

function get_user(){
if(isset($_POST['search_user'])){
    $search_query = explode(" ",htmlspecialchars($_POST['search_user']));
    if(count($search_query) == 1){
        $search_query = str_split($search_query[0], 2);
    }

    $paramsarray = array(':search_query' => '%'.$_POST['search_user'].'%');
    
    $users = DB::query('SELECT * FROM user WHERE f_name LIKE :search_query OR l_name LIKE :search_query OR course LIKE :search_query',
    $paramsarray);
    


 foreach($users as $u){
     $UID = $u['UID'];
     $f_name = $u['f_name'];
     $l_name = $u['l_name'];
     $profile_photo = $u['profile_photo'];
     $course = $u['course'];

     if($course == null){
        echo '
     <div class="well">
     <img src= '.$profile_photo.' class="img-circle" height="50px" width="50px" style="vertical-align:middle; margin-right: 1rem">
     <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$UID.'">
     <span style="color: white; font-size:20px; font-weight:bold; vertical-align:middle; padding:2px;">
        '.$f_name.' '.$l_name.'</span> 
        </a>
     </div>
     ';

     } else {
     echo '
     <div class="well">
     <img src= '.$profile_photo.' class="img-circle" height="50px" width="50px" style="vertical-align:middle; float:left; margin-right: 1rem">
     <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$UID.'">
     <span style="color: white; font-size:20px; font-weight:bold; vertical-align:middle; padding:2px;">
        '.$f_name.' '.$l_name.'</a> <br> <p style="color:white;">'.$course.'</p></span> 
    
     </div>
     ';
     }
  }
}
 
}

function get_forum(){
    if(isset($_POST['search_user'])){
        $search_query = explode(" ",htmlspecialchars($_POST['search_user']));
        if(count($search_query) == 1){
            $search_query = str_split($search_query[0], 2);
        }
    
        $paramsarray = array(':search_query' => '%'.$_POST['search_user'].'%');
        
        $forums = DB::query('SELECT * 
        FROM forum_post
        JOIN user
        ON forum_post.UID = user.UID 
        WHERE forum_topic LIKE :search_query
        OR forum_body LIKE :search_query
        ORDER BY forum_post.date_posted DESC',
        $paramsarray);
        
    
     foreach($forums as $f){
        $profile_photo = $f['profile_photo'];
        $f_name = $f['f_name'];
        $l_name = $f['l_name'];
        $topic = $f['forum_topic'];
        $postID = $f['id'];
    
        
        echo
        '
            <div class="panel panel-default text-left">
            <div class="panel-heading">
                <img src= "'.$profile_photo.'" class="img-circle" height="50px" width="50px" style="vertical-align:middle; float:left; margin-right: 1rem">
                <p><span style="color: black; font-size:20px; font-weight:bold; vertical-align:middle">
                <a style="color: black; font-size:20px; font-weight:bold; vertical-align:middle" href= "forum-post.php?forumID='.$postID.'">
                '.$topic.'<br> </a>'.$f_name.' '.$l_name.'</span></p>
      
            </div>
            </div>';
      }
    }
     
    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results - University Social Network</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <link rel="icon" href="res/UoB_Logo.png">
    <link rel="stylesheet" href="index.css">
    <style>
        .nav-tabs {
            border: 1px solid white;
            padding-top: 0px;
            width: 100%;
        }

        .nav-tabs>li {
            width: 50%;
            text-align: center;
        }

        .nav-tabs>li>a {
            border-radius: 0 0 0 0;
            margin-right: 0;
            display: block;
            color: white;
            
        }

        .nav-tabs>li>a:hover {
            border-radius: 0 0 0 0;
            margin-right: 0;
            display: block;
            color: black;
            background-color: white;
        }

        .nav-tabs>li.active>a,
        .nav-tabs>li.active>a:hover,
        .nav-tabs>li.active>a:focus {
            color: black;
            border-bottom-color: white;
            border-right-color: transparent;
        }

        [contenteditable=true]:empty::before {
            content: attr(placeholder);
            color: grey;
        }

        textarea {
            border: 1px solid white;
            padding: 5px;
            resize: none;
            width: 100%;
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
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="navbar-form navbar-left" enctype="multipart/form-data">
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

    <div class="container" style="margin-top: 70px;">
        <div class="row">
            <!-- Left column -->
            <div class="col-sm-3 text-center">
                <div class="row">
                    <div class="col-sm-13">
                        
                    </div>
                </div>
            </div>

            <!-- Middle column -->
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 style="text-align:center">Results</h1>
                        <hr>
                        <br>
                    
                    <ul class="nav nav-tabs" id="myTab" data-tabs="tabs">
                        <li class="active"><a data-toggle="tab" href="#users">Users</a></li>
                        <li><a data-toggle="tab" href="#forums">Forums</a></li>
                    </ul>
                    <br>
               
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="users">
                            <?php echo get_user() ?>
                        </div>

                        <div class="tab-pane fade in" id="forums">
                            <?php echo get_forum() ?>
                        </div>
                    </div>

                    </div>
                </div>
            </div>

            <!-- Right column -->
            <div class="col-sm-3">
                <div class="row">
                    
                </div>

            </div>
        </div>
    </div>

<script>
     $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>