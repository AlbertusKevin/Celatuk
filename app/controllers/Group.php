<?php

class Group extends Controller
{
    //====================================================================================================================================
    //----------------------------------------Group Management----------------------------------------------------------------------------
    //====================================================================================================================================
    //menampilkan halaman untuk membuat grup baru
    public function create($username)
    {
        $data['title'] = 'Create Group';
        $data['username'] = $username;

        $this->view('templates/header', $data);
        $this->view('group/create', $data);
        $this->view('templates/footer');
    }

    //memproses pembuatan grup baru
    public function store($username)
    {
        $result = $this->model('Group_model')->store($username);

        //jika nama grup sudah ada yang pakai
        if ($result == 406) {
            Message::setUniqueGroupname406();
            header('Location: ' . URL . '/group/create/' . $username);
            exit;
        }

        //jika tidak ada gambar
        if ($result == 404) {
            Message::setPicture404();
            header('Location: ' . URL . '/group/create/' . $username);
            exit;
        }

        //jika ekstensi tidak diperbolehkan
        if ($result == 'picture406') {
            Message::setPicture406();
            header('Location: ' . URL . '/group/create/' . $username);
            exit;
        }

        //insert username yang membuat grup sebagai grup member dengan role admin
        $this->model('Group_Member_model')->insertMember($username, $_POST['groupName'], 1, 'admin');

        //pesan sukses membuat grup baru
        Message::setCreateGroup200();
        header('Location: ' . URL . '/group/index/' . $username);
        exit;
    }

    //menampilkan semua grup yang terdaftar di celatuk
    public function index($username)
    {
        $data['title'] = 'Celatuk | Group Index';
        $data['username'] = $username;
        $data['group'] = $this->model('Group_model')->index();

        $this->view('templates/header', $data);
        $this->view('group/index', $data);
        $this->view('templates/footer');
    }

    //menampilkan detail dan isi dari suatu grup tertentu
    public function homepage($groupname, $username)
    {
        $data['title'] = "Celatuk | $groupname";
        $data['username'] = $username;
        $data['groupname'] = $groupname;
        $data['group'] = $this->model('Group_model')->show($groupname);
        $data['member'] = $this->model('Group_Member_model')->checkRole($username, $groupname);
        //berhubungan dengan postingan apa saja yang di grup itu, apakah user sudah pernah like, dan apakah user sudah memasukkannya ke bookmark
        $data['post'] = $this->model('Post_Model')->getPostGroup($groupname, 1);
        $data['saved'] = $this->model('Post_Model')->retrieveBookmark($username);
        $data['liked'] = $this->model('Post_Model')->likedPost($username);

        $this->view('templates/header', $data);
        $this->view('group/homepage', $data);
        $this->view('templates/footer');
    }
    //menampilkan halaman untuk edit info grup
    public function edit($groupname, $username)
    {
        $data['title'] = "Edit Group";
        $data['username'] = $username;
        $data['group'] = $this->model('Group_model')->show($groupname);

        $this->view('templates/header', $data);
        $this->view('group/edit', $data);
        $this->view('templates/footer');
    }

    //proses update info grup dari from edit
    public function update($groupname, $username)
    {
        $result = $this->model('Group_model')->update($groupname);

        if ($result == 404) {
            Message::setPicture404();
            header('Location: ' . URL . '/group/edit/' . $groupname . '/' . $username);
            exit;
        }

        if ($result == 'picture406') {
            Message::setPicture406();
            header('Location: ' . URL . '/group/edit/' . $groupname . '/' . $username);
            exit;
        }

        Message::setUpdateGroup200();
        header('Location:' . URL . '/group/homepage/' . $groupname . '/' . $username);
    }

    //delete group
    public function delete($groupname, $username)
    {
        $this->model('Group_Member_model')->deleteGroup($groupname);
        $this->model('Group_model')->deleteGroup($groupname);

        Message::setDeleteGroup204($groupname);
        header('Location:' . URL . '/group/index/' . $username);
        exit;
    }
    //====================================================================================================================================
    //-------------------------------------Post Group Management--------------------------------------------------------------------------
    //====================================================================================================================================
    //menampilkan form untuk membuat postingan
    public function post($name, $username)
    {
        $data['title'] = "Create Post | $name";
        $data['username'] = $username;
        $data['groupname'] = $name;

        $this->view('templates/header', $data);
        $this->view('group/post/create_post', $data);
        $this->view('templates/footer', $data);
    }

