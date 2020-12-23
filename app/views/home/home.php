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
    <section class="container">
      <div class="logo">
        <img src="<?= URL ?>/assets/images/logo.svg">
      </div>
      <div class="search">
        <input type="hidden" value="<?= $data['username'] ?>" id="username">
        <input class="topNavigationBarSearchInput" type="text" id="cari" name="cari" placeholder="Cari orang, grup, postingan">
        <select name="filter" id="TopNavigationBarFilterOptions">
          <option value="group">Grup</option>
          <option value="people">Orang</option>
        </select>
      </div>
      <div class="links">
          <!-- Untuk membuat postingan -->
          <!-- <a href="#"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconHome" src="<?= URL ?>assets/images/home_icon.svg"></a> -->
          <a href="<?= URL ?>/messenger/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconChat" src="<?= URL ?>/assets/images/mdi_forum.svg"></a>
          <a href="<?= URL ?>/friend/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
          <a href="<?= URL ?>/home/index_user/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
          <a href="<?= URL ?>/group/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
          <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
          <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>

  <section class="home">
    <!-- Untuk menampilkan postingan, jika tidak ada postingan -->
    <?php if (empty($data['post'])) : ?>
        <h4>Belum ada Postingan</h4>
    <?php endif; ?>
    
    <div class="container contentLayout">
      <div class="groupList">
      
      </div>
    
      <div class="postContainer">
        <div class="createPost">
          <form action="<?=URL?>/post/create/<?=$data['username']?>" method = "post" enctype = "multipart/form-data">
            <textarea name="text" cols="100" rows="7" placeholder="What do you want to post?"></textarea>
            <div class="action">
              <select name="privacy">
                  <option value="private">Private</option>
                  <option value="public">Public</option>
                  <option value="friend">Friend</option>
              </select>
              <input type="file" name = "img">
              <button type = "submit">Post</button>
            </div>
          </form>
        </div>
      
    <!-- Untuk menampilkan postingan, jika ada postingan -->
    <?php foreach ($data['post'] as $post) : ?>
      <div class="post">
        <div class="ProfilePicturePostContainer">
        <!-- Menampilkan user yang post -->
          <?php if ($post['username'] == $data['username']) : ?>
          <!-- ketika diklik, jika pemosting adalah orang itu sendiri, maka disambungkan ke halaman profilenya beserta fitur edit -->
          <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>">
          <?php else : ?>
          <!-- jika orang lain, maka hanya menampilkan profile orang tersebut -->
          <a href="<?= URL; ?>/user/profile/<?= $data['username'] ?>/<?= $post['username'] ?>">
          <?php endif; ?>
            <div class="ProfilePicturePost">
              <img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/profile/<?= $post['picture'] ?>">
            </div>
            <div class="UserNamePost"><?= $post['username'] ?></div>
            </a>
        </div>

        <div class="TextPostContainer">
          <!-- Menampilkan isi teks postingan -->
          <span><?= $post['content']; ?></span>
        </div>

        <?php if ($post['image'] != " ") : ?>
        <div class="PicturePostContainer">
          <div class="imagePost">
            <!-- Jika user memposting image -->
            <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!">
          </div>
        </div>
        <?php endif; ?>

        <div class="buttonLikeBookmarkPostContainer">
          <div class="likeButton">
            <!-- tombol like -->
            <?php if (in_array($post['id'], $likedID)) : ?><!-- Like -->
            <button id="UndoPostButton" class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
              <img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up.svg">
            </button>
            <!-- Unlike -->
            <?php else : ?>
            <button id="doPostButton" class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
              <img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up-outline.svg">
            </button>
            <?php endif; ?>
          </div>

          <div class="likeCounter">
            <!-- Menampilkan jumlah like -->
            <?php if (in_array($post['id'], $likedID)) : ?>
            <span><span class="like-count"><?= $post['likeCount'] ?></span> orang termasuk Anda menyukai postingan ini</span>
            <?php else : ?>
            <span><span class="like-count"><?= $post['likeCount'] ?></span> orang menyukai postingan ini</span>
            <?php endif; ?>
          </div>

          <div class="bookmarkButton">
            <!-- tombol bookmark -->
            <?php if (in_array($post['id'], $arrayId)) : ?> <!-- Bookmark -->
            <button id="UndoPostButton" class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
            <img class="ButtonIcons" id="BookmarkPostButtonIcons" data-url="<?= URL ?>" src="<?= URL ?>/assets/images/mdi_bookmark.svg">                    
            </button>
            <!-- Remove Bookmark -->
            <?php else : ?>
            <button id="doPostButton" class="button-bookmark bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
            <img class="ButtonIcons" id="UnbookmarkPostButtonIcons" data-url="<?= URL ?>" src="<?= URL ?>/assets/images/mdi_bookmark-outline.svg">
            </button>
            <?php endif; ?>
          </div>
        </div>

        
        <div id="commentListsContainer">
          <!-- Tampilkan Comment -->
          <div class="list-comment">
            <?php $comments = Helper::getCommentPostId($post['id']);
            if (!empty($comments)) :
              foreach ($comments as $comment) : ?>
            <div class="CommentBoxes">
              <div class="comment-<?= $comment['id'] ?>">
                <div id="commentUsername">
                  <?= $comment['username']; ?>
                </div>
                <div id="commentContent">
                  <span class="isi-comment"><?= $comment['comment']; ?></span>
                </div>
              </div>
              <?php if ($comment['username'] === $data['username']) : ?>
              <div class="commentEdit"><!-- <div id="EditDeleteComment"> -->
                <span id="editComment" class="edit-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">ubah</span> |
                <span id="deleteComment" class="delete-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">hapus</span>
              </div><!-- </div> -->
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="commentContainer" id="commentContainer">
          <!-- kirim comment -->
          <input type="text" width="400" id="comment-<?= $post['id'] ?>" name="comment" placeholder="Tulis Komentar">
        <?php else : ?>
          </div>
        </div>

        <div class="commentContainer" id="commentContainer">
          <!-- kirim comment -->
          <div>
            <input type="text" width="400" id="comment-<?= $post['id'] ?>" name="comment" placeholder="Jadilah orang pertama yang berkomentar">
          </div>
          <?php endif; ?>
          <div id="commentButton">
            <button class="button-comment" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Kirim</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
      </div>
    </div>
  </section>