<?php

class Message{
//========================================================================================================================================
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~set message~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//========================================================================================================================================
    public static function setUsername404(){
        $_SESSION['username404'] = true;
    }

    public static function setPassword406(){
        $_SESSION['password406'] = true;
    }

    public static function setCookie404(){
        $_SESSION['cookie404'] = true;
    }

    public static function setCookie406(){
        $_SESSION['cookie406'] = true;
    }

    public static function setPicture404(){
        $_SESSION['picture404'] = true;
    }

    public static function setPicture406(){
        $_SESSION['picture406'] = true;
    }

    public static function setConfPassword406(){
        $_SESSION['ConfPassword406'] = true;
    }

    public static function setRegister200(){
        $_SESSION['register200'] = true;
    } 

    public static function setEmail404(){
        $_SESSION['email404'] = true;
    }

    public static function setEmail200(){
        $_SESSION['email200'] = true;
    }

    public static function setUpdatePassword200(){
        $_SESSION['updatePassword200'] = true;
    }

    public static function setUniqueUsername406(){
        $_SESSION['uniqueUsername406'] = true;
    }

    public static function setUpdateProfile200(){
        $_SESSION['updateProfile200'] = true;
    }

    public static function setOldPassword406(){
        $_SESSION['oldpassword406'] = true;
    }

    public static function setUniqueGroupname406(){
        $_SESSION['uniqueGroupname406'] = true;
    }

    public static function setCreateGroup200(){
        $_SESSION['createGroup200'] = true;
    }

    public static function setUpdateGroup200(){
        $_SESSION['updateGroup200'] = true;
    }

    public static function setJoinPrivate204(){
        $_SESSION['joinPrivate204'] = true;
    }

    public static function setJoinPublic204(){
        $_SESSION['joinPublic204'] = true;
    }

    public static function setAdminLeave403(){
        $_SESSION['adminLeave403'] = true;
    }

    public static function setMemberLeave204($groupname){
        $_SESSION['groupname'] = $groupname;
        $_SESSION['memberLeave204'] = true;
    }

    public static function setDeleteGroup204($groupname){
        $_SESSION['groupname'] = $groupname;
        $_SESSION['deleteGroup204'] = true;
    }

    public static function setChangePassword204(){
        setcookie('password','true',time()+3600);
    }

    public static function setDeleteAccount204(){
        setcookie('deleteaccount','true',time()+3600);
    }

    public static function deleteAccount204(){
        if(isset($_COOKIE['deleteaccount'])){
            setcookie('deleteaccount','',time()-3600);
            return "Your account has been deleted!";
        }
    }

    public static function changePassword204(){
        if(isset($_COOKIE['password'])){
            setcookie('password','',time()-3600);
            return "Password changed! Please re-login!";
        }
    }

    public static function setEmptyField404(){
        $_SESSION['emptyField404'] = true;
    }

    public static function setPost204(){
        $_SESSION['post204'] = true;
    }

    public static function post204(){
        if(isset($_SESSION['post204'])){
            unset($_SESSION['post204']);
            return 'Post success!';
        }
    }

    public static function deletePost204(){
        if(isset($_SESSION['deletePost204'])){
            unset($_SESSION['deletePost204']);
            return 'delete post succes!';
        }
    }

    public static function emptyField404(){
        if(isset($_SESSION['emptyField404'])){
            unset($_SESSION['emptyField404']);
            return 'Field must not be empty!';
        }
    }

    public static function setDeletePost204(){
        $_SESSION['deletePost204'] = true;
    }

    public static function setUpdatePost204(){
        $_SESSION['updatePost204'] = true;
    }

    public static function updatePost204(){
        if(isset($_SESSION['updatePost204'])){
            unset($_SESSION['updatePost204']);
            return 'Update post succes!';
        }
    }
//==========================================================================================================================================
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~show message~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//==========================================================================================================================================
    public static function username404(){
        if(isset($_SESSION['username404'])){
            unset($_SESSION['username404']);  
            return 'Username not found!';
        }
    }

