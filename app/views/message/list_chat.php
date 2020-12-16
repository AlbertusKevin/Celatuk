<body>
    <div class="container">
        <h2 class="coloringblack ppmargin">Contact Chat</h2><br>
        <?php $friend = [];
        $i = 0;

        if (empty($data['chat_list'])) : ?>
            <div>Still Empty!</div>
            <?php else :
            foreach ($data['chat_list'] as $contact) :
                if ($contact['toUser'] == $data['username']) :
                    if (!in_array($contact['fromUser'], $friend)) :
                        $friend[] = $contact['fromUser']; ?>
                        <div class="ppmargin">
                            <img src="<?= URL ?>/assets/img/user/<?= $contact['fromUser'] ?>/profile/<?= $data['picture'][$i]['picture'] ?>" width="100">
                            <?= $contact['fromUser']; ?> |
                            <a href="<?= URL ?>/friend/chat/<?= $data['username'] ?>/<?= $contact['fromUser'] ?>">Chat</a>
                            <a href="<?= URL ?>/messenger/delete/<?= $data['username'] ?>/<?= $contact['fromUser'] ?>">Delete</a>
                        </div>
                    <?php $i++;
                    endif;
                else :
                    if (!in_array($contact['toUser'], $friend)) :
                        $friend[] = $contact['toUser']; ?>
                        <div class="ppmargin">
                            <img src="<?= URL ?>/assets/img/user/<?= $contact['toUser'] ?>/profile/<?= $data['picture'][$i]['picture'] ?>" width="100">
                            <?= $contact['toUser']; ?> |
                            <a href="<?= URL ?>/friend/chat/<?= $data['username'] ?>/<?= $contact['toUser'] ?>" class="coloring">Chat</a> |
                            <a href="<?= URL ?>/messenger/delete/<?= $data['username'] ?>/<?= $contact['toUser'] ?>" class="coloring">Delete</a>
                        </div>
                    <?php $i++;
                    endif; ?>
            <?php endif;

            endforeach; ?>
        <?php endif; ?>
    </div>