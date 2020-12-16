<?php

class Celatuk extends Controller
{
    //halaman landing page
    public function index()
    {
        //data yang akan dikirim
        $data['title'] = 'Welcome to Celatuk';
        //view yang akan ditampilkan dari folder views
        $this->view('templates/header', $data);
        $this->view('landing');
        $this->view('templates/footer');
    }

    //request lewat ajax, return data berupa json untuk digunakan di javascript
    public function changeLike($id)
    {
        echo json_encode($this->model('Post_Model')->getLikeCountId($id));
    }
}
