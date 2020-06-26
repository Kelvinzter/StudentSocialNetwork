<?php
include('functions/logout.php');
include('functions/header.php');
include('classes/Comment.php');

$UID = Login::isLoggedIn();

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

if(isset($_POST['deletepost'])){
    $postid = DB::query('SELECT id FROM post WHERE id=:postID AND UID=:UID', array(':postID'=> $_GET['postid'] ,':UID'=>$UID))[0]['id'];
    if (DB::query('SELECT id FROM post WHERE id=:postid AND UID=:UID', array(':postid'=> $postid, ':UID'=>$UID))) {
        DB::query('DELETE FROM post WHERE id=:postid AND UID=:UID', array(':postid'=> $postid, ':UID'=>$UID));
}
}



function get_User_Posts(){
    $UID = Login::isLoggedIn();

    $userposts = DB::query('SELECT * FROM post WHERE UID=:UID ORDER BY id DESC', array(':UID'=> $UID));
    $user = DB::query('SELECT * FROM user WHERE UID=:UID', array(':UID'=> $UID)); 

    $posts = "";
    foreach($userposts as $p){
        foreach($user as $u){
            $profile_photo = $u['profile_photo'];
            $f_name = $u['f_name'];
            $l_name = $u['l_name'];
            $posts = htmlspecialchars($p['post_body']);
            $postID = $p['id'];
            $postimage = $p['post_image'];
            $date_posted = $p['date_posted'];
            $date_posted = new DateTime($date_posted);
            $date_posted = date_format($date_posted, 'F jS Y');

            if($postimage == null){
            echo '
            <div class="panel panel-default text-left">
            <div class="panel-heading">
                <img src= "'.$profile_photo.'" class="img-circle" height="30px" width="30px" style="vertical-align:middle;">
                <span style="color: black; font-size:20px; font-weight:bold; vertical-align:middle">
                '.$f_name.' '.$l_name.'</span>
                <div class="panel-title pull-right">
                <form action="' . htmlspecialchars('profile.php?postid='.$postID.'') . '" method="POST" enctype="multipart/form-data">
                <button class="btn btn-danger btn-sm" type="submit" name="deletepost" style="text-align:right;">Delete Post</button>
                </form>
                </div>
            </div>
            <div class="panel-body" style="color: white;">
                <p style="color: grey;">'.$date_posted.'</p>
                <p style="color: white;">'.$posts.'</p>
                <br><hr>
                
                <p style="text-align:right;"><button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#comment'.$postID.'">Comments  <span class="caret"></span></button>

                <div id="comment'.$postID.'" class="collapse">
                <form action="' . htmlspecialchars('profile.php?postid='.$postID.'') . '" method="POST" enctype="multipart/form-data">
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
                <span style="color: black; font-size:20px; font-weight:bold; vertical-align:middle">
                '.$f_name.' '.$l_name.'</span>
                <div class="panel-title pull-right">
                <form action="' . htmlspecialchars('profile.php?postid='.$postID.'') . '" method="POST" enctype="multipart/form-data">
                <button class="btn btn-danger btn-sm" type="submit" name="deletepost" style="text-align:right;">Delete Post</button>
                </form>
                </div>
            </div>
            <div class="panel-body" style="color: white;">
                <p style="color: grey;">'.$date_posted.'</p>
                <p style="color: white;">'.$posts.'</p>
                <img src="'.$postimage.'" height ="100%" width="100%" style="vertical-align:middle;">
                <br><hr>
                
                <p style="text-align:right;"><button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#comment'.$postID.'">Comments  <span class="caret"></span></button>

                <div id="comment'.$postID.'" class="collapse">
                <form action="' . htmlspecialchars('profile.php?postid='.$postID.'') . '" method="POST" enctype="multipart/form-data">
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

}

if(isset($_POST['update_cover'])){
    $UID = Login::isLoggedIn();
    $image = $_FILES['cover_photo'];

    $imageName = $_FILES['cover_photo']['name'];
    $imageTmpName = $_FILES['cover_photo']['tmp_name'];
    $imageError = $_FILES['cover_photo']['error'];

    $imageExt = explode('.', $imageName);
    $imageActualExt = strtolower(end($imageExt));

    $allowedExtensions = array('jpg', 'jpeg', 'png');

    if(in_array($imageActualExt, $allowedExtensions)){
        if($imageError === 0){
            $random = rand(1,100);
            $imageNameNew = "cover".$UID.".".$imageActualExt.$random;
            $imageDestination = 'uploads/'.$imageNameNew;
            move_uploaded_file($imageTmpName, $imageDestination);
            $newCoverImage = 'uploads/'.$imageNameNew;
            DB::query('UPDATE user SET profile_cover=:profile_cover WHERE UID=:UID', array(':profile_cover' => $newCoverImage, ':UID' => $UID));
            header("Location: profile.php");
        } else {
            echo "There was an error uploading this file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
    echo "<meta http-equiv='refresh' content='0'>";
}

if(isset($_POST['delete_cover'])){
    $UID = Login::isLoggedIn();
    DB::query('UPDATE user SET profile_cover=:profile_cover WHERE UID=:UID', array(':profile_cover' => 'res/default-cover.jpg',':UID' => $UID));
    echo "<meta http-equiv='refresh' content='0'>";
}

if(isset($_POST['update_profile_photo'])){
    $UID = Login::isLoggedIn();
    $image = $_FILES['profile_photo'];

    $imageName = $_FILES['profile_photo']['name'];
    $imageTmpName = $_FILES['profile_photo']['tmp_name'];
    $imageError = $_FILES['profile_photo']['error'];

    $imageExt = explode('.', $imageName);
    $imageActualExt = strtolower(end($imageExt));

    $allowedExtensions = array('jpg', 'jpeg', 'png');

    if(in_array($imageActualExt, $allowedExtensions)){
        if($imageError === 0){
            $random = rand(1,100);
            $imageNameNew = "profile".$UID.".".$imageActualExt.$random;
            $imageDestination = 'uploads/'.$imageNameNew;
            move_uploaded_file($imageTmpName, $imageDestination);
            $newProfilePhoto = 'uploads/'.$imageNameNew;
            DB::query('UPDATE user SET profile_photo=:profile_photo WHERE UID=:UID', array(':profile_photo' => $newProfilePhoto, ':UID' => $UID));
            header("Location: profile.php");
        } else {
            echo "There was an error uploading this file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
    echo "<meta http-equiv='refresh' content='0'>";
}

if(isset($_POST['delete_profile_photo'])){
    $UID = Login::isLoggedIn();
    DB::query('UPDATE user SET profile_photo=:profile_photo WHERE UID=:UID', array(':profile_photo' => 'res/default-profile.png',':UID' => $UID));
    echo "<meta http-equiv='refresh' content='0'>";
}
   
function get_interests(){
    $UID = Login::isLoggedIn();
    $interests = DB::query('SELECT interest FROM user WHERE UID=:UID', array(':UID' => $UID))[0]['interest'];
    $interestsArray = explode(',', $interests);

    foreach($interestsArray as $a){
        echo '
        <span class="label label-primary">'.$a.'</span>
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
    <title>Profile - University Social Network</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="icon" href="res/UoB_Logo.png">
    <link rel="stylesheet" href="profile.css">

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

        input[type=file]{
            display: none;
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
        <!-- Profile Cover -->
        <div class="row">

            <div class="col-sm-10">
                <div>
                    <img src="<?php echo $profile_cover;?>" class="img-rounded " alt="profile-cover" id="profile-cover">
                </div>

                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <ul class="nav pull-left" style="position:absolute; top:10px; left:25px;">
                 <li class="dropdown">
                    <button class="dropdown-toggle btn btn-default" data-toggle="dropdown">Edit Cover Photo</button>
                    <div class="dropdown-menu">
                        <center>
                        <p style="color:black;">Click <strong>Select Cover Photo</strong> and then click <strong>Update</strong></p>
                        <label class="btn btn-info">Select Cover Photo
                        <input type="file" name="cover_photo" size="60"/>
                        </label><br><br>
                        <button name="update_cover" type="submit" class="btn btn-info">Update</button> 
                        <br><br>  
                        <button name="delete_cover" type="submit" class="btn btn-info">Remove</button>
                        </center>

                    </div>
                 </li>
                </ul>
                </form>
                

                <div>
                    <img src="<?php echo $profile_photo;?>" class="img-circle" alt="profile-picture"
                        id="profile-picture">
                    <h1 id="profile-name"><?php echo $f_name;?> <?php echo $l_name;?></h1>
                </div>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <ul class="nav pull-left" style="position:absolute; top:10px; left:200px;">
                 <li class="dropdown">
                    <button class="dropdown-toggle btn btn-default" data-toggle="dropdown">Edit Profile Photo</button>
                    <div class="dropdown-menu">
                        <center>
                        <p style="color:black;">Click <strong>Select Profile Photo</strong> and then click <strong>Update</strong></p>
                        <label class="btn btn-info">Select Profile Photo
                        <input type="file" name="profile_photo" size="60"/>
                        </label><br><br>
                        <button name="update_profile_photo" type="submit" class="btn btn-info">Update</button>   
                        <br><br>  
                        <button name="delete_profile_photo" type="submit" class="btn btn-info">Remove</button>
                        </center>

                    </div>
                 </li>
                </ul>
                </form>

            </div>

            

            <div class="col-sm-2">
            </div>
        </div>

        <!-- Main Body -->
        <div class="row">
            <!-- About Section -->
            <div class="col-sm-4">
                <div class="well about">
                    <h1 style="text-align: center">About Me</h1>
                    <hr>

                    <h5 style="text-align: left;">Bio</h5>
                    <p style="text-align: center;"><?php echo $about;?></p>
                    <hr>

                    <h5 style="text-align: left;">Education</h5>
                    <p style="text-align: center;">Course: <?php echo $course;?></p>
                    <p style="text-align: center;">University: <?php echo $university;?></p>
                    <hr>

                    <h5 style="text-align: left;">Info</h5>
                    <p style="text-align: center;">Country: <?php echo $country;?></p>
                    <p style="text-align: center;">Birthday: <?php echo $birthday;?></p>
                    <hr>

                    <h5 style="text-align: left;">Interests</h5>
                    <p style="text-align: center;"><?php echo get_interests();?></p>
                    
                </div>

                <div class="row">
                    <h5 align="center">Copyright © Kelvin Chua | Designed by Kelvin Chua</h5>
                </div>
            </div>

            <div class="col-sm-6">
                <!-- Post -->
                <div class="panel panel-default text-left">
                    <div class="panel-heading">Create a post</div>
                    <div class="panel-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                            <p><textarea class="autoExpand" rows="2" data-min-rows="2" name="postbody" placeholder="What's up?"></textarea></p>
                            <p><button class="btn btn-primary btn-sm" type="submit" name="post">Post</button>
                            <label class="btn btn-primary btn-sm">Upload Photo
                        <input type="file" name="post_image" onchange="loadImage(event)"/>
                        </label></p>
                        </form>
                            <p style="color: white">Image Preview</p>
                            <img id="preview" width="100px"/>
                    </div>
                </div>

                <!--User Posts -->
                <?php echo get_User_Posts()?>
                 

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