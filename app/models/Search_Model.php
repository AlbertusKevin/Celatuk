<?php

class Search_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUser($keyword)
    {
        $query = "SELECT * FROM " . TABLE_USER . " WHERE username LIKE :username";
        $this->db->query($query);
        $this->db->bind('username', "%$keyword%");
        return $this->db->resultSet();
    }

    public function getGroup($keyword)
    {
        $query = "SELECT * FROM " . TABLE_GROUP . " WHERE groupName LIKE :name";
        $this->db->query($query);
        $this->db->bind('name', "%$keyword%");
        return $this->db->resultSet();
    }
}
