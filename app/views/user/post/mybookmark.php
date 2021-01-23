<body>
    <?php
    // Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu
    // Abstraksi dari class Helper dengan method static
    $likedID = Helper::isLiked($data['username']);
    ?>
    <!-- Menampilkan pesan jika ada error, dari kelas Message dengan method static  -->
  <h4><?= Message::deletePost204(); ?></h4>
  <h4><?= Message::updatePost204(); ?></h4>
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
        <a href="<?= URL ?>/home/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconHome" src="<?= URL ?>/assets/images/home_icon.svg"></a>
        <a href="<?= URL ?>/messenger/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconChat" src="<?= URL ?>/assets/images/mdi_forum.svg"></a>
        <a href="<?= URL ?>/friend/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
        <a href="<?= URL ?>/home/index_user/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
        <a href="<?= URL ?>/group/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
        <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>

  <div class="container gridLayout">
    <div class="leftSidebar">
      <h4>My bookmark</h4>
    </div>
    <div class="postContainer">
      <?php if (empty($data['post'])) : ?>
            <h4>Anda belum menyimpan postingan apapun</h4>
      <?php endif; ?>
      <?php foreach ($data['post'] as $post) : ?>
        <div class="post <?= $post['id'] ?>">
          <div class="ProfilePicturePostContainer">
            <a href="<?= URL; ?>/user/profile/<?= $data['username'] ?>/<?= $post['username'] ?>">
              <div class="ProfilePicturePost">
                <span><img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/profile/<?= $post['picture'] ?>" width="50"></span>
              </div>
              <div class="UserNamePost">
                <span><?= $post['username'] ?></span>
              </div>   
            </a>
          </div>

          <div class="TextPostContainer">
            <!-- Menampilkan isi postingan --> 
            <span><?= $post['content']; ?>
          </div>

          <?php if ($post['image'] != " ") : ?>
          <div class="PicturePostContainer">
            <div class="imagePost">
              <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!" width="200px">
            </div>
          </div>
          <?php endif; ?>
          
          <div class="buttonLikeBookmarkPostContainer" id="buttonPostContainer">
            <div class="likeButton">
              <!-- tombol like -->
              <?php if (in_array($post['id'], $likedID)) : ?>
                <button class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
                  <img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up.svg">
                </button>
              <?php else : ?>
                <button class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
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

            <!-- bookmark -->
            <div class="bookmarkButton">
              <button class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">
                <img class="ButtonIcons" id="BookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark.svg">
              </button>
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
                  <span class="edit-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">edit</span> |
                  <span class="delete-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">delete</span>
                </div>
                <?php endif; ?>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="commentContainer" id="commentContainer">
          <!-- Comment -->
            <input type="text" width="400" id="comment-<?= $post['id'] ?>" name="comment" placeholder="Tulis Komentar">
          <?php else : ?>
            </div>
          </div>
          <div class="commentContainer" id="commentContainer">
            <!-- Comment -->
            <input type="text" width="400" id="comment-<?= $post['id'] ?>" name="comment" placeholder="Jadilah orang pertama yang berkomentar">
          <?php endif; ?>
            <div id="commentButton">
              <button class="button-comment" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>">Kirim</button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>    
    </div>