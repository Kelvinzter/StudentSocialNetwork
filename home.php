<?php
include('functions/logout.php');
include('functions/header.php');
include('classes/Comment.php');

if (isset($_POST['post'])) {
    $postbody = htmlspecialchars($_POST['postbody']);
    $userLoggedIn = Login::isLoggedIn();
    
    if((strlen($postbody) > 0 && strlen($postbody) < 256) && $_FILES['post_image']['size'] == 0){
        if($userLoggedIn == $UID){

        DB::query('INSERT INTO post VALUES(\'\', :UID, :postbody, :postimage, NOW())', array(':UID'=> $UID, ':postbody' => $postbody, ':postimage' => null));

        }
        
        if(DB::query('SELECT UID FROM follower WHERE UID=:UID', array(':UID' => $UID))){
            $followerID = DB::query('SELECT follower_id FROM follower WHERE UID=:UID', array(':UID' => $UID));
            foreach($followerID as $f){
                $follower = $f['follower_id'];
                DB::query('INSERT INTO notification VALUES(\'\', :type, :receiver, :sender, NOW())', array(':type' => 1, ':receiver' => $follower, ':sender' => $UID));
            }
        }
    }

    if((strlen($postbody) > 0 && strlen($postbody) < 256) && $_FILES['post_image']['size'] > 0){
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
                DB::query('INSERT INTO post VALUES(\'\', :UID, :postbody, :postimage, NOW())', array(':UID'=> $UID, ':postbody' => $postbody, ':postimage' => $postImage));
            } else {
                echo "There was an error uploading this file!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }

        }
        
        if(DB::query('SELECT UID FROM follower WHERE UID=:UID', array(':UID' => $UID))){
            $followerID = DB::query('SELECT follower_id FROM follower WHERE UID=:UID', array(':UID' => $UID));
            foreach($followerID as $f){
                $follower = $f['follower_id'];
                DB::query('INSERT INTO notification VALUES(\'\', :type, :receiver, :sender, NOW())', array(':type' => 1, ':receiver' => $follower, ':sender' => $UID));
            }
        }
    }

    if(strlen($postbody) == 0 && $_FILES['post_image']['size'] > 0){
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
                DB::query('INSERT INTO post VALUES(\'\', :UID, :postbody, :postimage, NOW())', array(':UID'=> $UID, ':postbody' => null, ':postimage' => $postImage));
            } else {
                echo "There was an error uploading this file!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }

        }
        
        if(DB::query('SELECT UID FROM follower WHERE UID=:UID', array(':UID' => $UID))){
            $followerID = DB::query('SELECT follower_id FROM follower WHERE UID=:UID', array(':UID' => $UID));
            foreach($followerID as $f){
                $follower = $f['follower_id'];
                DB::query('INSERT INTO notification VALUES(\'\', :type, :receiver, :sender, NOW())', array(':type' => 1, ':receiver' => $follower, ':sender' => $UID));
            }
        }
    }
    echo "<meta http-equiv='refresh' content='0'>";
}

if (isset($_POST['comment'])) {
    $commentbody = htmlspecialchars($_POST['commentbody']);
    $postID = $_GET['postid'];
    $userLoggedIn = Login::isLoggedIn();

    if((strlen($commentbody) > 0 && strlen($commentbody) < 1024) && $_FILES['post_image']['size'] == 0){
        DB::query('INSERT INTO comment VALUES(\'\', :UID, :postID, :commentbody, :commentimage, NOW())', array(':UID'=> $UID, ':postID' => $postID, ':commentbody' => $commentbody, ':commentimage' => null));
        }
    
        if((strlen($commentbody) > 0 && strlen($commentbody) < 1024) && $_FILES['post_image']['size'] > 0){
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
                        DB::query('INSERT INTO comment VALUES(\'\', :UID, :postID, :commentbody, :commentimage, NOW())', array(':UID'=> $UID, ':postID' => $postID, ':commentbody' => $commentbody, ':commentimage' => $postImage));
                    } else {
                        echo "There was an error uploading this file!";
                    }
                } else {
                    echo "You cannot upload files of this type!";
                }
        
                }
        }
    
        if(strlen($commentbody) == 0 && $_FILES['post_image']['size'] > 0){
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
                        DB::query('INSERT INTO comment VALUES(\'\', :UID, :postID, :commentbody, :commentimage, NOW())', array(':UID'=> $UID, ':postID' => $postID, ':commentbody' => null, ':commentimage' => $postImage));
                    } else {
                        echo "There was an error uploading this file!";
                    }
                } else {
                    echo "You cannot upload files of this type!";
                }
        
                }
        }
}

