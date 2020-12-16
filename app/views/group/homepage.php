    <!-- Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu -->
    <!-- Abstraksi dari class Helper dengan method static -->
    <?php
    $group = $data['group'];
    $arrayId = Helper::isBookmarked($data['username']);
    $likedID = Helper::isLiked($data['username']);
    ?>

    <body>
        <div class="container">

            <!-- Menampilkan pesan jika ada error, dari kelas Message dengan method static  -->
            <h4><?= Message::updateGroup200(); ?></h4>
            <h4><?= Message::joinPublic204($data['username'], $data['groupname']); ?></h4>
            <h4><?= Message::joinPrivate204($data['groupname']); ?></h4>
            <h4><?= Message::adminLeave403(); ?></h4>

            <!-- Info detail tentang grup -->
            <div class="pp ppmargin">
                <img src="<?= URL ?>/assets/img/group/<?= $group['groupName'] ?>/profile/<?= $group['picture'] ?>" alt="<?= $group['groupName']; ?> Picture" width="100" height="100">
                <h2><?= $group['groupName']; ?></h2>
            </div>
            <p class="ppmargin">Created: <?= $group['dateCreated']; ?> by <?= $group['founder'] ?></p>
            <p class="ppmargin">Grup <?php if ($group['visibility'] == 0) : ?>private<?php else : ?>public<?php endif; ?></p>
            <p class="ppmargin"><?= $group['about']; ?></p>

            <div class="ppmargin">
            <!-- Jika user yang akses bukan member -->
            <?php if (!$data['member']) : ?>
                <a href="<?= URL ?>/group/join/<?= $group['groupName']; ?>/<?= $data['username']; ?>" class="coloring">#join#</a><br>
            <?php else : ?>
                <!-- Jika user sudah di accept request join atau sudah resmi tergabung -->
                <?php if ($data['member']['status'] == 1) : ?>
                    <a href="<?= URL ?>/group/leave/<?= $group['groupName']; ?>/<?= $data['username'] ?>" class="coloring">#leave#</a><br>
                    <a href="<?= URL ?>/group/mypost/<?= $group['groupName'] ?>/<?= $data['username']; ?>" class="coloring">See your post in this group</a>
                    <br>
                <?php else : ?>
                    <!-- Jika user belum di accept untuk bergabung dengan grup -->
                    <a href="<?= URL ?>/group/leave/<?= $group['groupName']; ?>/<?= $data['username'] ?>" class="coloring">#abbort request#</a><br>
                <?php endif; ?>
                <!-- Jika user adalah admin atau moderator di grup tersebut -->
                <?php if ($data['member']['role'] == 'admin' || $data['member']['role'] == 'moderator') : ?>
                    <a href="<?= URL ?>/group/requested_join/<?= $group['groupName'] ?>/<?= $data['username'] ?>" class="coloring">Requested Join</a><br>
                    <a href="<?= URL ?>/group/verifypost/<?= $group['groupName'] ?>/<?= $data['username'] ?>" class="coloring">Verify Post</a><br>
                <?php endif;
                //Jika user adalah admin grup
                if ($data['member']['role'] == 'admin') : ?>
                    <a href="<?= URL ?>/group/edit/<?= $group['groupName']; ?>/<?= $data['username']; ?>" class="coloring">Edit</a><br>
                    <a href="<?= URL ?>/group/delete/<?= $group['groupName'] ?>/<?= $data['username'] ?>" class="coloring">Delete</a><br>
                <?php endif; ?>
            <?php endif; ?>
            <a href="<?= URL ?>/group/member/<?= $group['groupName']; ?>/<?= $data['username']; ?>" class="coloring">Members</a><br>

            <!-- Untuk membuat postingan group -->
            <?php if ($data['member']) : ?>
                <?php if ($data['member']['status'] == 1) : ?>
                    <form action="<?= URL ?>/group/post/<?= $group['groupName']; ?>/<?= $data['username']; ?> " method="post">
                        <button type="submit">Post</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>

            <!-- untuk menampilkan postingan grup -->
            <?php if (empty($data['post'])) : ?>
                <h4 style="color:#545454;">Belum ada Postingan</h4>
            <?php endif; ?>

            <!-- Untuk menampilkan postingan, jika ada postingan -->
            <?php foreach ($data['post'] as $post) : ?>
                <div class="post">
                    <!-- Menampilkan user yang post -->
                    <a href="<?= URL; ?>/user/profile/<?= $data['username'] ?>/<?= $post['username'] ?>">
                        <img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/profile/<?= $post['picture'] ?>" class="img-post">
                        <?= $post['username'] ?>
                    </a>
                    <br>
                    <!-- Jika user memposting image -->
                    <?php if ($post['image'] != " ") : ?>
                        <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!" width="200px"><br>
                    <?php endif; ?>

                    <!-- Menampilkan isi postingan -->
                    <span><?= $post['content']; ?></span><br>

                    <!-- Menampilkan jumlah like -->
                    <span><span class="like-count"><?= $post['likeCount'] ?></span> like this post</span><br>

                    <!-- tombol like -->
                    <?php if (in_array($post['id'], $likedID)) : ?>
                        <button class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Unlike</button>
                    <?php else : ?>
                        <button class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Like</button>
                    <?php endif; ?>

                    <!-- bookmark -->
                    <?php if (in_array($post['id'], $arrayId)) : ?>
                        <button class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Remove Bookmark</button><br>
                    <?php else : ?>
                        <button class="button-bookmark bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Bookmark</button><br>
                    <?php endif; ?>

                    <!-- Comment -->
                    <input type="text" width="400" id="comment-<?= $post['id'] ?>" name="comment">
                    <button class="button-comment" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Send</button><br>

                    <!-- Tampilkan Comment -->
                    <div class="list-comment">
                        <?php $comments = Helper::getCommentPostId($post['id']);
                        if (!empty($comments)) :
                            foreach ($comments as $comment) : ?>
                                <div class="comment-<?= $comment['id'] ?>">
                                    <p class="show-comment"><?= $comment['username']; ?> : <span class="isi-comment"><?= $comment['comment']; ?></span></p>
                                    <?php if ($comment['username'] === $data['username']) : ?>
                                        <span class="edit-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">edit</span> |
                                        <span class="delete-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">delete</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <h4>Postingan ini belum memiliki komentar</h4>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>

            <a href="<?= URL ?>/group/index/<?= $data['username'] ?>" class="coloring">kembali</a>
        </div>
    </div>