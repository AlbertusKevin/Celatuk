<?php

class Group_Member_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    #ketika user ingin bergabung dengan grup
    public function insertMember($username, $group, $status, $role)
    {
        $query = "INSERT INTO " . TABLE_MEMBER . " 
                    VALUES (:username, :groupName, :joinedDate, :role, :status)";

        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('groupName', $group);
        $this->db->bind('joinedDate', date('l, j F Y'));
        $this->db->bind('role', $role);
        $this->db->bind('status', $status);

        $this->db->execute();
        return 200;
    }

    #ambil semua member yang sudah terdaftar (dan sudah diapprove join, status = 1)
    public function getAllMember($groupname)
    {
        $query = "SELECT * FROM " . TABLE_MEMBER . " 
                    JOIN " . TABLE_USER . " ON " . TABLE_USER . ".username = " . TABLE_MEMBER . ".username 
                    WHERE groupName = :groupname";
        $this->db->query($query);

        $this->db->bind('groupname', $groupname);

        return $this->db->resultSet();
    }

    #ambil datai-data user mana saja yang mau join ke grup tersebut. Hanya digunakan pada grup yang private
    public function getMemberRequestJoin($groupname)
    {
        $query = "SELECT * FROM " . TABLE_MEMBER . " 
                    JOIN " . TABLE_USER . " ON " . TABLE_USER . ".username = " . TABLE_MEMBER . ".username 
                    WHERE groupName = :groupname AND status = :status";

        $this->db->query($query);

        $this->db->bind('groupname', $groupname);
        $this->db->bind('status', 0);

        return $this->db->resultSet();
    }

    public function deleteMember($groupname, $member)
    {
        $query = "DELETE FROM " . TABLE_MEMBER . " 
                    WHERE username = :username AND groupName = :groupname";

        $this->db->query($query);
        $this->db->bind('username', $member);
        $this->db->bind('groupname', $groupname);
        $this->db->execute();
    }

    public function deleteGroup($groupname)
    {
        $query = "DELETE FROM " . TABLE_MEMBER . " WHERE groupName = :groupname";
        $this->db->query($query);
        $this->db->bind('groupname', $groupname);
        $this->db->execute();
    }

    #Accept member yang mau join, bisa dilakukan oleh admin atau moderator
    public function acceptMember($groupname, $member)
    {
        $query = "UPDATE " . TABLE_MEMBER . " SET status = :status 
                    WHERE groupName = :groupname AND username = :member";
        $this->db->query($query);

        $this->db->bind('status', 1);
        $this->db->bind('groupname', $groupname);
        $this->db->bind('member', $member);

        $this->db->execute();
    }

    public function promoteOrDemoteMember($username, $role)
    {
        $query = "UPDATE " . TABLE_MEMBER . " SET role =:role WHERE username = :username";
        $this->db->query($query);

        $this->db->bind('role', $role);
        $this->db->bind('username', $username);
        $this->db->execute();
    }

    //cek apakah user tersebut satu-satunya admin di grup itu, untuk mencegah leave grup jika admin hanya satu
    public function checkAdmin($groupname, $username)
    {
        $query = "SELECT * FROM " . TABLE_MEMBER . " WHERE role = :role AND groupName = :groupname AND NOT username = :username";
        $this->db->query($query);

        $this->db->bind('role', 'admin');
        $this->db->bind('groupname', $groupname);
        $this->db->bind('username', $username);

        return $this->db->resultSet();
    }

    #cek role user dalam suatu grup 
    public function checkRole($username, $name)
    {
        $query = "SELECT * FROM " . TABLE_MEMBER . " WHERE username = :username AND groupName = :name";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('name', $name);
        return $this->db->singleResult();
    }
}
