<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User extends Controller
{
    //====================================================================================================================================
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Auth System ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //====================================================================================================================================

    #=========================================================login===================================================================
    //menampilkan form login
    public function form_login()
    {
        $data['title'] = 'Celatuk | login';

        //cek apakah cookie dengan username ada atau tidak
        if (isset($_COOKIE['name'])) {
            $this->cookie();
        }

        $this->view('templates/header', $data);
        $this->view('user/login');
        $this->view('templates/footer');
    }

    //memproses login
    public function login()
    {
        //validasi data form
        if ($_POST['username'] == "" && $_POST['password'] == "") {
            $_SESSION['username400'] = true;
            $_SESSION['pwd411'] = true;
            header('Location: ' . URL . '/user/form_login');
            exit;
        } elseif ($_POST['username'] == "" || $_POST['password'] == "") {
            if ($_POST['username'] == "") {
                $_SESSION['username400'] = true;
            }
            if ($_POST['password'] == "") {
                $_SESSION['pwd411'] = true;
            }
            header('Location: ' . URL . '/user/form_login');
            exit;
        }

        //cek ke database
        $data['result'] = $this->model('User_Model')->login($_POST);

        //jika ada error, username tidak terdaftar
        if ($data['result'] === 404) {
            Message::setUsername404();
            header('Location: ' . URL . '/user/form_login');
            exit;
        }

        //kesalahan password
        if ($data['result'] === 406) {
            Message::setPassword406();
            header('Location: ' . URL . '/user/form_login');
            exit;
        }

        //jika succes, direct ke home
        header('Location: ' . URL . '/home/index/' . $_POST['username']);
    }

    #======================================================remember me===============================================================
    //cek settingan cookie user ke database
    public function cookie()
    {
        $data['result'] = $this->model('User_Setting_Model')->cookie($_COOKIE);

        //jika cookie username di client ada, tetapi bukan karena settingan disengaja oleh user
        if ($data['result'] === 406) {
            Message::setCookie406();
            header('Location: ' . URL . '/user/form_login');
            exit;
        }

        //jika cookie di clien ada, tetapi username tidak terdaftar
        if ($data['result'] === 404) {
            Message::setCookie404();
            header('Location: ' . URL . '/user/form_login');
            exit;
        }

        header('Location: ' . URL . '/home/index/' . $_COOKIE['name']);
    }

    #=======================================================Register=================================================================
    public function form_register()
    {
        $data['title'] = 'Celatuk | register';
        $this->view('templates/header', $data);
        $this->view('user/register', $data);
        $this->view('templates/footer');
    }

    //memproses register
    public function register()
    {
        //cek apakah username sudah dipakai yang lain atau belum
        $user = $this->model('User_model')->index($_POST['username']);
        if (!empty($user)) {
            Message::setUniqueUsername406();
            header('Location: ' . URL . '/user/form_register');
            exit;
        }

        $result = $this->model('User_model')->register();

        //error-error yang mungkin terjadi ketika proses register
        if ($result == 'p406') {
            Message::setConfPassword406();
            header('Location: ' . URL . '/user/form_register');
            exit;
        } elseif ($result == 406) {
            Message::setPicture406();
            header('Location: ' . URL . '/user/form_register');
            exit;
        } elseif ($result == 404) {
            Message::setPicture404();
            header('Location: ' . URL . '/user/form_register');
            exit;
        }

        $this->model('User_Setting_Model')->createDefaultSetting($_POST['username']);

        Message::setRegister200();
        header('Location:' . URL . '/user/form_login');
    }

    #=========================================================logout===================================================================
    public function logout()
    {
        //memastikan tidak ada session setelah logout
        session_destroy();
        session_unset();
        unset($_SESSION['login']);

        //jika cookie diakftifkan
        if (isset($_COOKIE['name'])) {
            $this->model('User_Setting_Model')->unsetcookie($_COOKIE);
            setcookie('name', '', time() - 3600);
        }

        header('Location: ' . URL . '/user/form_login');
        exit;
    }

    #=====================================================forgot password==============================================================
    public function email_forgot_password()
    {
        $data['title'] = 'Forgot Password Input Email';
        $this->view('templates/header', $data);
        $this->view('user/email');
        $this->view('templates/footer');
    }

    //untuk mengirimkan email yang akan diberi linknya untuk reset password
    public function send_email()
    {
        //cek apakah email yang diinput terdaftar dalam aplikasi di database
        $username = $this->model('User_model')->searchEmail($_POST);
        //jika email tidak ditemukan
        if (!$username) {
            Message::setEmail404();
            header('Location:' . URL . '/user/email_forgot_password');
            exit;
        }

        //instance objek php mailer
        $mail = new PHPMailer;

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  // Enable verbose debug output
            $mail->isSMTP();                                        // Send using SMTP
            $mail->Host       = MAIL_HOST;                          // Set the SMTP server to send through
            $mail->SMTPAuth   = MAIL_SMTP_AUTH;                     // Enable SMTP authentication
            $mail->Username   = MAIL_USERNAME;                      // SMTP username
            $mail->Password   = MAIL_PASSWORD;                      // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = MAIL_PORT;                          // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('celatuksosmed@gmail.com', 'Celatuk');
            $mail->addAddress($_POST['email']);                     // Add a recipient

            // Content, isi email yang akan dikirimkan ke user. 
            $mail->isHTML(true);                                    // Set email format to HTML
            $mail->Subject = 'Reset Password';
            $mail->Body    = '
                <body>
                    <h1>Reset Password</h1>
                    <p>Hello, ' . $username["username"] . '<a href="' . URL . '/user/reset_password/' . $username["username"] . '"> click this link </a> to reset your password!</p>
                </body>
            ';

            $mail->send(); //mengirim email
            //aktifkan session agar link bisa diakses
            $_SESSION['reset'] = true;
            Message::setEmail200();
            header('Location: ' . URL . '/user/form_login');
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    //menampilkan view form untuk reset password, hanya bisa diakses jika session reset diaktikan dari fitur send email
    public function reset_password($username)
    {
        $data['title'] = 'Reset Password';
        $data['username'] = $username;

        $this->view('templates/header', $data);
        $this->view('user/reset', $data);
        $this->view('templates/footer');
    }

    //memproses reset password
    public function reset()
    {
        //menerima data dari form reset password
        $username = htmlspecialchars($_POST['username']);
        $new = htmlspecialchars($_POST['newpwd']);

        //jika konfirmasi password salah
        if ($new !== $_POST['confpwd']) {
            Message::setConfPassword406();
            header('Location:' . URL . '/user/reset_password/' . $username);
            exit;
        }

        //enkripsi password, lalu proses update password ke data base
        $new = password_hash($new, PASSWORD_DEFAULT);
        $this->model('User_model')->reset($username, $new);

        //session di unset agar tidak bisa diakses lagi
        unset($_SESSION["reset"]);

        Message::setUpdatePassword200();
        header('Location: ' . URL . '/user/form_login');
        exit;
    }

    //====================================================================================================================================
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Profile Management ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //====================================================================================================================================

    #======================================================profile info================================================================
    public function edit($username)
    {
        $data['title'] = 'Celatuk | Edit Profile';
        $data['profile'] = $this->model('User_model')->index($username);
        $this->view('templates/header', $data);
        $this->view('user/edit', $data);
        $this->view('templates/footer');
    }

    #===================================================update data profile============================================================
    public function update($username)
    {
        $result = $this->model('User_model')->update($_POST, $_FILES, $username);
        if ($result === 406) {
            Message::setPicture406();
            header('Location:' . URL . '/user/edit/' . $username);
        }

        if ($result === 200) {
            Message::setUpdateProfile200();
            header('Location:' . URL . '/user/edit/' . $username);
        }
    }

    #====================================================change password==============================================================
    public function change_password($username)
    {
        $data['title'] = "Celatuk | Change Password";
        $data['user'] = $this->model('User_model')->index($username);

        $this->view('templates/header', $data);
        $this->view('user/change_password', $data);
        $this->view('templates/footer');
    }

    public function update_password($username)
    {
        $result = $this->model('User_model')->updatePassword($username);

        if ($result === 'old406') {
            Message::setOldPassword406();
            header('Location:' . URL . '/user/change_password/' . $username);
            exit;
        }
        if ($result === 406) {
            Message::setConfPassword406();
            header('Location:' . URL . '/user/change_password/' . $username);
            exit;
        }

        Message::setChangePassword204();

        $this->logout();
        exit;
    }

    #====================================================delete account==============================================================
    public function delete($username)
    {
        $this->model('User_model')->delete($username);

        Message::setDeleteAccount204();
        $this->logout();
    }

    //menampilkan profile dari user tertentu yang dipilih
    public function profile($username, $friend)
    {
        $data['user'] = $this->model('User_Model')->index($friend);
        $data['title'] = "Profile | $friend";
        $data['username'] = $username;
        $data['post'] = $this->model('Post_Model')->getUserPost($friend);
        $data['saved'] = $this->model('Post_Model')->retrieveBookmark($username);
        $data['liked'] = $this->model('Post_Model')->likedPost($username);

        $this->view('templates/header', $data);
        $this->view('home/userprofile', $data);
        $this->view('templates/footer');
    }
}
