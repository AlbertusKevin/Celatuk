<?php

class Messenger_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function send($username, $friend, $content = [])
    {
        $message = htmlspecialchars($_POST['message']);
        $query = "INSERT INTO " . TABLE_MESSAGE . " VALUES ('', :fromUser, :toUser, :date, :status, :deleted, :message, :addContent)";

        $this->db->query($query);

        $this->db->bind('fromUser', $username);
        $this->db->bind('toUser', $friend);
        $this->db->bind('date', date('l, j M Y'));
        $this->db->bind('status', 0); //0 kekirim, 1 sudah dibaca
        $this->db->bind('deleted', '');
        $this->db->bind('message', $message);
        $this->db->bind('addContent', $content);

        $this->db->execute();
    }

    //ambil user mana saja yang pernah chat dengan username tertentu
    public function getListChatContact($username)
    {
        $query = "SELECT DISTINCT id, fromUser, toUser FROM " . TABLE_MESSAGE . " 
                    WHERE (fromUser = :username OR toUser = :username) AND NOT deleted = :username 
                    ORDER BY id desc";
        $this->db->query($query);
        $this->db->bind('username', $username);
        return $this->db->resultSet();
    }

    //ambil message antar dua orang untuk ditampilkan di halaman type chat
    public function getAllMessageUsername($username, $friend)
    {
        $query = "SELECT * FROM " . TABLE_MESSAGE . " WHERE 
            (
                (toUser = :username AND fromUser = :friend)
                    OR 
                (fromUser = :username AND toUser = :friend)
            ) 
                AND 
            NOT deleted = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('friend', $friend);
        return $this->db->resultSet();
    }

    //ketika salah satu user saja yang delete chat, user lain yang tidak delete tetap bisa lihat chatnya dengan username tertentu
    public function soft_delete_chat($username, $friend)
    {
        $query = "UPDATE " . TABLE_MESSAGE . " SET deleted = :username WHERE toUser = :username AND fromUser = :friend OR toUser = :friend AND fromUser = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('friend', $friend);
        $this->db->execute();
    }

    //ketika dua user yang saling chat dan keduanya menghapus jejak chat mereka
    public function delete_chat($username, $friend)
    {
        $query = "DELETE FROM " . TABLE_MESSAGE . " WHERE 
                    toUser = :username AND fromUser = :friend 
                        OR 
                    toUser = :friend AND fromUser = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('friend', $friend);
        $this->db->execute();
    }

    //ambil chat terakhir dengan user tertentu untuk cek status apakah message sudah dihapus, belum dihapus, atau sudah dihapus oleh salah satu user saja
    public function checkStatusDeletedMessage($username, $friend)
    {
        $query = "SELECT * FROM " . TABLE_MESSAGE . " WHERE 
                        toUser = :username AND fromUser = :friend 
                            OR 
                        fromUser = :username AND toUser = :friend 
                    ORDER BY id DESC LIMIT 1";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('friend', $friend);
        return $this->db->resultSet();
    }
}
