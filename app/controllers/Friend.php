<?php

class Friend extends Controller
{
    ###dapat diubah requestnya menggunakan ajax
    //menambahkan list friend dengan status default belum di accept
    public function add($username, $friend)
    {
        $this->model('Friend_List_Model')->addFriend($username, $friend);
        header('Location:' . URL . '/home/index_user/' . $username);
    }
    ###dapat diubah requestnya menggunakan ajax
    //jika user ingin membatalkan mengirim permintaan pertemanan
    public function abort($username, $friend)
    {
        $this->model('Friend_List_Model')->abortRequestFriend($username, $friend);
        header('Location:' . URL . '/home/index_user/' . $username);
    }

    //menampilkan list user yang sudah menjadi teman
    public function index($username)
    {
        $data['title'] = "Friend | $username";
        $data['username'] = $username;
        $data['friend'] = $this->model('Friend_List_model')->getFriendListUsername($username);
        $data['friendUsername'] = $this->model('Friend_List_model')->getFriendListFriendUsername($username);

        $this->view('templates/header', $data);
        $this->view('user/friend_list', $data);
        $this->view('templates/footer');
    }

    //menampilkan request pertemanan dari user lain
    public function requested_friend($username)
    {
        $data['title'] = "Friend | Request";
        $data['username'] = $username;
        $data['friend'] = $this->model('Friend_List_model')->getRequestedFriend($username);

        $this->view('templates/header', $data);
        $this->view('user/requested_friend', $data);
        $this->view('templates/footer');
    }

    ###dapat diubah requestnya menggunakan ajax
    //untuk menerima permintaan pertemanan dan mengubah status
    public function accept($username, $friend)
    {
        $this->model('Friend_List_model')->acceptFriend($username, $friend);
        header('Location:' . URL . '/friend/requested_friend/' . $username);
    }

    ###dapat diubah requestnya menggunakan ajax
    //untuk menolak permintaan pertemanan dan menghapus row
    public function reject($username, $friend)
    {
        $this->model('Friend_List_model')->rejectFriend($username, $friend);
        header('Location:' . URL . '/friend/requested_friend/' . $username);
    }

    ###dapat diubah requestnya menggunakan ajax
    //menghapus user dari daftar pertemanan, status keduanya menjadi tidak berteman
    public function delete($username, $friend)
    {
        $this->model('Friend_List_model')->abortRequestFriend($username, $friend);
        header('Location:' . URL . '/friend/index/' . $username);
    }

    //menampilkan chat antara 2 user
    public function chat($username, $friend)
    {
        $data['username'] = $username;
        $data['friend'] = $friend;
        $data['title'] = 'Celatuk | Chat';
        $data['user_picture'] = $this->model('User_Model')->index($username);
        $data['friend_picture'] = $this->model('User_Model')->index($friend);
        $data['chat'] = $this->model('Messenger_Model')->getAllMessageUsername($username, $friend);

        $this->view('templates/header', $data);
        $this->view('message/type_page', $data);
        $this->view('templates/footer');
    }

    // public function block($username, $friend){
    //     $this->model('Friend_List_model')->blockFriend($username,$friend,1);

    //     header('Location:'.URL.'/friend/index/'.$username);
    // }

    // public function unblock($username, $friend){
    //     $this->model('Friend_List_model')->blockFriend($username,$friend,0);

    //     header('Location:'.URL.'/friend/index/'.$username);
    // }
}
