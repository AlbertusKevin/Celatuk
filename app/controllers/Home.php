<?php

class Home extends Controller
{
    //menampilkan halaman home utama
    public function index($username)
    {
        $data['title'] = 'Celatuk | home';
        $data['username'] = $username;
        $data['post'] = $this->model('Post_Model')->getAllPost($username);
        $data['saved'] = $this->model('Post_Model')->retrieveBookmark($username);
        $data['liked'] = $this->model('Post_Model')->likedPost($username);

        $this->view('templates/header', $data);
        $this->view('home/home', $data);
        $this->view('templates/footer');
    }

    //menampilkan halaman profile username saat itu
    public function profile($username)
    {
        $data['title'] = "Setting: $username";
        $data['setting'] = $this->model('User_Setting_Model')->setting($username);
        $data['profile'] = $this->model('User_model')->index($username);
        $data['post'] = $this->model('Post_Model')->getUserPost($username);
        $data['saved'] = $this->model('Post_Model')->retrieveBookmark($username);
        $data['liked'] = $this->model('Post_Model')->likedPost($username);

        $this->view('templates/header', $data);
        $this->view('home/profile', $data);
        $this->view('templates/footer');
    }

    ###bisa diganti dengan request ajax
    public function darkmode($username)
    {
        $this->model('User_Setting_Model')->darkmode($username);
        header('Location: ' . URL . '/home/profile/' . $username);
    }

    //mengambil semua user yang terdaftar di Celatuk
    public function index_user($username)
    {
        $data['user'] = $this->model('User_model')->getAllUser($username);
        $data['username'] = $username;
        $data['title'] = "Celatuk | User";
        $data['friendlist'] = $this->model('Friend_List_Model')->isFriend($username);

        $this->view('templates/header', $data);
        $this->view('home/index_user', $data);
        $this->view('templates/footer');
    }
}
