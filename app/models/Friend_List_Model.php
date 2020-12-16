<?php

class Friend_List_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //cek apakah sudah ada di dalam tabel friend_list
    public function isFriend($username)
    {
        $query = "SELECT * FROM " . TABLE_FRIEND . " 
                    WHERE username = :username OR friendUsername = :username";
        $this->db->query($query);

        $this->db->bind('username', $username);

        return $this->db->resultSet();
    }

    // ============================================================================================================================================
    ## -------------------------------------------Request Friend Management -----------------------------------------------------------------------
    // ============================================================================================================================================
    //menambahkan user ke tabel ketika memberi request friend dengan status belum diterima
    public function addFriend($username, $friend)
    {
        $query = "INSERT INTO " . TABLE_FRIEND . " VALUES (:username, :friendUserName, :isBlocked, :status)";
        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('friendUserName', $friend);
        $this->db->bind('isBlocked', 0);
        $this->db->bind('status', 0);

        $this->db->execute();
    }
    //membatalkan permintaan pertemanan
    public function abortRequestFriend($username, $friend)
    {
        $query = "DELETE FROM " . TABLE_FRIEND . " 
                    WHERE username = :username AND friendUserName = :friend";
        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('friend', $friend);

        $this->db->execute();
    }

    //menerima permintaan pertemanan
    public function acceptFriend($username, $friend)
    {
        $query = "UPDATE " . TABLE_FRIEND . " SET status = :status 
                WHERE username = :friend AND friendUserName = :username";
        $this->db->query($query);

        $this->db->bind('status', 1);
        $this->db->bind('username', $username);
        $this->db->bind('friend', $friend);

        $this->db->execute();
    }
    //tidak menerima request pertemanan dari user lain
    public function rejectFriend($username, $friend)
    {
        $query = "DELETE FROM " . TABLE_FRIEND . " 
                    WHERE username = :friend AND friendUserName = :username";
        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('friend', $friend);

        $this->db->execute();
    }

    // ============================================================================================================================================
    ## -------------------------------------------List Friend dan Request -----------------------------------------------------------------------
    // ============================================================================================================================================
    #####untuk ambil daftar teman dari seorang user
    //jika user yang memberi request (namaya di kolom username)
    public function getFriendListUsername($username)
    {
        $query = "SELECT * FROM " . TABLE_FRIEND . " 
                    JOIN " . TABLE_USER . " ON " . TABLE_USER . ".username = " . TABLE_FRIEND . ".friendUserName 
                    WHERE " . TABLE_FRIEND . ".username = :username AND NOT " . TABLE_FRIEND . ".status = :status";
        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('status', 0);

        return $this->db->resultSet();
    }
    //jika user yang menerima request (namaya di kolom friendUsername)
    public function getFriendListFriendUsername($username)
    {
        $query = "SELECT * FROM " . TABLE_FRIEND . " 
                    JOIN " . TABLE_USER . " ON " . TABLE_USER . ".username = " . TABLE_FRIEND . ".username 
                    WHERE " . TABLE_FRIEND . ".friendUserName = :username AND NOT " . TABLE_FRIEND . ".status = :status";
        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('status', 0);

        return $this->db->resultSet();
    }

    //melihat daftar user lain yang request pertemanan ke username tertentu
    public function getRequestedFriend($username)
    {
        $query = "SELECT * FROM " . TABLE_FRIEND . " 
                    JOIN " . TABLE_USER . " ON " . TABLE_USER . ".username = " . TABLE_FRIEND . ".username 
                    WHERE " . TABLE_FRIEND . ".friendUserName = :username AND " . TABLE_FRIEND . ".status = :status";
        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('status', 0);

        return $this->db->resultSet();
    }
}
