<?php

class Comment extends Controller
{
    //seluruh function di request melalui ajax, sehingga tidak menampilkan view
    public function send($id, $name)
    {
        $message = htmlspecialchars($_POST['comment']);
        $this->model('Comment_Model')->sendComment($id, $name, $message);
    }

    public function update($id)
    {
        $message = htmlspecialchars($_POST['newComment']);
        $this->model('Comment_Model')->updateComment($id, $message);
    }

    public function delete($id)
    {
        $this->model('Comment_Model')->deleteComment($id);
    }
}
