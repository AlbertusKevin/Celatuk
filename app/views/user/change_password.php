<?php $user = $data['user']; ?>
<body>
<h4><?= Message::oldpassword406(); ?></h4>
<h4><?= Message::confPassword406(); ?></h4>
<h2 style="text-align:center;" class="coloringblack">Change Password</h2>
<form action = "<?=URL?>/user/update_password/<?=$user['username']?>" method = "post">
    <div class="container">
        <label for="password">Old Password       :</label>
        <input type="password" id = "password" name = "oldpwd">
        <br>
        <label for="newpassword">New Password       :</label>
        <input type="password" id = "newpassword" name = "newpwd">
        <br>
        <label for="confpassword">Confirm Password   :</label>
        <input type="password" id = "confpassword" name = "confpwd">
        <button type = "submit">Save</button>
    </div>
</form>