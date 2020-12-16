<?php
class Comment_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function sendComment($id, $username, $message)
    {
        $query = "INSERT INTO " . TABLE_COMMENT . " (idPost,username,comment) VALUES (:id,:username,:comment)";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('username', $username);
        $this->db->bind('comment', $message);
        $this->db->execute();
    }

    public function getPostCommentById($id)
    {
        $query = "SELECT * FROM " . TABLE_COMMENT . " WHERE idPost= :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->resultSet();
    }

    public function updateComment($id, $message)
    {
        $query = "UPDATE " . TABLE_COMMENT . " SET comment = :comment WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('comment', $message);
        $this->db->execute();
    }

    public function deleteComment($id)
    {
        $query = "DELETE FROM " . TABLE_COMMENT . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
    }
}