    public static function password406(){
        if(isset($_SESSION['password406'])){
            unset($_SESSION['password406']);
            return 'Username or Password incorrect!';
        }
    }

    public static function cookie404(){
        if(isset($_SESSION['cookie404'])){
            unset($_SESSION['cookie404']);
            return 'Cookie username value is not correct or not corresponding';
        }
    }

    public static function cookie406(){
        if(isset($_SESSION['cookie406'])){
            unset($_SESSION['cookie406']);
            return 'Cookie is not activated. Not recommended to set your own cookies';
        }
    }

    public static function confPassword406(){
        if(isset($_SESSION['ConfPassword406'])){
            unset($_SESSION['ConfPassword406']);
            return 'Confirm Password doesn\'t match';
        }
    }

    public static function picture404(){
        if(isset($_SESSION['picture404'])){
            unset($_SESSION['picture404']);
            return 'picture still empty';
        }
    }

    public static function picture406(){
        if(isset($_SESSION['picture406'])){
            unset($_SESSION['picture406']);
            return 'Image extension mismatch (jpg, bmp, png, svg)';
        }
    }

    public static function register200(){
        if(isset($_SESSION['register200'])){
            unset($_SESSION['register200']);
            return 'Register success! Please login.';
        }
    }

    public static function email404(){
        if(isset($_SESSION['email404'])){
            unset($_SESSION['email404']);
            return 'The inputted email is not registered!';
        }
    }

    public static function email200(){
        if(isset($_SESSION['email200'])){
            unset($_SESSION['email200']);
            return 'Your link to reset password has been sent! Check your email!';
        }
    }

    public static function updatePassword200(){
        if(isset($_SESSION['updatePassword200'])){
            unset($_SESSION['updatePassword200']);
            return 'Password updated!';
        }
    }

    public static function updateGroup200(){
        if(isset($_SESSION['updateGroup200'])){
            unset($_SESSION['updateGroup200']);
            return 'Group profile successfully updated!';
        }
    }

    public static function uniqueUsername406(){
        if(isset($_SESSION['uniqueUsername406'])){
            unset($_SESSION['uniqueUsername406']);
            return 'username is already exist. Pick another username!';
        }
    }

    public static function updateProfile200(){
        if(isset($_SESSION['updateProfile200'])){
            unset($_SESSION['updateProfile200']);
            return 'Your profile info successfully updated!';
        }
    }

    public static function oldpassword406(){
        if(isset($_SESSION['oldpassword406'])){
            unset($_SESSION['oldpassword406']);
            return 'Old password wrong';
        }
    }

    public static function uniqueGroupname406(){
        if(isset($_SESSION['uniqueGroupname406'])){
            unset($_SESSION['uniqueGroupname406']);
            return 'Groupname already exist! Groupname must be unique!';
        }
    }

    public static function createGroup200(){
        if(isset($_SESSION['createGroup200'])){
            unset($_SESSION['createGroup200']);
            return 'Group created successfully';
        }
    }

    public static function joinPrivate204($groupname){
        if(isset($_SESSION['joinPrivate204'])){
            unset($_SESSION['joinPrivate204']);
            return 'Your join request has been sent to '.$groupname.'!';
        }
    }

    public static function joinPublic204($username, $groupname){
        if(isset($_SESSION['joinPublic204'])){
            unset($_SESSION['joinPublic204']);
            return $username.', you are now the member of '.$groupname.' group!';
        }
    }

    public static function adminLeave403(){
        if(isset($_SESSION['adminLeave403'])){
            unset($_SESSION['adminLeave403']);
            return "You're the only admin, Cannot leave!";
        }
    }

    public static function memberLeave204($groupname, $username){
        unset($_SESSION['groupname']);
        if(isset($_SESSION['memberLeave204'])){
            unset($_SESSION['memberLeave204']);
            return "$username is no longer a member of the $groupname group";
        }
    }

    public static function deleteGroup204($groupname){
        if(isset($_SESSION['deleteGroup204'])){
            unset($_SESSION['deleteGroup204']);
            return "$groupname successfully deleted!";
        }
    }
}