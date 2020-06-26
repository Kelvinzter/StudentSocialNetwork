<?php
include('functions/logout.php');
include('classes/Comment.php');

$isFollowing = FALSE;

$UID = Login::isLoggedIn();

if(isset($_GET['UID'])){
    if(DB::query('SELECT UID FROM user WHERE UID=:UID', array(':UID' => $_GET['UID']))){
        $UID = $_GET['UID'];
        $username = DB::query('SELECT username FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['username'];
        $email = DB::query('SELECT email FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['email'];
        $f_name = DB::query('SELECT f_name FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['f_name'];
        $l_name = DB::query('SELECT l_name FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['l_name'];
        $country = DB::query('SELECT country FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['country'];
        $birthday = DB::query('SELECT birthday FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['birthday'];
        $course = DB::query('SELECT course FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['course'];
        $university = DB::query('SELECT university FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['university'];
        $about = DB::query('SELECT about FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['about'];
        $profile_photo = DB::query('SELECT profile_photo FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['profile_photo'];
        $profile_cover = DB::query('SELECT profile_cover FROM user WHERE UID = :UID', array(':UID' => $UID))[0]['profile_cover'];

        $userID = DB::query('SELECT UID FROM user WHERE UID=:UID', array(':UID' => $UID))[0]['UID'];
        $followerID = Login::isLoggedIn();
            
        if($UID < 0 || $UID == ""){
            header('Location: index.php');
            exit();
        }

        if($UID == Login::isLoggedIn()){
            header('Location: profile.php');
            exit();
            }

        if(isset($_POST['follow'])){

            if($userID != $followerID){

                if(!DB::query('SELECT follower_id FROM follower WHERE UID=:UID AND follower_id = :followerID', array(':UID' => $userID, ':followerID' => $followerID))){
                    DB::query('INSERT INTO follower VALUES(\'\', :UID, :followerID)', array(':UID' => $userID, ':followerID' => $followerID));
                }
                $isFollowing = TRUE;
            }
        }

        if(isset($_POST['unfollow'])){

            if($userID != $followerID){

                if(DB::query('SELECT follower_id FROM follower WHERE UID=:UID AND follower_id = :followerID', array(':UID' => $userID, ':followerID' => $followerID))){
                    DB::query('DELETE FROM follower WHERE UID=:UID AND follower_id=:followerID', array(':UID' => $userID, ':followerID' => $followerID));
                }
                $isFollowing = FALSE;
            }
        }

        if(DB::query('SELECT follower_id FROM follower WHERE UID=:UID AND follower_id = :followerID', array(':UID' => $userID, ':followerID' => $followerID))){
            $isFollowing = TRUE;
        }
    
  } 

} 



function get_User_Posts(){
    $UID = $_GET['UID'];
    
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
                    <a style="color: black; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$UID.'">
                    <span style="color: black; font-size:20px; font-weight:bold; vertical-align:middle">
                    '.$f_name.' '.$l_name.'</a></span>
                </div>
                <div class="panel-body" style="color: white;">
                    <p style="color: grey;">'.$date_posted.'</p>
                    <p style="color: white;">'.$posts.'</p>
                    <br><hr>
                    
                    <p style="text-align:right;"><button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#comment'.$postID.'">Comments  <span class="caret"></span></button>
        
                    <div id="comment'.$postID.'" class="collapse">
                    <form action="' . htmlspecialchars('user-profile.php?UID='.$UID.'&postid='.$postID.'') . '" method="POST" enctype="multipart/form-data">
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
                        <a style="color: black; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$UID.'">
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
                        <form action="' . htmlspecialchars('user-profile.php?UID='.$UID.'&postid='.$postID.'') . '" method="POST" enctype="multipart/form-data">
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

if (isset($_POST['comment'])) {
        $commentbody = htmlspecialchars($_POST['commentbody']);
        $postID = $_GET['postid'];
        $UID = Login::isLoggedIn();
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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

        #follow-button {
            position: absolute;
            top: 350px;
            left: 870px;
        }

        #unfollow-button {
            position: absolute;
            top: 350px;
            left: 870px;
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
            <form action = "<?php echo htmlspecialchars("results.php"); ?>" method = "POST" class="navbar-form navbar-left">
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

                <div>
                    <img src="<?php echo $profile_photo;?>" class="img-circle" alt="profile-picture"
                        id="profile-picture">
                    <h1 id="profile-name"><?php echo $f_name;?> <?php echo $l_name;?></h1>
                    <form action="<?php echo htmlspecialchars("user-profile.php?UID=$UID"); ?>" method="POST" enctype="multipart/form-data">
                    <?php
                    if($isFollowing){
                    echo '<button type="submit" class="btn btn-danger" id="unfollow-button" name="unfollow">Unfollow</button>';
                    } else{
                    echo '<button type="submit" class="btn btn-success" id="follow-button" name="follow">Follow</button>';
                    }
                    ?>
                    </form>
                </div>

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

                </div>
            </div>

            <div class="col-sm-6">

                <!--Timeline -->
                
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

    var loadCommentImage = function(event) {
    var output = document.getElementById('commentpreview');
    output.src = URL.createObjectURL(event.target.files[0]);
    };

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
</body>



</html>