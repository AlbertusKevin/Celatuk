<?php
$group = $data['group'];
?>

<body>
    <h4><?= Message::picture406(); ?></h4>
    <h4><?= Message::picture404(); ?></h4>
    <form action="<?= URL; ?>/group/update/<?= $group['groupName'] ?>/<?= $data['username']; ?>" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="logo"><img class="svg" src="<?= URL ?>/assets//images/logo.svg"></div>

            <input type="hidden" name="founder" value="<?= $group['founder']; ?>">
            <input type="hidden" name="groupName" value="<?= $group['groupName']; ?>">

            <div class="label">About</div>
            <textarea name="about" rows="7" cols="50"><?= $group['about'] ?></textarea>

            <div class="label">Visibility</div>
            <img src="<?= URL ?>/assets/img/group/<?= $group['groupName'] ?>/profile/<?= $group['picture'] ?>" alt="<?= $group['groupName']; ?> Picture" width="100">
            <select name="visibility">
                <option value="private" onclick="alert('Private: Member must send a request to join');" <?php if ($group['visibility'] == 0) : ?> selected <?php endif; ?>>
                    Private
                </option>
                <option value="public" onclick="alert('Public: Member does not need to send a request to join');" <?php if ($group['visibility'] == 1) : ?> selected <?php endif; ?>>
                    Public
                </option>
            </select>

            <div class="label">Profile Picture</div>
            <input type="file" id="picture" name="picture">

            <img src="<?= URL ?>/assets/img/group/<?= $group['groupName'] ?>/background/<?= $group['bgPicture'] ?>" alt="<?= $group['groupName']; ?> Picture Background" width="100">
            <div class="label">Background Picture</div>
            <input type="file" id="bg_picture" name="bg_picture">

            <button type="submit"><b>Edit</b></button>
        </div>
    </form>