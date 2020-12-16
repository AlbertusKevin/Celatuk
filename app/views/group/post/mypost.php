<body>
    <div class="container">
        <div class="ppmargin">
            <?php
            // Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu
            // Abstraksi dari class Helper dengan method static
            $arrayId = Helper::isBookmarked($data['username']);
            $likedID = Helper::isLiked($data['username']);
            ?>
            <!-- Menampilkan pesan jika ada error, dari kelas Message dengan method static  -->
            <h4><?= Message::updatePost204(); ?></h4>

            <h1><?= $data['groupname']; ?></h1>
            <h3>My Post: <?= $data['username']; ?></h3>

            <!-- Jika user belum memposting apapun di grup -->
            <?php
            if (empty($data['post'])) : ?>
                <h4>Anda belum memposting apapun di grup ini</h4>
            <?php endif; ?>



            <!-- Untuk menampilkan postingan, jika ada postingan -->
            <?php foreach ($data['post'] as $post) : ?>
                <div class="post">
                    <a href="<?= URL; ?>/group/edit_post/<?= $data['groupname']; ?>/<?= $post['id'] ?>/<?= $post['username']; ?>">Edit</a>
                    <a href="<?= URL; ?>/group/delete_post/<?= $data['groupname']; ?>/<?= $post['id'] ?>/<?= $post['username']; ?>">Delete</a>
                    <!-- Menampilkan user yang post -->
                    <?php if ($post['username'] == $data['username']) : ?>
                        <!-- ketika diklik, jika pemosting adalah orang itu sendiri, maka disambungkan ke halaman profilenya beserta fitur edit -->
                        <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>">
                        <?php else : ?>
                            <!-- jika orang lain, maka hanya menampilkan profile orang tersebut -->
                            <a href="<?= URL; ?>/user/profile/<?= $data['username'] ?>/<?= $post['username'] ?>">
                            <?php endif; ?>
                            <img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/profile/<?= $post['picture'] ?>" class="img-post">
                            <?= $post['username'] ?>
                            </a>
                            <br>

                            <!-- Jika user memposting image -->
                            <?php if ($post['image'] != " ") : ?>
                                <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!" width="200px"><br>
                            <?php endif; ?>

                            <!-- Menampilkan isi teks postingan -->
                            <span><?= $post['content']; ?></span><br>

                            <!-- Menampilkan jumlah like -->
                            <span><span class="like-count"><?= $post['likeCount'] ?></span> like this post</span><br>

                            <!-- tombol like -->
                            <?php if (in_array($post['id'], $likedID)) : ?>
                                <button class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Unlike</button>
                            <?php else : ?>
                                <button class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Like</button>
                            <?php endif; ?>

                            <!-- tombol bookmark -->
                            <?php if (in_array($post['id'], $arrayId)) : ?>
                                <button class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Remove Bookmark</button><br>
                            <?php else : ?>
                                <button class="button-bookmark bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Bookmark</button><br>
                            <?php endif; ?>

                            <!-- kirim comment -->
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
    </div>