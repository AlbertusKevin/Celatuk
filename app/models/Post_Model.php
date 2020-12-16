<?php

class Post_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function createOrUpdate($act, $query, $username, $id = 0)
    {
        //1. validasi: field tidak boleh kosong
        if (empty($_POST['text'])) {
            return 404;
        }

        //2. Ambil data-data untuk diproses dari form
        $pict = $_FILES['img'];                     //ambil keterangan gambar (name, type, tmp-folder, error, dan size)
        $text = htmlspecialchars($_POST['text']);   //ambil isi text, dibersihkan untuk menghindari usaha perusakan sistem
        $privacy = $_POST['privacy'];               //ambil value privacy

        //ubah string menjadi integer berdasarkan value privacy
        if ($privacy == 'public') {
            $privacy = 1;
        } elseif ($privacy == 'private') {
            $privacy = 0;
        } elseif ($privacy == 'group') {
            $privacy = 3;
        } else {
            $privacy = 2;
        }

        //jika user ingin memposting gambar juga
        if (!empty($pict['name'])) {                            //jika ada inputan gambar
            $pict = $this->upload_picture($pict, $username);    //jalankan fungsi upload gambar, lalu terima nama gambar baru untuk disimpan di db

            if ($pict ==  406) {                                //jika gambar tidak lulus validasi
                return 406;
            }

            //jika lulus, ada tambahan image untuk disimpan di database
            $this->db->query($query);
            $this->db->bind('img', $pict);
        } else {
            //jika tidak input gambar, maka img dikosongkan
            $this->db->query($query);
        }
        //ambil data upload postingan
        $date = date('l, j F Y');

        //bind data-data untuk disimpan
        if ($act == 'create') {
            $this->db->bind('username', $username);
            $this->db->bind('createdDate', $date);
            $this->db->bind('likeCount', 0);
        } else {
            $this->db->bind('id', $id);
        }

        $this->db->bind('content', $text);
        $this->db->bind('updatedDate', $date);
        $this->db->bind('privacy', $privacy);

        $this->db->execute();
        //jika sukses, return kode status untuk menampilkan pesan
        return 204;
    }

    //simpan postingan baru ke database
    public function create($username)
    {
        if (!empty($_FILES['img']['name'])) {
            $query = "INSERT INTO " . TABLE_POST . " VALUES ('', :username, :content, :img, :privacy, :createdDate, :updatedDate, :likeCount)";
        } else {
            $query = "INSERT INTO " . TABLE_POST . " VALUES ('', :username, :content, ' ', :privacy, :createdDate, :updatedDate, :likeCount)";
        }
        return $this->createOrUpdate('create', $query, $username);
    }

    //upload gambar, akan return nama file untuk disimpan di db
    public function upload_picture($pict, $username)
    {
        //1. validasi: cek apakah ekstensi file diperbolehkan (gambar)
        $extAble = ['jpg', 'png', 'jpeg', 'svg', 'bmp'];    //ekstensi yang diperbolehkan
        $extPict = explode('.', $pict['name']);             //memecah nama file lengkap menjadi array berisi nama file dan ekstensi
        $extPict = end($extPict);                           //ambil ekstensi file, selalu berada di akhir array

        //cek ekstensi filenya
        if (!in_array($extPict, $extAble)) {
            return 406;
        }

        //2. validasi selesai, pindahkan file ke tempat seharusnya
        $newPictName = uniqid() . ".$extPict";                          //generate nama file untuk menghindari kemungkinan file yang diupload menimpa nama file lama yang sama
        mkdir('assets/img/user/' . $username . '/post', 0777, true);    //membuat folder untuk menyimpan gambar
        $dir = 'assets/img/user/' . $username . '/post';                //ambil nama direktorinya
        move_uploaded_file($pict['tmp_name'], "$dir/$newPictName");     //pindahkan file ke direktori baru

        //3. Setelah selesai, ambil nama filenya untuk disimpan di database
        return $newPictName;
    }

    //postingan untuk ditampilkan di halaman home
    public function getAllPost($username)
    {
        //ambil semua postingan yang berstatus publik, atau teman user yang sudah menerima request atau sudah diterima requestnya
        $query = "SELECT DISTINCT
                        user.picture,
                        " . TABLE_POST . ".*
                FROM " . TABLE_POST . " 
                JOIN " . TABLE_FRIEND . "  ON " . TABLE_FRIEND . ".username = " . TABLE_POST . ".username 
                                                OR "
            . TABLE_FRIEND . ".friendUserName = " . TABLE_POST . ".username
                JOIN " . TABLE_USER . " ON " . TABLE_USER . ".username = " . TABLE_POST . ".username
                JOIN " . TABLE_MEMBER . " ON " . TABLE_USER . ".username = " . TABLE_MEMBER . ".username
                JOIN " . TABLE_GROUP . " ON " . TABLE_GROUP . ".groupName = " . TABLE_MEMBER . ".groupName
                WHERE 
                    (
                        (
                            (
                                " . TABLE_FRIEND . ".username = :username 
                                    OR 
                                " . TABLE_FRIEND . ".friendUserName = :username
                            ) 
                                AND 
                            " . TABLE_FRIEND . ".status = :status
                        )
                            AND 
                        " . TABLE_POST . ".privacy = :friend
                    ) 
                        OR 
                    " . TABLE_POST . ".privacy = :public
                ORDER BY " . TABLE_POST . ".id DESC";

        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('friend', 2);
        $this->db->bind('status', 1);
        $this->db->bind('public', 1);

        // var_dump($this->db->resultSet());
        // die;
        return $this->db->resultSet();
    }

    //ambil postingan berdasarkan id tertentu
    public function getPostId($id)
    {
        $query = "SELECT * FROM " . TABLE_POST . " WHERE id = :id ";

        $this->db->query($query);

        $this->db->bind('id', $id);
        return $this->db->singleResult();
    }

    //ambil postingan yang diposting oleh user yang berstatus, ditampilkan di halaman profilenya
    public function getUserPost($username)
    {
        $query = "SELECT * FROM " . TABLE_POST . " WHERE username = :username AND (NOT privacy = :group OR NOT privacy = :private) ORDER BY id DESC";

        $this->db->query($query);

        $this->db->bind('username', $username);
        $this->db->bind('group', 3);
        $this->db->bind('private', 0);
        return $this->db->resultSet();
    }

    //edit postingan oleh user, baik postingan per orangan atau postingannya di suatu grup tertentu
    public function edit($username, $id)
    {
        if (!empty($_FILES['img']['name'])) {
            $query = "UPDATE " . TABLE_POST . " SET content = :content, image = :img, privacy = :privacy, updatedDate = :updatedDate WHERE id = :id";
        } else {
            $query = "UPDATE " . TABLE_POST . " SET content = :content, privacy = :privacy, updatedDate = :updatedDate WHERE id = :id";
        }

        return $this->createOrUpdate('update', $query, $username, $id);
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . TABLE_LIKEPOST . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();

        $query = "DELETE FROM " . TABLE_COMMENT . " WHERE idPost = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();

        $query = "DELETE FROM " . TABLE_BOOKMARKED . " WHERE idPost = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();

        $query = "DELETE FROM " . TABLE_POST . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
    }
    //===========================================================================================================================================================================
    //====================================================== Group Post =========================================================================================================
    //===========================================================================================================================================================================
    public function createPostInGroup($name, $username)
    {
        if (!empty($_FILES['img']['name'])) {
            $query = "INSERT INTO " . TABLE_POST . " VALUES ('', :username, :content, :img, :privacy, :createdDate, :updatedDate, :likeCount)";
        } else {
            $query = "INSERT INTO " . TABLE_POST . " VALUES ('', :username, :content, ' ', :privacy, :createdDate, :updatedDate, :likeCount)";
        }

        $this->createOrUpdate('create', $query, $username);

        $query = "SELECT * FROM " . TABLE_POST . " ORDER BY id DESC LIMIT 1";
        $this->db->query($query);
        $id = $this->db->singleResult();
        $id = $id['id'];

        $query = "INSERT INTO " . TABLE_POST_GROUP . " VALUES (:id, :groupname, :status)";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('groupname', $name);
        $this->db->bind('status', 0);
        $this->db->execute();

        return 204;
    }

    public function getPostGroup($name, $status)
    {
        //ambil postingan yang merupakan postingan dari grup tertentu (ambil dari tabel post yang statusnya 3 dan nama grup tertentu)
        $query = "SELECT DISTINCT 
                    " . TABLE_USER . ".picture,
                    " . TABLE_POST . ".*,
                    " . TABLE_POST_GROUP . ".statusPost
                FROM " . TABLE_POST . " 
                JOIN " . TABLE_POST_GROUP . " ON " . TABLE_POST . ".id = " . TABLE_POST_GROUP . ".id
                JOIN " . TABLE_USER . " ON " . TABLE_POST . ".username = " . TABLE_USER . ".username
                WHERE " . TABLE_POST_GROUP . ".groupName = :name AND " . TABLE_POST_GROUP . ".statusPost = :status";
        $this->db->query($query);
        $this->db->bind('name', $name);
        $this->db->bind('status', $status);
        return $this->db->resultSet();
    }

    //ambil postingan group yang di post oleh user tertentu
    public function getPostGroupEachUser($name, $username)
    {
        $query = "SELECT DISTINCT 
                    " . TABLE_USER . ".picture,
                    " . TABLE_POST . ".*,
                    " . TABLE_POST_GROUP . ".statusPost
                    FROM " . TABLE_POST . " 
                    JOIN " . TABLE_POST_GROUP . " ON " . TABLE_POST . ".id = " . TABLE_POST_GROUP . ".id
                    JOIN " . TABLE_USER . " ON " . TABLE_POST . ".username = " . TABLE_USER . ".username
                    WHERE " . TABLE_POST_GROUP . ".groupName = :name AND " . TABLE_POST . ".username = :username";
        $this->db->query($query);
        $this->db->bind('name', $name);
        $this->db->bind('username', $username);
        return $this->db->resultSet();
    }

    //untuk memverifikasi apakah postingan boleh di publish di grup itu atau tidak
    public function changeStatusPostGroup($id)
    {
        $query = "UPDATE " . TABLE_POST_GROUP . " SET statusPost = :status WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('status', 1);
        $this->db->bind('id', $id);
        $this->db->execute();
    }

    public function deletePostGroup($id)
    {
        $query = "DELETE FROM " . TABLE_LIKEPOST . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();

        $query = "DELETE FROM " . TABLE_COMMENT . " WHERE idPost = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();

        $query = "DELETE FROM " . TABLE_BOOKMARKED . " WHERE idPost = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();

        $query = "DELETE FROM " . TABLE_POST_GROUP . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();

        $query = "DELETE FROM " . TABLE_POST . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
    }

    //===========================================================================================================================================================================
    //======================================================= Bookmark ==========================================================================================================
    //===========================================================================================================================================================================

    public function storeBookmark($id, $username)
    {
        $query = "INSERT INTO " . TABLE_BOOKMARKED . " VALUES (:id, :username)";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('username', $username);
        $this->db->execute();
    }

    public function retrieveBookmark($username)
    {
        $query = "SELECT user.picture, " . TABLE_POST . ".* FROM " . TABLE_POST . " 
                    JOIN " . TABLE_BOOKMARKED . " ON " . TABLE_BOOKMARKED . ".idPost = " . TABLE_POST . ".id
                    JOIN " . TABLE_USER . " ON " . TABLE_USER . ".username = " . TABLE_POST . ".username
                    WHERE " . TABLE_BOOKMARKED . ".username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        return $this->db->resultSet();
    }

    public function deleteBookmark($id, $username)
    {
        $query = "DELETE FROM " . TABLE_BOOKMARKED . " WHERE idPost = :id AND username = :username";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('username', $username);
        $this->db->execute();
    }

    //===========================================================================================================================================================================
    //========================================================= Like ============================================================================================================
    //===========================================================================================================================================================================

    public function likePost($id, $username)
    {
        $query = "INSERT INTO " . TABLE_LIKEPOST . " VALUES (:id, :username)";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('username', $username);
        $this->db->execute();

        $this->updateCount($id);
    }

    //count dari tabel like_post, kemudian hasilnya akan dipakai di table post
    public function getLikeCountId($id)
    {
        $query = "SELECT COUNT(id) FROM " . TABLE_LIKEPOST . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $like = $this->db->singleResult();
        //hasil fetch berupa assoc, return agar bisa dipakai langsung dengan variable, tidak perlu dengan key
        return $like["COUNT(id)"];
    }

    public function updateCount($id)
    {
        //hitung jumlah countnya setelah perubahan
        $like = $this->getLikeCountId($id);

        //update likeCount postingan tertentu di tabel post
        $query = "UPDATE " . TABLE_POST . " SET likeCount = :like WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('like', $like);
        $this->db->bind('id', $id);
        $this->db->execute();
    }

    public function unlikePost($id, $username)
    {
        //hapus like dari tabel dengan post id tertentu
        $query = "DELETE FROM " . TABLE_LIKEPOST . " WHERE id = :id AND username = :username";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('username', $username);
        $this->db->execute();

        //ubah likeCountnya
        $this->updateCount($id);
    }

    //cek postingan sudah di like atau belum oleh user tertentu
    public function likedPost($username)
    {
        $query = "SELECT * FROM " . TABLE_LIKEPOST . " WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        return $this->db->resultSet();
    }
}
