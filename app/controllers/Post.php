<?php

class Post extends Controller
{
    #--------------------------------------------Manage Postingan-----------------------------------------------
    //menampilkan form untuk user membuat postingan baru
    public function form($username)
    {
        $data['username'] = $username;
        $data['title'] = 'Create Post';

        $this->view('templates/header', $data);
        $this->view('user/post/create', $data);
        $this->view('templates/footer');
    }

    //proses membuat postingan baru
    public function create($username)
    {
        $result = $this->model('Post_Model')->create($username);

        if ($result == 406) {
            Message::setPicture406();
            header('Location:' . URL . '/home/index/' . $username);
            exit;
        } elseif ($result == 404) {
            Message::setEmptyField404();
            header('Location:' . URL . '/home/index/' . $username);
            exit;
        }

        Message::setPost204();
        header('Location:' . URL . '/home/index/' . $username);
        exit;
    }

    //proses mengupdate postingan
    public function edit($username, $id)
    {
        $result = $this->model('Post_Model')->edit($username, $id);

        if ($result == 406) {
            Message::setPicture406();
            header('Location:' . URL . '/post/edit_form/' . $username . '/' . $id);
            exit;
        } elseif ($result == 404) {
            Message::setEmptyField404();
            header('Location:' . URL . '/post/edit_form/' . $username . '/' . $id);
            exit;
        }

        Message::setUpdatePost204();
        header('Location:' . URL . '/home/profile/' . $username);
        exit;
    }

    //form untuk edit postingan
    public function edit_form($username, $id_post)
    {
        $data['username'] = $username;
        $data['title'] = 'Edit Post';
        $data['post'] = $this->model('Post_Model')->getPostId($id_post);

        $this->view('templates/header', $data);
        $this->view('user/post/edit', $data);
        $this->view('templates/footer');
    }

    ###bisa diganti dengan ajax request
    //menghapus postingan oleh user terkait
    public function delete($username, $id_post)
    {
        $this->model('Post_Model')->delete($id_post);

        Message::setDeletePost204();
        header('Location:' . URL . '/home/profile/' . $username);
        exit;
    }
    #---------------------------------------Manage Bookmark dan Like------------------------------------------
    //menampilkan seluruh postingan yang di bookmark oleh user
    public function mybookmark($username)
    {
        $data['post'] = $this->model('Post_Model')->retrieveBookmark($username);
        $data['username'] = $username;
        $data['title'] = "Celatuk | My Bookmark";
        $data['liked'] = $this->model('Post_Model')->likedPost($username);

        $this->view('templates/header', $data);
        $this->view('user/post/mybookmark', $data);
        $this->view('templates/footer');
    }

    //menambahkan bookmark
    public function bookmark($id, $username)
    {
        $this->model('Post_Model')->storeBookmark($id, $username);
    }

    public function delete_bookmark($id, $username)
    {
        $this->model('Post_Model')->deleteBookmark($id, $username);
    }

    public function like_post($id, $username)
    {
        $this->model('Post_Model')->likePost($id, $username);
    }

    public function unlike_post($id, $username)
    {
        $this->model('Post_Model')->unlikePost($id, $username);
    }
}
