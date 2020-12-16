<?php

class Messenger extends Controller
{
    //menampilkan daftar user yang di chat pada halaman list_chat.php
    public function index($username)
    {
        $data['chat_list'] = $this->model('Messenger_Model')->getListChatContact($username);
        $data['username'] = $username;
        $data['title'] = 'Chat Contact';
        $picture = [];

        //pengelolaan daftar dari table chat agar data yang dihasilkan tidak banyak
        //contoh: chat a dengan b ada 20 pesan, berarti list contactnya adalah b
        $friend = [];
        foreach ($data['chat_list'] as $contact) {
            if ($contact['toUser'] == $data['username']) {
                if (!in_array($contact['fromUser'], $friend)) {
                    $friend[] = $contact['fromUser'];
                    $picture[] = $this->model('User_Model')->index($contact['fromUser']);
                }
            }

            if ($contact['fromUser'] == $data['username']) {
                if (!in_array($contact['toUser'], $friend)) {
                    $friend[] = $contact['toUser'];
                    $picture[] = $this->model('User_Model')->index($contact['toUser']);
                }
            }
        }

        $data['picture'] = $picture;

        $this->view('templates/header', $data);
        $this->view('message/list_chat', $data);
        $this->view('templates/footer');
    }

    ###lebih baik menggunakan ajax
    //untuk send message dari halaman type_page.php
    public function send($username, $friend)
    {
        if ($_POST['message'] == "") {
            header('Location:' . URL . '/friend/chat/' . $username . '/' . $friend);
            exit;
        }

        $this->model('Messenger_Model')->send($username, $friend);
        header('Location:' . URL . '/friend/chat/' . $username . '/' . $friend);
        exit;
    }

    ###bisa diganti requestnya menggunakan ajax
    //ketika user ingin menghapus history chatnya dengan user tertentu
    public function delete($username, $friend)
    {
        $status = $this->model('Messenger_Model')->checkStatusDeletedMessage($username, $friend);

        //jika belum ada salah satu user yang delete
        if ($status[0]['deleted'] == '') {
            $this->model('Messenger_model')->soft_delete_chat($username, $friend);
            //jika salah satu user sudah ada yang delete
        } else {
            $this->model('Messenger_model')->delete_chat($username, $friend);
        }

        header('Location:' . URL . '/messenger/index/' . $username);
        exit;
    }
}
