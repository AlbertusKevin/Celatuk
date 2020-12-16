<?php

class Helper extends Controller{
    public static function isBookmarked($username){
        $saved = self::model('Post_Model')->retrieveBookmark($username);

        $arrayId = [];
        
        if(!empty($saved)){
            foreach ($saved as $save){
                $arrayId[] = $save['id'];
            }
        }

        return $arrayId;
    }

    public static function isLiked($username){
        $likes = self::model('Post_Model')->likedPost($username);

        $likedID = [];
        
        if(!empty($likes)){
            foreach ($likes as $liked){
                $likedID[] = $liked['id'];
            }
        }

        return $likedID;
    }

    public static function getCommentPostId($id){
        return self::model("Comment_Model")->getPostCommentById($id);
    }
}