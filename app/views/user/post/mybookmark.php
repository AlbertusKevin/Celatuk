<body>
    <div class="container">
        <?php
        // Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu
        // Abstraksi dari class Helper dengan method static
        $likedID = Helper::isLiked($data['username']);
        ?>

        <h1>Ini Buat Nampilin Bookmark</h1>
        <?php if (empty($data['post'])) : ?>
            <h4>Anda belum menyimpan postingan apapun</h4>
        <?php endif; ?>
        <?php foreach ($data['post'] as $post) : ?>
            <div class="post <?= $post['id'] ?>">
                <a href="<?= URL; ?>/user/profile/<?= $data['username'] ?>/<?= $post['username'] ?>">
                    <span><img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/profile/<?= $post['picture'] ?>" width="50"></span>
                    <span><?= $post['username'] ?></span><br>
                </a>
                <?php if ($post['image'] != " ") : ?>
                    <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!" width="200px">
                <?php endif; ?>
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
                <button class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Remove Bookmark</button><br>

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
    </div>