function get_Posts(){
    $UID = Login::isLoggedIn();
    $followingPosts = DB::query('SELECT post.id, post.post_body, post.post_image, post.date_posted, user.`f_name`, user.`l_name`, user.`UID`, user.`profile_photo`
    FROM user, post, follower
    WHERE post.UID = follower.UID
    AND user.UID = post.UID
    AND follower_id = :UID
    ORDER BY post.date_posted DESC', array(':UID' => $UID));

    foreach($followingPosts as $post){
        
        $userID = $post['UID'];
        $profile_photo = $post['profile_photo'];
        $f_name = $post['f_name'];
        $l_name = $post['l_name'];
        $posts = htmlspecialchars($post['post_body']);
        $postID = $post['id'];
        $postimage = $post['post_image'];
        $date_posted = $post['date_posted'];
        $date_posted = new DateTime($date_posted);
        $date_posted = date_format($date_posted, 'F jS Y');

        if($postimage == null){
            echo '
            <div class="panel panel-default text-left">
            <div class="panel-heading">
                <img src= "'.$profile_photo.'" class="img-circle" height="30px" width="30px" style="vertical-align:middle;">
                <a style="color: black; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$userID.'">
                <span style="color: black; font-size:20px; font-weight:bold; vertical-align:middle">
                '.$f_name.' '.$l_name.'</a></span>
            </div>
            <div class="panel-body" style="color: white;">
                <p style="color: grey;">'.$date_posted.'</p>
                <p style="color: white;">'.$posts.'</p>
                <br><hr>
                
                <p style="text-align:right;"><button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#comment'.$postID.'">Comments  <span class="caret"></span></button>

                <div id="comment'.$postID.'" class="collapse">
                <form action="' . htmlspecialchars('home.php?postid='.$postID.'') . '" method="POST" enctype="multipart/form-data">
                <textarea class="autoExpand" rows="1" data-min-rows="1" name="commentbody"></textarea>
                <br>
                <p style="text-align:left;">
                <button class="btn btn-primary btn-sm" type="submit" name="comment">Comment</button>
                <label class="btn btn-primary btn-sm">Upload Photo
                            <input type="file" name="post_image" style="display: none" onchange="loadCommentImage'.$postID.'(event)"/>
                            </label>
                </p>
                </form>
                <p style="color: white">Image Preview</p>
                                <img id="commentpreview'.$postID.'" width="100px"/>
                <br>';
                
                Comment::showComments($postID);

                echo'
                </div>
            
            
            </div>
            </div>';
            } else if($postimage != null){
                echo '
                <div class="panel panel-default text-left">
                <div class="panel-heading">
                    <img src= "'.$profile_photo.'" class="img-circle" height="30px" width="30px" style="vertical-align:middle;">
                    <a style="color: black; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$userID.'">
                    <span style="color: black; font-size:20px; font-weight:bold; vertical-align:middle">
                    '.$f_name.' '.$l_name.'</a></span>
                </div>
                <div class="panel-body" style="color: white;">
                    <p style="color: grey;">'.$date_posted.'</p>
                    <p style="color: white;">'.$posts.'</p>
                    <img src="'.$postimage.'" height ="100%" width="100%" style="vertical-align:middle;">
                    <br><hr>
                    
                    <p style="text-align:right;"><button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#comment'.$postID.'">Comments  <span class="caret"></span></button>
        
                    <div id="comment'.$postID.'" class="collapse">
                    <form action="' . htmlspecialchars('home.php?postid='.$postID.'') . '" method="POST" enctype="multipart/form-data">
                    <textarea class="autoExpand" rows="1" data-min-rows="1" name="commentbody"></textarea>
                    <br>
                    <p style="text-align:left;">
                <button class="btn btn-primary btn-sm" type="submit" name="comment">Comment</button>
                <label class="btn btn-primary btn-sm">Upload Photo
                            <input type="file" name="post_image" style="display: none" onchange="loadCommentImage'.$postID.'(event)"/>
                            </label>
                </p>
                </form>
                <p style="color: white">Image Preview</p>
                                <img id="commentpreview'.$postID.'" width="100px"/>
                <br>';
                    Comment::showComments($postID);
        
                    echo'
                    </div>
                
                
                </div>
                </div>';

                
            }
            echo '
            <script type="text/javascript">
            var loadCommentImage'.$postID.' = function(event) {
                var output = document.getElementById("commentpreview'.$postID.'");
                output.src = URL.createObjectURL(event.target.files[0]);
                };
            </script>
            '; 
        
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - University Social Network</title>
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

        table {
            border-collapse: separate;
            border-spacing: 30px;
        }

        td {
            color: white;
            font-family: 'Montserrat', sans-serif;
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

    <div class="container" style="margin-top: 70px;">
        <div class="row">
            <!-- Left column -->
            <div class="col-sm-3 text-center">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="well">
                            <a href="profile.php"><img src="<?php echo $profile_photo;?>" class="img-circle" height="100"
                                    width="100" alt="profilepicture"></a>
                            <h1 style="font-size: 30px;"><?php echo $f_name;?> <?php echo $l_name;?></h1>
                            <hr>
                            <h5><span class="glyphicon glyphicon-pencil"></span> <?php echo $course;?></h5>
                            <h5><span class="glyphicon glyphicon-education"></span> <?php echo $university;?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle column -->
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default text-left">
                            <div class="panel-heading">Create a post</div>
                            <div class="panel-body">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <p><textarea class="autoExpand" rows="2" data-min-rows="2" name="postbody" placeholder="What's up?"></textarea></p>
                                <p><button class="btn btn-primary btn-sm" type="submit" name="post">Post</button>
                                <label class="btn btn-primary btn-sm">Upload Photo
                        <input type="file" name="post_image" style="display: none" onchange="loadImage(event)"/>
                        </label>
                        </form>
                        <p style="color: white">Image Preview</p>
                            <img id="preview" width="100px"/>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <?php echo get_Posts()?>
                        

                    </div>
                </div>
            </div>

            <!-- Right column -->
            <div class="col-sm-4">

                <div class="row">
                    <div class="panel panel-default text-left">
                        <div class="panel-heading">Quote of the Day</div>
                        <div class="panel-body">
                            <p>"Success is not final, failure is not fatal. It's the courage to continue that
                                counts."
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <h5 align="center">Copyright © Kelvin Chua | Designed by Kelvin Chua</h5>
                </div>

            </div>
        </div>
    </div>

<script>
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