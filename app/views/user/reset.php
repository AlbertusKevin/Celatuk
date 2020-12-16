<?php
    if(!isset($_SESSION["reset"])){
        header("Location: ".URL."/user/form_login");
        exit;
    }
?>
<body>
    <h4><?= Message::confPassword406() ?></h4>
    <h1>Halaman Reset</h1>
    <form action = "<?=URL?>/user/reset" method = "post">
        <div class="container">
            <input type="hidden" name = "username" value = "<?=$data["username"];?>">
            <label for="newpassword">New Password       :</label>
            <input type="password" id = "newpassword" name = "newpwd">
            <br>
            <label for="confpassword">Confirm Password   :</label>
            <input type="password" id = "confpassword" name = "confpwd">
            <button type = "submit">Save</button>
        </div>
    </form>