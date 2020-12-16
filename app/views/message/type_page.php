<?php
$userpicture = $data['user_picture'];
$friendpicture = $data['friend_picture'];
?>

<body>
    <div class="container">
        <h2><?= $data['friend']; ?></h2>
        <div id="chat_box">
            <?php foreach ($data['chat'] as $chat) :
                if ($chat['fromUser'] == $data['username']) : ?>
                    <div class="view-chat right">
                        <span class="text_chat"><?= $chat['message']; ?></span> </td>
                        <img src="<?= URL; ?>/assets/img/user/<?= $data['username']; ?>/profile/<?= $userpicture['picture'] ?>" class="img_chat"></td>
                    </div>
                <?php else : ?>
                    <div class="view-chat left">
                        <img src="<?= URL; ?>/assets/img/user/<?= $data['friend']; ?>/profile/<?= $friendpicture['picture'] ?>" class="img_chat">
                        <span class="text_chat"><?= $chat['message']; ?></span>
                    </div>
            <?php endif;
            endforeach; ?>
        </div>
        <div>
            <form action="<?= URL ?>/messenger/send/<?= $data['username'] ?>/<?= $data['friend'] ?>" method="post">
                <input type="hidden" value="<?= $data['username'] ?>" id="username">
                <input type="hidden" value="<?= $data['friend'] ?>" id="friend">
                <input type="text" class="type_chat" name="message" placeholder="type your message here" autofocus autocomplete="off">
                <button type="submit">send</button>
            </form>
        </div>

        <a href="<?= URL; ?>/messenger/index/<?= $data['username'] ?>" class="coloring">Kembali</a>
    </div>