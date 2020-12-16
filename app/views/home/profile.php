<body onload="darkmode()">
    <div class="container">
        <?php
        // Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu
        // Abstraksi dari class Helper dengan method static
        $arrayId = Helper::isBookmarked($data['profile']['username']);
        $likedID = Helper::isLiked($data['profile']['username']);
        ?>

        <!-- Menampilkan pesan jika ada error, dari kelas Message dengan method static  -->
        <h4><?= Message::deletePost204(); ?></h4>
        <h4><?= Message::updatePost204(); ?></h4>
        <div id='coba'>
            <ul style="list-style-type:none;">
                <li>
                    <img src="<?= URL ?>/assets/img/user/<?= $data['profile']['username'] ?>/background/<?= $data['profile']['bgPicture'] ?>" alt="<?= $data['profile']['username'] ?> Profile Picture" width="1160" height="250">
                </li>
                <li>
                    <img src="<?= URL ?>/assets/img/user/<?= $data['profile']['username'] ?>/profile/<?= $data['profile']['picture'] ?>" alt="<?= $data['profile']['username'] ?> Profile Picture" width="250" height="250" class="pp" style="margin-left: 530px;">
                </li>
                <h1 style="text-align:center;color:#545454;"><?= $data['setting']['username'] ?></h1>
                <li class="coloringblack">Nama: <?= $data['profile']['name']; ?></li>
                <li class="coloringblack">Username: <?= $data['profile']['username']; ?></li>
                <li class="coloringblack">Email: <?= $data['profile']['email']; ?></li>
                <li class="coloringblack">Phone: <?= $data['profile']['phone']; ?></li>
        
                <form action="<?= URL; ?>/home/darkmode/<?= $data['profile']['username']; ?>" method='post'>
                    <li style="margin-top: 50px;">
                        Darkmode: <button type="submit">
                            <?php if ($data['setting']['darkmode'] == 1) : ?>
                                <input type="hidden" value="off" name="value">
                                <span id='darkmode'>off</span>
                            <?php else : ?>
                                <input type="hidden" value="on" name="value">
                                <span id='darkmode'>on</span>
                            <?php endif; ?>
                        </button>
                    </li>
                </form>
            </ul>

            <a href="<?= URL ?>/post/mybookmark/<?= $data['profile']['username'] ?>" class="profilemargin coloring">My Bookmarked</a>

            <?php if (empty($data['post'])) : ?>
                <h4 class="profilemargin" style="color:#545454;">Belum ada Post</h4>
            <?php endif; ?>

            <!-- Untuk menampilkan postingan, jika ada postingan -->
            <?php foreach ($data['post'] as $post) : ?>
                <div class="post">
                    <!-- Menampilkan user yang post -->
                    <div class="container12Column">
                        <div class="ProfilePicturePost">
                            <span><img src="<?= URL; ?>/assets/img/user/<?= $data['profile']['username'] ?>/profile/<?= $data['profile']['picture'] ?>" width="50"></span>
                        </div>
                        <div class="UserNamePost">
                            <span><?= $post['username'] ?></span><br>
                        </div>
                    </div>
                    
                    <br>
                    <div class="column-12 PicturePostContainer">
                            <div class="column-10 imagePost">
                                <!-- Jika user memposting image -->
                                <?php if ($post['image'] != " ") : ?>
                                    <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!" width="200px"><br>
                                <?php endif; ?>
                            </div>
                    </div>
                    <div class="container12Column">
                        <div class="column-10 TextPostContainer">
                            <!-- Menampilkan isi postingan -->
                            <span><?= $post['content']; ?></span><br>
                        </div>
                    </div>
                    
                    <div class="column-12 buttonLikeBookmarkPostContainer">
                        <div class="container12Column "id="buttonPostContainer">
                            <div class="likeButton">
                                <!-- tombol like -->
                                <?php if (in_array($post['id'], $likedID)) : ?>
                                    <button id="UndoPostButton" class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>"><img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up.svg"></button>
                                <?php else : ?>
                                    <button id="doPostButton" class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>"><img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up-outline.svg"></button>
                                <?php endif; ?>
                            </div>
                            <div class="likeCounter column-9">
                                    <!-- Menampilkan jumlah like -->
                                    <span><span class="like-count"><?= $post['likeCount'] ?></span> like this post</span><br>
                            </div>
                            <div class="bookmarkButton">
                                <!-- bookmark -->
                                <?php if (in_array($post['id'], $arrayId)) : ?>
                                    <button id="UndoPostButton" class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>"><img class="ButtonIcons" id="BookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark.svg"></button><br>
                                <?php else : ?>
                                    <button id="doPostButton"  class="button-bookmark bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>"><img class="ButtonIcons" id="UnbookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark-outline.svg"></button><br>
                                <?php endif; ?>
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
                                <button class="button-comment" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>">Kirim</button><br>
                            </div>
                        </div>
                    </div>
                    
                    <div class="column-12">
                        <div id="commentListsContainer">
                            <!-- Tampilkan Comment -->
                            <div class="list-comment">
                                <?php $comments = Helper::getCommentPostId($post['id']);
                                if (!empty($comments)) :
                                    foreach ($comments as $comment) : ?>
                                        <div class="comment-<?= $comment['id'] ?>">
                                            <p class="show-comment"><?= $comment['username']; ?> : <span class="isi-comment"><?= $comment['comment']; ?></span></p>
                                            <?php if ($comment['username'] === $data['profile']['username']) : ?>
                                                <span class="edit-comment" data-username="<?= $data['profile']['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">edit</span> |
                                                <span class="delete-comment" data-username="<?= $data['profile']['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">delete</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <h4>Postingan ini belum memiliki komentar</h4>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                        <a href="<?= URL; ?>/post/edit_form/<?= $post['username']; ?>/<?= $post['id'] ?>" class="coloring">Edit</a>
                        <a href="<?= URL; ?>/post/delete/<?= $post['username']; ?>/<?= $post['id'] ?>" class="coloring">Delete</a>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>
            <a href="<?= URL ?>/user/edit/<?= $data['profile']['username'] ?>" class="coloring profilemargin">Edit</a>
            <a href="<?= URL; ?>/home/index/<?= $data['profile']['username'] ?>" class="coloring ppmargin">kembali</a>
            <a href="<?= URL; ?>/user/delete/<?= $data['profile']['username'] ?>" onclick="confirm('Are you sure want to delete this account?');" class="coloring ppmargin">Delete Account</a>
    </div>