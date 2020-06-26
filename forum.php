<?php
include('functions/logout.php');
include('functions/header.php');
include('classes/Comment.php');

$UID = Login::isLoggedIn();

if (isset($_POST['postforum'])) {
    $forumtopic = htmlspecialchars($_POST['forumtopic']);
    $forumbody = htmlspecialchars($_POST['forumbody']);
    $userLoggedIn = Login::isLoggedIn();

    if($_FILES['post_image']['size'] == 0){
    DB::query('INSERT INTO forum_post VALUES(\'\', :UID, :forumtopic, :forumbody, :forumimage, NOW())', array(':UID'=> $UID, ':forumtopic'=> $forumtopic,':forumbody' => $forumbody, ':forumimage' => null));
    }

    if($_FILES['post_image']['size'] > 0){
        if($userLoggedIn == $UID){
            $postimage = $_FILES['post_image'];
            $imageName = $_FILES['post_image']['name'];
            $imageTmpName = $_FILES['post_image']['tmp_name'];
            $imageError = $_FILES['post_image']['error'];
        
            $imageExt = explode('.', $imageName);
            $imageActualExt = strtolower(end($imageExt));
        
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            if(in_array($imageActualExt, $allowedExtensions)){
                if($imageError === 0){
                    $random = rand(1,100);
                    $imageNameNew = $imageName;
                    $imageDestination = 'imagepost/'.$imageNameNew;
                    move_uploaded_file($imageTmpName, $imageDestination);
                    $postImage = 'imagepost/'.$imageNameNew;
                    DB::query('INSERT INTO forum_post VALUES(\'\', :UID, :forumtopic, :forumbody, :forumimage, NOW())', array(':UID'=> $UID, ':forumtopic'=> $forumtopic,':forumbody' => $forumbody, ':forumimage' => $postImage));
                } else {
                    echo "There was an error uploading this file!";
                }
            } else {
                echo "You cannot upload files of this type!";
            }
    
            }
    }
}

function get_forum_posts(){

$forumposts = DB::query('SELECT * 
FROM forum_post, user 
WHERE user.UID = forum_post.UID
ORDER BY forum_post.date_posted DESC');

foreach($forumposts as $f){
    $profile_photo = $f['profile_photo'];
    $f_name = $f['f_name'];
    $l_name = $f['l_name'];
    $topic = $f['forum_topic'];
    $postID = $f['id'];
    $date_posted = $f['date_posted'];
    $date_posted = new DateTime($date_posted);
    $date_posted = date_format($date_posted, 'F jS Y');
    
    echo
    '
        <div class="panel panel-default text-left">
        <div class="panel-heading">
            <img src= "'.$profile_photo.'" class="img-circle" height="50px" width="50px" style="vertical-align:middle; float:left; margin-right: 1rem">
            <p><span style="color: black; font-size:20px; font-weight:bold; vertical-align:middle">
            <a style="color: black; font-size:20px; font-weight:bold; vertical-align:middle" href= "forum-post.php?forumID='.$postID.'">
            '.$topic.' </a> <small style="color:black; font-weight:normal; font-size:14px; vertical-align:middle"> Posted on '.$date_posted.'</small><br> '.$f_name.' '.$l_name.'</span></p>
  
        </div>
        </div>';
}

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - University Social Network</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <link rel="icon" href="res/UoB_Logo.png">
    <link rel="stylesheet" href="index.css">
    <style>

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
                <form action="<?php echo htmlspecialchars("results.php"); ?>" method="POST" class="navbar-form navbar-left" enctype="multipart/form-data">
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
            <div class="col-sm-12">
                <h1>Forum</h1>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="well about">
                    <h1 style="text-align: center">Rules</h1>
                    <hr>

                    <h4 style="text-align: left;">1. Only lecturers are allowed to create forums </h4>
                    <hr>

                    <h4 style="text-align: justify;">2. No Racism </h4>
                    <hr>

                    <h4 style="text-align: justify;">3. No Toxicity </h4>
                    <hr>

                    <h4 style="text-align: justify;">4. No Politics </h4>
                    <hr>

                    <h4 style="text-align: left;">5. Participation is highly encouraged </h4>
                    <hr>
                    
                    <h4 style="text-align: left;">6. Any breach of the rules will result in an immediate ban and expulsion </h4>
                    <hr>

                </div>
            </div>

            <div class="col-sm-8">
                <h1 style="text-align: center">Posts</h1>

        <?php 
        if($type == "Lecturer"){
        echo'
        <div class="row">
            <!-- Left Column-->
            <div class="col-sm-12">
                <div class="panel panel-default text-left">
                    <div class="panel-heading">Create a forum</div>
                    <div class="panel-body">
                        <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST" enctype="multipart/form-data">
                        <p>Topic:<textarea class="autoExpand" rows="1" data-min-rows="1" name="forumtopic" required></textarea><p>
                           <p>Body:<textarea class="autoExpand" rows="2" data-min-rows="2" name="forumbody" required></textarea><p>
                            <p><button class="btn btn-primary btn-sm" type="submit" name="postforum">Post</button>
                            <label class="btn btn-primary btn-sm">Upload Photo
                        <input type="file" name="post_image" style="display: none" onchange="loadImage(event)"/>
                        </label></p>
                        </form>
                        <p style="color: white">Image Preview</p>
                            <img id="preview" width="100px"/>
                    </div>
                </div>';
        }
        ?>

            <?php echo get_forum_posts();?>
            </div>

        </div>
                

    </div>
        
        </div>
    </div>

<script>
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

    var loadImage = function(event) {
    var output = document.getElementById('preview');
    output.src = URL.createObjectURL(event.target.files[0]);
  };

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>