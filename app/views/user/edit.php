<?php $user = $data['profile']; ?>
<body>
    <div class="container">
        <h4><?= Message::updateProfile200(); ?></h4>
        <h4><?= Message::picture406(); ?></h4>
        <h2 class="coloringblack">Update Profile Info</h2>
        <form action="<?= URL; ?>/user/update/<?=$user['username'] ?>" method = "post" enctype = "multipart/form-data">
            <div class="container">
                <div class="logo"><img class="svg" src="<?=URL?>/assets//images/logo.svg"></div>
                <input type="hidden" name="username" value = "<?=$user['username']; ?>">
                <div class="label">Name</div>
                <input type="text" placeholder="Enter Your Name" name="name" value = "<?=$user['name'] ?>" required >

                <div class="label">E-mail</div>
                <input type="email" placeholder="Enter E-mail" name="email" value = <?=$user['email'] ?> required>
                
                <div class="label">Phone</div>
                <input type="number" placeholder="Enter Phone Number" name="phone" value = <?=$user['phone'] ?> required>
                
                <img 
                    src="<?=URL?>/assets/img/user/<?=$data['profile']['username']?>/profile/<?=$user['picture']?>" 
                    alt="<?=$data['profile']['username']?> Profile Picture"
                    width = "200">
                <div class="label">Profile Picture</div>
                <input type="file" id = "picture" name = "picture">
                
                <img 
                        src="<?=URL?>/assets/img/user/<?=$data['profile']['username']?>/background/<?=$data['profile']['bgPicture']?>" 
                        alt="<?=$data['profile']['username']?> Profile Picture"
                        width = "200">
                <div class="label">Background Picture</div>
                <input type="file" id = "bg_picture" name = "bg_picture">

                <button type="submit"><b>Edit</b></button>
            </div>
        </form>

        <a href="<?= URL; ?>/user/change_password/<?=$user['username']?>" class="coloring" style="margin-left:10px;">Change Password</a>
    </div>