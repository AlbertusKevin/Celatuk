<?php

class User_Setting_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function createDefaultSetting($username)
    {
        $query = "INSERT INTO " . TABLE_SETTING . " VALUES (:username, :darkmode, :cookie, :statusOnline)";
        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('darkmode', 0);
        $this->db->bind('cookie', 0);
        $this->db->bind('statusOnline', 0);

        $this->db->execute();
    }

    #=========================================================remember me=============================================================
    public function cookie($data)
    {
        $query = "SELECT cookie FROM " . TABLE_SETTING . " WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $data['name']);

        $cookie = $this->db->singleResult();

        //jika cookie dengan key name, tetapi valuenya tidak ada
        if (!$cookie) {
            return 404;
        }

        if ($cookie['cookie']) {
            $_SESSION['login'] = true;
            return 200;
        }

        return 406;
    }

    #=========================================================logout (cookie)=========================================================
    public function unsetcookie($data)
    {
        $setcookie = "UPDATE " . TABLE_SETTING . " SET cookie = :cookie WHERE username = :username";
        $this->db->query($setcookie);
        $this->db->bind('cookie', 0);
        $this->db->bind('username', $data['name']);
        $this->db->execute();
    }

    //ambil settingan user
    public function setting($username)
    {
        $query = "SELECT * FROM " . TABLE_SETTING . " WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        return $this->db->singleResult();
    }

    //activate/deactivate darkmode
    public function darkmode($username)
    {
        $query = "UPDATE " . TABLE_SETTING . " SET darkmode = :darkmode WHERE username = :username";
        $this->db->query($query);

        if ($_POST['value'] == 'on') {
            $this->db->bind('darkmode', 1);
        } else {
            $this->db->bind('darkmode', 0);
        }

        $this->db->bind('username', $username);
        $this->db->execute();
    }
}
