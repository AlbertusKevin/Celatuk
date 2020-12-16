<body>
    <div class="container">
        <?php
        $user = $data['user'];
        // Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu
        // Abstraksi dari class Helper dengan method static
        $arrayId = Helper::isBookmarked($data['username']);
        $likedID = Helper::isLiked($data['username']);
        ?>
        <ul class="list-profile">
            <li>
                <img src="<?= URL ?>/assets/img/user/<?= $user['username'] ?>/background/<?= $user['bgPicture'] ?>" alt="<?= $user['username'] ?> Profile Picture" width="1160" height="250">
            </li>
            <li>
                <img src="<?= URL ?>/assets/img/user/<?= $user['username'] ?>/profile/<?= $user['picture'] ?>" alt="<?= $user['username'] ?> Profile Picture" width="250" hieght="250" class="pp" style="margin-left: 530px;">
                <h1 style="text-align:center;" class="coloringblack"><?= $user['username'] ?></h1>
            </li>
            <li class="coloringblack">Nama: <?= $user['name']; ?></li>
            <li class="coloringblack">Username: <?= $user['username']; ?></li>
            <li class="coloringblack">Email: <?= $user['email']; ?></li>
            <li class="coloringblack">Phone: <?= $user['phone']; ?></li>
        </ul>

        <h1 class="coloringblack" style="margin-left: 40px;">My Post</h1>

        <?php if (empty($data['post'])) : ?>
            <h4>Belum ada post</h4>
        <?php endif; ?>

        <!-- Untuk menampilkan postingan, jika ada postingan -->
        <?php foreach ($data['post'] as $post) : ?>
            <div class="post">
                <div class="container12Column">
                    <div class="column-12 ProfilePicturePostContainer">
                        <!-- Menampilkan user yang post -->
                        <a href="<?= URL; ?>/user/profile/<?= $data['username'] ?>/<?= $post['username'] ?>">
                            <div class="container12Column">
                                <div class="ProfilePicturePost">
                                    <img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/profile/<?= $user['picture'] ?>" class="img-post">
                                </div>
                                <div class="UserNamePost column-1">
                                    <?= $post['username'] ?>
                                </div>
                            </div>
                        </a>

                        <br>
                        <div class="column-12 PicturePostContainer">
                            <div class="column-10 imagePost">
                                <!-- Jika user memposting image -->
                                <?php if ($post['image'] != " ") : ?>
                                    <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!" width="200px"><br>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="column-10 TextPostContainer">
                            <!-- Menampilkan isi postingan -->
                            <span><?= $post['content']; ?></span><br>
                        </div>

                        <div class="column-12 buttonLikeBookmarkPostContainer">
                            <div class="container12Column " id="buttonPostContainer">
                                <div class="likeButton">
                                    <!-- tombol like -->
                                    <?php if (in_array($post['id'], $likedID)) : ?>
                                        <button id="UndoPostButton" class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>"><img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up.svg"></button>
                                    <?php else : ?>
                                        <button id="doPostButton" class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>"><img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up-outline.svg"></button>
                                    <?php endif; ?>
                                </div>

                                <div class="likeCounter column-9">
                                    <!-- Menampilkan jumlah like -->
                                    <span><span class="like-count"><?= $post['likeCount'] ?></span> like this post</span><br>
                                </div>

                                <div class="bookmarkButton">
                                    <!-- bookmark -->
                                    <?php if (in_array($post['id'], $arrayId)) : ?>
                                        <button id="UndoPostButton" class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>"><img class="ButtonIcons" id="BookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark.svg"></button><br>
                                    <?php else : ?>
                                        <button class="button-bookmark bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>"><img class="ButtonIcons" id="UnbookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark-outline.svg"></button><br>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="column-12">
                        <div class="container12Column" id="commentContainer">
                            <!-- Comment -->
                            <div class="column-10">
                                <input type="text" width="400" id="comment-<?= $post['id'] ?>" name="comment">
                            </div>
                            <div class="column-2" id="commentButton">
                                <button class="button-comment" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Kirim</button><br>
                            </div>
                        </div>
                    </div>

                    <div class="column-12">
                        <div id="commentListsContainer">
                            <!-- Tampilkan Comment -->
                            <class="list-comment">
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
                                    <h4 class="coloringblack">Postingan ini belum memiliki komentar</h4>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<?php endforeach; ?>