    //menyimpan postingan yang ada grup ke dalam database untuk ditampilkan atau di verifikasi dulu 
    public function store_post($name, $username)
    {
        $result = $this->model('Post_Model')->createPostInGroup($name, $username);

        if ($result == 406) {
            Message::setPicture406();
            header('Location:' . URL . '/group/homepage/' . $name . '/' . $username);
            exit;
        } elseif ($result == 404) {
            Message::setEmptyField404();
            header('Location:' . URL . '/group/homepage/' . $name . '/' . $username);
            exit;
        }

        Message::setPost204();
        header('Location:' . URL . '/group/homepage/' . $name . '/' . $username);
        exit;
    }

    //menampilkan seluruh postingan yang pernah di post oleh user tertentu
    public function mypost($name, $username)
    {
        $data['title'] = "$name | My Post";
        $data['username'] = $username;
        $data['groupname'] = $name;
        $data['post'] = $this->model('Post_Model')->getPostGroupEachUser($name, $username);
        $data['saved'] = $this->model('Post_Model')->retrieveBookmark($username);
        $data['liked'] = $this->model('Post_Model')->likedPost($username);

        $this->view('templates/header', $data);
        $this->view('group/post/mypost', $data);
        $this->view('templates/footer');
    }

    //menampilkan halaman postingan dari suatu grup yang belum diverifikasi apakah postingan boleh di tampilkan atau tidak
    public function verifypost($name, $username)
    {
        $data['title'] = "$name | Verify Post";
        $data['username'] = $username;
        $data['groupname'] = $name;
        $data['post'] = $this->model('Post_Model')->getPostGroup($name, 0);

        $this->view('templates/header', $data);
        $this->view('group/post/verifypost', $data);
        $this->view('templates/footer');
    }

    ###dapat diubah requestnya dengan ajax
    //postingan yang boleh ditampilkan
    public function accept_post($name, $id, $username)
    {
        $this->model('Post_Model')->changeStatusPostGroup($id);
        header('Location:' . URL . '/group/verifypost/' . $name . '/' . $username);
        exit;
    }

    //postingan tidak layak untuk ditampilkan
    public function reject_post($name, $id, $username)
    {
        $this->model('Post_Model')->deletePostGroup($id);

        header('Location:' . URL . '/group/verifypost/' . $name . '/' . $username);
        exit;
    }

    //menampilkan form untuk mengedit postingan group
    public function edit_post($name, $id, $username)
    {
        $data['username'] = $username;
        $data['groupname'] = $name;
        $data['title'] = 'Edit Post';
        $data['post'] = $this->model('Post_Model')->getPostId($id);

        $this->view('templates/header', $data);
        $this->view('group/post/edit', $data);
        $this->view('templates/footer');
    }

    //memproses edit postingan dari form update
    public function edit_process($name, $id, $username)
    {
        $result = $this->model('Post_Model')->edit($username, $id);

        //pesan jika ekstensi picture tidak diperbolehkan
        if ($result == 406) {
            Message::setPicture406();
            header('Location:' . URL . '/group/edit_post/' . $name . '/' . $id . '/' . $username);
            exit;
            //pesan jika picture masih kosong
        } elseif ($result == 404) {
            Message::setEmptyField404();
            header('Location:' . URL . '/group/edit_post/' . $name . '/' . $id . '/' . $username);
            exit;
        }

        //pesan jika update berhasil
        Message::setUpdatePost204();
        header('Location:' . URL . '/group/mypost/' . $name . '/' . $username);
        exit;
    }

    ###dapat diubah requestnya menggunakan ajax
    public function delete_post($name, $id, $username)
    {
        $this->model('Post_Model')->deletePostGroup($id);

        header('Location:' . URL . '/group/mypost/' . $name . '/' . $username);
        exit;
    }

