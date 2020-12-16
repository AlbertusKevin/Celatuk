<?php

class User_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //====================================================================================================================================
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Auth System ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //====================================================================================================================================

    #=========================================================Register================================================================
    public function upload_picture($pict, $type)
    {
        //cek ada gambarnya atau tidak
        if ($pict['error'] == 4) {
            return 404;
        }

        //cek tipe file gambar atau bukan
        $extAble = ['jpg', 'png', 'jpeg', 'svg', 'bmp'];
        $extPict = explode('.', $pict['name']);
        $extPict = end($extPict);

        if (!in_array($extPict, $extAble)) {
            return 406;
        }

        //file telah divalidasi, pindahkan file ke tempat seharusnya
        //generate nama file untuk menghindari kemungkinan file yang diupload menimpa nama file lama yang sama
        $newPictName = uniqid() . ".$extPict";

        //tipe 0, upload profile picture, 1 upload background picture
        if ($type === 0) {
            mkdir('assets/img/user/' . $_POST['username'] . '/profile', 0777, true);
            $dirprofile = 'assets/img/user/' . $_POST['username'] . '/profile';
            move_uploaded_file($pict['tmp_name'], "$dirprofile/$newPictName");
        } else {
            mkdir('assets/img/user/' . $_POST['username'] . '/background', 0777, true);
            $dirbg = 'assets/img/user/' . $_POST['username'] . '/background';
            move_uploaded_file($pict['tmp_name'], "$dirbg/$newPictName");
        }

        //return nama file
        return $newPictName;
    }

    public function register()
    {
        //ambil data-data
        $name = htmlspecialchars($_POST['name']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['pwd']);
        $conf_pwd = htmlspecialchars($_POST['conf_pwd']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $pict = $_FILES['picture'];
        $bgpict = $_FILES['bg_picture'];

        //jika password dan konfirmasi password tidak cocok
        if ($password !== $conf_pwd) {
            return 'p406';
        }

        //enkripsikan password
        $password = password_hash($password, PASSWORD_DEFAULT);

        //kelola file picture
        $pict = $this->upload_picture($pict, 0);
        $bgpict = $this->upload_picture($bgpict, 1);

        //jika tidak ada input-an 
        if ($pict === 404 || $bgpict === 404) {
            return 404;
        }

        //jika ekstensi tidak diperbolehkan
        if ($pict === 406 || $bgpict === 406) {
            return 406;
        }

        //query data user ke database
        $query = "INSERT INTO " . TABLE_USER . " VALUES (:username, :nam, :pwd, :email, :phone, :pict, :bgpict)";
        $this->db->query($query);

        //bind setiap value yang akan dimasukka ke database
        $this->db->bind('username', $username);
        $this->db->bind('nam', $name);
        $this->db->bind('pwd', $password);
        $this->db->bind('email', $email);
        $this->db->bind('phone', $phone);
        $this->db->bind('pict', $pict);
        $this->db->bind('bgpict', $bgpict);

        $this->db->execute();
    }

    #=========================================================login===================================================================
    public function login($data)
    {
        //terima data dan antisipasi inputan user
        $username = htmlspecialchars($data['username']);
        $password = htmlspecialchars($data['password']);

        //cek username ada atau tidak
        $query = "SELECT * FROM " . TABLE_USER . " WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $user = $this->db->singleResult();

        //jika tidak ada user
        if (!$user) {
            return 404;
        }

        //cek, apakah password diinput sesuai dengan password di db
        if (password_verify($password, $user["password"])) {
            //session login diaktifkan
            $_SESSION['login'] = true;
            //jika mengaktifkan cookie, set cookie dan update settingan di db
            if (isset($data['remember'])) {
                setcookie('name', $username, time() + 60 * 60 * 24 * 365 * 12);

                $setcookie = "UPDATE " . TABLE_SETTING . " SET cookie = :cookie WHERE username = :username";
                $this->db->query($setcookie);
                $this->db->bind('cookie', 1);
                $this->db->bind('username', $username);
                $this->db->execute();
            }
            return 200;
        }

        //jika password salah
        return 406;
    }
    #=========================================================forgot password=========================================================
    //cek inputan email terdaftar atau tidak
    public function searchEmail($data)
    {
        $email = $data['email'];
        $query = "SELECT username FROM " . TABLE_USER . " WHERE email = :email";
        $this->db->query($query);
        $this->db->bind('email', $email);
        return $this->db->singleResult();
    }

    //update password baru
    public function reset($username, $pwd)
    {
        $query = "UPDATE " . TABLE_USER . " SET password = :pwd WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('pwd', $pwd);
        $this->db->bind('username', $username);
        $this->db->execute();
        return 200;
    }

    //====================================================================================================================================
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Profile Management ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //====================================================================================================================================
    //ambil data user tertentu
    public function index($username)
    {
        $query = "SELECT * FROM " . TABLE_USER . " WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        return $this->db->singleResult();
    }

    public function update($data, $img, $username)
    {
        $name = htmlspecialchars($data['name']);
        $email = htmlspecialchars($data['email']);
        $phone = htmlspecialchars($data['phone']);
        $pict = $img['picture'];
        $bg = $img['bg_picture'];

        $query = "UPDATE " . TABLE_USER . " SET 
                    name = :name,
                    email = :email,
                    phone = :phone
                WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('name', $name);
        $this->db->bind('email', $email);
        $this->db->bind('phone', $phone);
        $this->db->execute();

        //jika user tidak ingin update profile picture
        if ($pict['name'] != "") {
            $pict = $this->upload_picture($pict, 0);

            if ($pict === 406) {
                return 406;
            }

            $query = "UPDATE " . TABLE_USER . " SET picture = :picture WHERE username = :username";
            $this->db->query($query);
            $this->db->bind('username', $username);
            $this->db->bind('picture', $pict);
            $this->db->execute();
        }

        //jika user tidak ingin update background picture
        if ($bg['name'] != "") {
            $bg = $this->upload_picture($bg, 1);

            if ($bg === 406) {
                return 406;
            }

            $query = "UPDATE " . TABLE_USER . " SET bgPicture = :bgpicture WHERE username = :username";
            $this->db->query($query);
            $this->db->bind('username', $username);
            $this->db->bind('bgpicture', $bg);
            $this->db->execute();
        }

        return 200;
    }

    public function updatePassword($username)
    {
        $oldpwd = $_POST['oldpwd'];
        $newpwd = $_POST['newpwd'];
        $confpwd = $_POST['confpwd'];
        //ambil password lama di database
        $password = $this->index($username);

        //cocokkan apakah sesuai password yang dimasukkan dengan password lama
        if (password_verify($oldpwd, $password['password'])) {
            //jika konfirmasi password sesuai
            if ($newpwd === $confpwd) {
                //enkripsikan password
                $newpwd = password_hash($newpwd, PASSWORD_DEFAULT);
                $query = "UPDATE " . TABLE_USER . " SET password = :password WHERE username = :username";
                $this->db->query($query);
                $this->db->bind('password', $newpwd);
                $this->db->bind('username', $username);
                $this->db->execute();
                return 200;
            }
            //jika konfirmasi password salah
            return 406;
        }
        //jika tidak sesuai dengan password yang lama
        return 'old406';
    }

    public function delete($username)
    {
        $query = "DELETE user, user_setting, friend_list FROM " . TABLE_SETTING . " INNER JOIN " . TABLE_USER . " INNER JOIN " . TABLE_FRIEND . " WHERE " . TABLE_USER . ".username = " . TABLE_SETTING . ".username AND " . TABLE_USER . ".username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->execute();
    }

    //ambil user selain username tertentu
    public function getAllUser($username)
    {
        $query = "SELECT * FROM " . TABLE_USER . " WHERE NOT username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        return $this->db->resultSet();
    }
}
