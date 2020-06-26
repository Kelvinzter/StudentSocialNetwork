<?php
class Comment{
    public static function showComments($postID){
    $UID = Login::isLoggedIn();
    $comments = DB::query('SELECT comment.UID, comment.comment, comment.date_posted, comment.comment_image,
     user.f_name, user.l_name, user.profile_photo
     FROM user, comment 
     WHERE post_ID=:postID 
     AND comment.UID = user.UID
     ORDER BY comment.date_posted DESC', array(':postID' => $postID));

    foreach($comments as $comment){
      $commentUID = $comment['UID'];
      $commentimage = $comment['comment_image'];
      $date_posted = $comment['date_posted'];
      $date_posted = new DateTime($date_posted);
      $date_posted = date_format($date_posted, 'F jS Y');
  
      if($commentimage == null){
         echo'
         <div class="media">
         <div class="media-left">
           <img src="'.$comment['profile_photo'].'" class="img-circle" style="width:60px; vertical-align:middle;">
         </div>
         <div class="media-body">
         <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$comment['UID'].'">
           <h4 class="media-heading" style="font-weight:bold;">'.$comment['f_name'].' '.$comment['l_name'].'</a> <small> Posted on '.$date_posted.'</small>
           </h4>
           <p>'.$comment['comment'].'</p>
         </div>
       </div>
       <br>
       <hr>';
  
      } else if($commentimage != null){
        echo'
         <div class="media">
         <div class="media-left">
           <img src="'.$comment['profile_photo'].'" class="img-circle" style="width:60px; vertical-align:middle;">
         </div>
         <div class="media-body">
         <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$comment['UID'].'">
           <h4 class="media-heading" style="font-weight:bold;">'.$comment['f_name'].' '.$comment['l_name'].'</a> <small> Posted on '.$date_posted.'</small>
           </h4>
           <p>'.$comment['comment'].'</p>
           <img src="'.$commentimage.'" width="50%" style="vertical-align:middle;">
         </div>
       </div>
       <br>
       <hr>';
      }
    }
  }
  
  
  public static function showForumComments($postID){
    $UID = Login::isLoggedIn();
    $type = DB::query('SELECT user.type FROM user WHERE UID=:UID', array(':UID' => $UID))[0]['type'];

    $comments = DB::query('SELECT forum_comment.id, forum_comment.forum_ID, forum_comment.UID, forum_comment.comment, forum_comment.date_posted, forum_comment.comment_image,
     user.f_name, user.l_name, user.profile_photo, user.type
    FROM user, forum_comment 
    WHERE forum_ID=:postID 
    AND forum_comment.UID = user.UID
    ORDER BY forum_comment.date_posted', array(':postID' => $postID));

   foreach($comments as $comment){
    $commentID = $comment['id'];
    $forumID = $comment['forum_ID'];
    $commentimage = $comment['comment_image'];
    $date_posted = $comment['date_posted'];
    $date_posted = new DateTime($date_posted);
    $date_posted = date_format($date_posted, 'F jS Y');

    if($commentimage == null){
       echo'
       <div class="media">
       <div class="media-left">
         <img src="'.$comment['profile_photo'].'" class="img-circle" style="width:60px; vertical-align:middle;">
       </div>
       <div class="media-body">
       <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$comment['UID'].'">
         <h4 class="media-heading" style="font-weight:bold;">'.$comment['f_name'].' '.$comment['l_name'].'</a> <small> Posted on '.$date_posted.'</small>
         </h4>
         '.($type == 'Lecturer' ? '<form action="' . htmlspecialchars('forum-post.php?forumID='.$forumID.'&commentID='.$commentID.'') . '" method="POST" enctype="multipart/form-data">
         <button class="btn btn-danger btn-sm" type="submit" name="deletecomment" style="float:right;">Delete Post</button>
       </form>' : '').' 
         <p>'.$comment['comment'].'</p>
       </div>
     </div>
     <br>
     <hr>';

    } else if($commentimage != null){
      echo'
       <div class="media">
       <div class="media-left">
         <img src="'.$comment['profile_photo'].'" class="img-circle" style="width:60px; vertical-align:middle;">
       </div>
       <div class="media-body">
       <a style="color: white; font-size:20px; font-weight:bold; vertical-align:middle" href= "user-profile.php?UID='.$comment['UID'].'">
         <h4 class="media-heading" style="font-weight:bold;">'.$comment['f_name'].' '.$comment['l_name'].'</a> <small> Posted on '.$date_posted.'</small>
         </h4>
         '.($type == 'Lecturer' ? '<form action="' . htmlspecialchars('forum-post.php?forumID='.$forumID.'&commentID='.$commentID.'') . '" method="POST" enctype="multipart/form-data">
         <button class="btn btn-danger btn-sm" type="submit" name="deletecomment" style="float:right;">Delete Post</button>
       </form>' : '').' 
         <p>'.$comment['comment'].'</p>
         <img src="'.$commentimage.'" width="50%" style="vertical-align:middle;">
       </div>
     </div>
     <br>
     <hr>';
    }
   }
  }
}

?>