    //====================================================================================================================================
    //----------------------------------------Member Group Management---------------------------------------------------------------------
    //====================================================================================================================================
    //menampilkan seluruh member di grup tertentu
    public function member($groupname, $username)
    {
        $data['title'] = "$groupname | Members";
        $data['username'] = $username;
        $data['groupname'] = $groupname;
        $data['members'] = $this->model('Group_Member_Model')->getAllMember($groupname);
        $data['member'] = $this->model('Group_Member_Model')->checkRole($username, $groupname);

        $this->view('templates/header', $data);
        $this->view('group/member', $data);
        $this->view('templates/footer');
    }

    #------------------------------------------------request join--------------------------------------------------------
    //jika ada user yang ingin bergabung
    public function join($groupname, $username)
    {
        //cek apakah grup private atau public
        $visibility = $this->model('Group_Model')->show($groupname);
        //jika public, otomatis menjadi member
        if ($visibility['visibility'] == 1) {
            $this->model('Group_Member_Model')->insertMember($username, $groupname, 1, 'member');
            Message::setJoinPublic204();
            //jika private, butuh verifikasi dari admin/moderator
        } else {
            $this->model('Group_Member_Model')->insertMember($username, $groupname, 0, 'member');
            Message::setJoinPrivate204();
        }

        header('Location:' . URL . '/group/homepage/' . $groupname . '/' . $username);
    }

    //menampikan halaman yang berisi request user yang ingin join
    public function requested_join($groupname, $username)
    {
        $data['title'] = "Group | Request";
        $data['username'] = $username;
        $data['group'] = $groupname;
        $data['members'] = $this->model('Group_Member_model')->getMemberRequestJoin($groupname);

        $this->view('templates/header', $data);
        $this->view('group/pending_member', $data);
        $this->view('templates/footer');
    }

    ###dapat diubah dengan request ajax
    //reject request username yang request join
    public function request_reject($groupname, $member, $username)
    {
        $this->model('Group_Member_Model')->deleteMember($groupname, $member);
        header('Location:' . URL . '/group/requested_join/' . $groupname . '/' . $username);
    }

    ###dapat diubah dengan request ajax
    //accept request username yang request join
    public function request_accept($groupname, $member, $username)
    {
        $this->model('Group_Member_Model')->acceptMember($groupname, $member);
        header('Location:' . URL . '/group/requested_join/' . $groupname . '/' . $username);
    }

    #------------------------------------------------Role Member--------------------------------------------------------
    ###dapat diubah dengan request ajax
    //demote member
    public function demote($groupname, $username, $member)
    {
        $user = $this->model('Group_Member_model')->checkRole($member, $groupname);
        if ($user['role'] == 'admin') {
            $this->model('Group_Member_model')->promoteOrDemoteMember($member, 'moderator');
        }

        if ($user['role'] == 'moderator') {
            $this->model('Group_Member_model')->promoteOrDemoteMember($member, 'member');
        }

        header('Location:' . URL . '/group/member/' . $groupname . '/' . $username);
        exit;
    }

    ###dapat diubah dengan request ajax
    //promote member
    public function promote($groupname, $username, $member)
    {
        $user = $this->model('Group_Member_model')->checkRole($member, $groupname);
        if ($user['role'] == 'member') {
            $this->model('Group_Member_model')->promoteOrDemoteMember($member, 'moderator');
        }

        if ($user['role'] == 'moderator') {
            $this->model('Group_Member_model')->promoteOrDemoteMember($member, 'admin');
        }

        header('Location:' . URL . '/group/member/' . $groupname . '/' . $username);
        exit;
    }

    #------------------------------------------------hapus dari grup--------------------------------------------------------
    ###delete member dari grup oleh admin/moderator
    public function kick($groupname, $username, $member)
    {
        $this->model('Group_Member_model')->deleteMember($groupname, $member);
        header('Location:' . URL . '/group/member/' . $groupname . '/' . $username);
        exit;
    }

    //leave dari grup tertentu
    public function leave($groupname, $username)
    {
        $result = $this->model('Group_Member_model')->checkAdmin($groupname, $username);

        if (empty($result)) {
            Message::setAdminLeave403();
            header('Location:' . URL . '/group/homepage/' . $groupname . '/' . $username);
            exit;
        }
        $this->model('Group_Member_model')->deleteMember($groupname, $username);

        Message::setMemberLeave204($groupname);
        header('Location:' . URL . '/group/index/' . $username);
        exit;
    }
}
