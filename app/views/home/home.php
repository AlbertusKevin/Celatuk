<?php
// Cek apakah user sudah login atau belum
if (!isset($_SESSION['login'])) {
    header('Location: ' . URL . '/user/form_login');
    exit;
}

// Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu
// Abstraksi dari class Helper dengan method static
$arrayId = Helper::isBookmarked($data['username']);
$likedID = Helper::isLiked($data['username']);

?>

<body>
    <!-- Menampilkan pesan jika ada error, dari kelas Message dengan method static  -->
    <h4><?= Message::emptyField404(); ?></h4>
    <h4><?= Message::picture406(); ?></h4>
    <h4><?= Message::post204(); ?></h4>

    <!-- navigasi -->
    <header>

        <div class="topNavigationBar">
            <div class="container12Column">

                <div class="column-1 topNavigationBarLogo">
                    <img src="<?= URL ?>/assets/images/logo.svg">
                </div>

                <div class="topNavigationBarFilter column-3">
                    <label for="filter">Cari berdasarkan:</label>
                    <select name="filter" id="TopNavigationBarFilterOptions">
                        <option value="group">Grup</option>
                        <option value="people">Orang</option>
                    </select>
                </div>

                <div class="topNavigationBarSearch column-4">
                    <input type="hidden" value="<?= $data['username'] ?>" id="username">
                    <input class="topNavigationBarSearchInput" type="text" id="cari" name="cari" placeholder="Cari orang, grup, postingan">
                </div>

                <div class="topNavigationBarPostButton column-1">
                    <form action="<?= URL ?>/post/form/<?= $data['username'] ?>" method="post" enctype="multipart/form-data">
                        <button type="submit" id="NavigationBarPostButton">
                            <img class="topNavigationBarPostButtonIcons" id="TopNavigationBarLinkIconAddPost" src="<?= URL ?>/assets/images/mdi_plus.svg">
                        </button>
                    </form>
                </div>

                <div class="topNavigationBarLinks column-3">
                    <!-- Untuk membuat postingan -->
                    <!-- <a href="#"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconHome" src="<?= URL ?>/assets/images/home_icon.svg"></a> -->
                    <a href="<?= URL ?>/messenger/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconChat" src="<?= URL ?>/assets/images/mdi_forum.svg"></a>
                    <a href="<?= URL ?>/friend/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
                    <a href="<?= URL ?>/home/index_user/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
                    <a href="<?= URL ?>/group/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
                    <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
                    <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout" src="<?= URL ?>/assets/images/mdi_power.svg"></a>
                </div>

            </div>
        </div>

    </header>




    <!-- Untuk menampilkan postingan, jika tidak ada postingan -->
    <?php if (empty($data['post'])) : ?>
        <h4>Belum ada Postingan</h4>
    <?php endif; ?>

    <!-- Untuk menampilkan postingan, jika ada postingan -->
    <?php foreach ($data['post'] as $post) : ?>
        <div class="post">
            <div class="container12Column">

                <div class="column-12 ProfilePicturePostContainer">
                    <!-- Menampilkan user yang post -->
                    <?php if ($post['username'] == $data['username']) : ?>
                        <!-- ketika diklik, jika pemosting adalah orang itu sendiri, maka disambungkan ke halaman profilenya beserta fitur edit -->
                        <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>" class="">
                        <?php else : ?>
                            <!-- jika orang lain, maka hanya menampilkan profile orang tersebut -->
                            <a href="<?= URL; ?>/user/profile/<?= $data['username'] ?>/<?= $post['username'] ?>" class="">
                            <?php endif; ?>
                            <div class="container12Column">
                                <div class="ProfilePicturePost">
                                    <img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/profile/<?= $post['picture'] ?>">
                                </div>
                                <div class="UserNamePost column-2">
                                    <?= $post['username'] ?>
                                </div>
                            </div>
                            </a>
                </div>

                <div class="column-10 TextPostContainer">
                    <!-- Menampilkan isi teks postingan -->
                    <span><?= $post['content']; ?></span>
                </div>

                <div class="column-12 PicturePostContainer">
                    <div class="column-10 imagePost">
                        <!-- Jika user memposting image -->
                        <?php if ($post['image'] != " ") : ?>
                            <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="column-12 buttonLikeBookmarkPostContainer">
                    <div class="container12Column " id="buttonPostContainer">
                        <div class="likeButton">
                            <!-- tombol like -->
                            <?php if (in_array($post['id'], $likedID)) : ?>
                                <button id="UndoPostButton" class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
                                    <img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up.svg">
                                    <!-- Unlike -->
                                </button>
                            <?php else : ?>
                                <button id="doPostButton" class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
                                    <img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up-outline.svg">
                                    <!-- Like -->
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="likeCounter column-9">
                            <!-- Menampilkan jumlah like -->
                            <?php if (in_array($post['id'], $likedID)) : ?>
                                <span><span class="like-count"><?= $post['likeCount'] ?></span> orang termasuk Anda menyukai postingan ini</span>
                            <?php else : ?>
                                <span><span class="like-count"><?= $post['likeCount'] ?></span> orang menyukai postingan ini</span>
                            <?php endif; ?>
                        </div>

                        <div class="bookmarkButton">
                            <!-- tombol bookmark -->
                            <?php if (in_array($post['id'], $arrayId)) : ?>
                                <button id="UndoPostButton" class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
                                    <img class="ButtonIcons" id="BookmarkPostButtonIcons" data-url="<?= URL ?>" src="<?= URL ?>/assets/images/mdi_bookmark.svg">
                                    <!-- Remove Bookmark -->
                                </button>
                            <?php else : ?>
                                <button id="doPostButton" class="button-bookmark bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
                                    <img class="ButtonIcons" id="UnbookmarkPostButtonIcons" data-url="<?= URL ?>" src="<?= URL ?>/assets/images/mdi_bookmark-outline.svg">
                                    <!-- Bookmark -->
                                </button>
                            <?php endif; ?>
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
                                    <div class="CommentBoxes">
                                        <div class="comment-<?= $comment['id'] ?>">
                                            <p class="show-comment">
                                                <div id="commentUsername">
                                                    <?= $comment['username']; ?>
                                                </div>
                                                <div id="commentContent">
                                                    <span class="isi-comment">
                                                        <?= $comment['comment']; ?>
                                                    </span>
                                                </div>
                                            </p>
                                        </div>
                                        <?php if ($comment['username'] === $data['username']) : ?>
                                            <!-- <div id="EditDeleteComment"> -->
                                            <span id="editComment" class="edit-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">ubah</span> |
                                            <span id="deleteComment" class="delete-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">hapus</span>
                                            <!-- </div> -->
                                        <?php endif; ?>

                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <h4 id="commentAskingSugestion">Jadilah orang pertama yang berkomentar di postingan ini</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="column-12">
                    <div class="container12Column" id="commentContainer">
                        <!-- kirim comment -->
                        <div class="column-10">
                            <input type="text" width="400" id="comment-<?= $post['id'] ?>" name="comment">
                        </div>
                        <div class="column-2" id="commentButton">
                            <button class="button-comment" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Kirim</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    <?php endforeach; ?>