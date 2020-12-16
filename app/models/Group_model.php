<?php

class Group_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //--------------------------------------------------------CREATE----------------------------------------------------------------
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

        //jika type 0, berarti upload profile picture, 1 upload bacground picture
        if ($type === 0) {
            if (file_exists('assets/img/group/' . $_POST['groupName'] . '/profile')) {
                $dirprofile = 'assets/img/group/' . $_POST['groupName'] . '/profile';
                move_uploaded_file($pict['tmp_name'], "$dirprofile/$newPictName");
            } else {
                mkdir('assets/img/group/' . $_POST['groupName'] . '/profile', 0777, true);
                $dirprofile = 'assets/img/group/' . $_POST['groupName'] . '/profile';
                move_uploaded_file($pict['tmp_name'], "$dirprofile/$newPictName");
            }
        } else {
            mkdir('assets/img/group/' . $_POST['groupName'] . '/background', 0777, true);
            $dirbg = 'assets/img/group/' . $_POST['groupName'] . '/background';
            move_uploaded_file($pict['tmp_name'], "$dirbg/$newPictName");
        }
        //nama file yang akan disimpan di database
        return $newPictName;
    }

    //membuat grup baru
    public function store($username)
    {
        //ambil value yang akan disimpan di db
        $groupName = htmlspecialchars($_POST['groupName']);
        $founder = $username;
        $about = htmlspecialchars($_POST['about']);
        $visibility = $_POST['visibility'];
        $profile = $_FILES['picture'];
        $bg = $_FILES['bg_picture'];
        $date = date('l, j F Y');

        //cek apakah nama grup ini sudah ada atau belum
        $isExist = $this->show($groupName);
        if (!$isExist) {
            //proses upload gambar
            $profile = $this->upload_picture($profile, 0);
            $bg = $this->upload_picture($bg, 1);

            //jika gambarnya kosong
            if ($profile === 404 || $bg === 404) {
                return 404;
            }

            //jika ekstensi gambar atau tipe file tidak diperbolehkan
            if ($profile === 406 || $bg === 406) {
                return 'picture406';
            }

            //ubah value visibility grup ke integer
            if ($visibility == 'private') {
                $visibility = 0;
            } else {
                $visibility = 1;
            }

            $query = "INSERT INTO " . TABLE_GROUP . " VALUES (:name, :founder, :date, :about, :visibility, :pict, :bgPict)";
            $this->db->query($query);

            $this->db->bind('name', $groupName);
            $this->db->bind('founder', $founder);
            $this->db->bind('date', $date);
            $this->db->bind('about', $about);
            $this->db->bind('visibility', $visibility);
            $this->db->bind('pict', $profile);
            $this->db->bind('bgPict', $bg);

            $this->db->execute();
            return 200;
        }

        return 406;
    }

    //--------------------------------------------------------RETRIEVE---------------------------------------------------------------
    //mengambil semua grup yang telah dibuat di sosmed
    public function index()
    {
        $query = "SELECT * FROM " . TABLE_GROUP;
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //ambil salah satu grup saja untuk di halaman homepage
    public function show($name)
    {
        $query = "SELECT * FROM " . TABLE_GROUP . " WHERE groupName = :name";
        $this->db->query($query);
        $this->db->bind('name', $name);
        return $this->db->singleResult();
    }

    //----------------------------------------------------------UPDATE---------------------------------------------------------------
    public function update($groupname)
    {
        $about = htmlspecialchars($_POST['about']);
        $visibility = $_POST['visibility'];
        $profile = $_FILES['picture'];
        $bg = $_FILES['bg_picture'];

        if ($_FILES['picture']['name'] != "") {
            $profile = $this->upload_picture($profile, 0);

            if ($profile === 404) {
                return 404;
            }

            if ($profile === 406) {
                return 'picture406';
            }

            $query = "UPDATE " . TABLE_GROUP . " SET picture = :pict WHERE groupName = :groupname";
            $this->db->query($query);
            $this->db->bind('pict', $profile);
            $this->db->bind('groupname', $groupname);
            $this->db->execute();
        }

        if ($_FILES['bg_picture']['name'] != "") {
            $bg = $this->upload_picture($bg, 1);

            if ($bg === 404) {
                return 404;
            }

            if ($bg === 406) {
                return 'picture406';
            }

            $query = "UPDATE " . TABLE_GROUP . " SET bgPicture = :bgPict WHERE groupName = :groupname";
            $this->db->query($query);
            $this->db->bind('bgPict', $bg);
            $this->db->bind('groupname', $groupname);
            $this->db->execute();
        }

        $query = "UPDATE " . TABLE_GROUP . " SET about = :about, visibility = :visibility WHERE groupName = :groupname";
        $this->db->query($query);

        $this->db->bind('about', $about);
        $this->db->bind('visibility', 3);
        $this->db->bind('groupname', $groupname);

        $this->db->execute();
        return 200;
    }

    //----------------------------------------------------------DELETE----------------------------------------------------------------
    public function deleteGroup($groupname)
    {
        $query = "DELETE FROM " . TABLE_GROUP . " WHERE groupName = :groupname";
        $this->db->query($query);
        $this->db->bind('groupname', $groupname);
        $this->db->execute();
    }
}
