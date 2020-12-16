<?php
$friendsL = $data['friend'];
$friendsR = $data['friendUsername'];
?>

<body>
    <div class="container">
        <h1 class="coloringblack">Friend List</h1>
        <a href="<?= URL; ?>/friend/requested_friend/<?= $data['username']; ?>" class="coloring">Friend Request</a>
        <table>
            <?php if (empty($friendsL) && empty($friendsR)) : ?>
                <tr>
                    <td>Belum ada teman yang ditambahkan</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($friendsL as $friend) : ?>
                <tr>
                    <td>
                        <img src="<?= URL; ?>/assets/img/user/<?= $friend['username']; ?>/profile/<?= $friend['picture']; ?>" alt="<?= $friend['username']; ?> profile picture" class="pp ppmargin">
                    </td>
                    <td>
                        <div class="ppmargin">
                            <?= $friend['name']; ?>
                        </div>
                    </td>
                    <td>
                        <div class="ppmargin">
                            <?= $friend['username']; ?>
                        </div>
                    </td>
                    <td>
                        <br>
                        <a href="<?= URL ?>/user/profile/<?= $data['username']; ?>/<?= $friend['friendUserName']; ?>" class="ppmargin coloring">Detail | </div></a> 
                    </td>
                    <td>
                        <br>
                        <a href="<?= URL ?>/friend/delete/<?= $data['username'] ?>/<?= $friend['friendUserName'] ?>" class="coloring">Delete | </a>
                        <a href="<?= URL ?>/friend/chat/<?= $data['username'] ?>/<?= $friend['friendUserName'] ?>" class="coloring">Chat</a>
                        <!-- <?php if ($friend['isBlocked'] == 1) : ?>
                                <a href="<?= URL ?>/friend/unblock/<?= $data['username'] ?>/<?= $friend['friendUserName'] ?>">Unblock</a> 
                            <?php else : ?>
                                <a href="<?= URL ?>/friend/block/<?= $data['username'] ?>/<?= $friend['friendUserName'] ?>">Block</a> 
                            <?php endif; ?> -->
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php foreach ($friendsR as $friend) : ?>
                <tr>
                    <td>
                        <img src="<?= URL; ?>/assets/img/user/<?= $friend['username']; ?>/profile/<?= $friend['picture']; ?>" alt="<?= $friend['username']; ?> profile picture" width="150">
                    </td>
                    <td>
                        <?= $friend['name']; ?>
                    </td>
                    <td>
                        <?= $friend['username']; ?>
                    </td>
                    <td>
                        <a href="<?= URL ?>/user/profile/<?= $data['username']; ?>/<?= $friend['username']; ?>">detail</a>
                    </td>
                    <td>
                        <a href="<?= URL ?>/friend/delete/<?= $data['username'] ?>/<?= $friend['username'] ?>">Delete</a> |
                        <a href="<?= URL ?>/friend/chat/<?= $data['username'] ?>/<?= $friend['username'] ?>">Chat</a>
                        <!-- <?php if ($friend['isBlocked'] == 1) : ?>
                                <a href="<?= URL ?>/friend/unblock/<?= $data['username'] ?>/<?= $friend['username'] ?>">Unblock</a> 
                            <?php else : ?>
                                <a href="<?= URL ?>/friend/block/<?= $data['username'] ?>/<?= $friend['username'] ?>">Block</a> 
                            <?php endif; ?> -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>