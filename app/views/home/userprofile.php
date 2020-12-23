<body>
  <!-- navigasi -->
  <!-- Menampilkan pesan jika ada error, dari kelas Message dengan method static  -->
  <h4><?= Message::emptyField404(); ?></h4>
  <h4><?= Message::picture406(); ?></h4>
  <h4><?= Message::post204(); ?></h4>
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
          <a href="<?= URL ?>/home/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconHome" src="<?= URL ?>/assets/images/home_icon.svg"></a>
          <a href="<?= URL ?>/messenger/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconChat" src="<?= URL ?>/assets/images/mdi_forum.svg"></a>
          <a href="<?= URL ?>/friend/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
          <a href="<?= URL ?>/home/index_user/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
          <a href="<?= URL ?>/group/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
          <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
          <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>
  <?php
    $user = $data['user'];
    // Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu
    // Abstraksi dari class Helper dengan method static
    $arrayId = Helper::isBookmarked($data['username']);
    $likedID = Helper::isLiked($data['username']);
  ?>
  <section class="profile">
    <div class="backgroundProfileImage">
      <img src="<?= URL ?>/assets/img/user/<?= $user['username'] ?>/background/<?= $user['bgPicture'] ?>" alt="<?= $user['username'] ?> Profile Picture" width="1160" height="250">
      <div class="profileImage">
        <div class="imageContainer">
          <img src="<?= URL ?>/assets/img/user/<?= $user['username'] ?>/profile/<?= $user['picture'] ?>" alt="<?= $user['username'] ?> Profile Picture" width="250" hieght="250" class="pp">
        </div>
      </div>
    </div>
    <div class="container">
      <div class="userInformation">
        <div>
          <h4>Username:</h4>
          <h1><?= $user['username']; ?></h1>
        </div>
        <div class="userDetails">
          <p>Name: <?= $user['name'];?></p>
          <p>Email:<?= $user['email'];?></p>
          <p>Phone:<?= $user['phone'];?></p>
        </div>
      </div>
      <div class="userContainer">
        <div class="userSettings-disabled">
        </div>
        <div class="postContainer">
          <?php if (empty($data['post'])) : ?>
          <h4>Belum ada Postingan</h4>
          <?php endif; ?>
          <!-- Untuk menampilkan postingan, jika ada postingan -->
          <?php foreach ($data['post'] as $post) : ?>
          <div class="post">
            <div class="ProfilePicturePostContainer">
              <a href="<?= URL; ?>/user/profile/<?= $data['username'] ?>/<?= $post['username'] ?>">
                <div class="ProfilePicturePost">
                  <img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/profile/<?= $user['picture'] ?>" class="img-post">
                </div>
                <div class="UserNamePost">
                  <?= $post['username'] ?>
                </div>
              </a>
            </div>

            <div class="TextPostContainer">
              <!-- Menampilkan isi postingan -->
              <span><?= $post['content']; ?></span>
            </div>

            <!-- Jika user memposting image -->
            <?php if ($post['image'] != " ") : ?>
            <div class="PicturePostContainer">
              <div class="imagePost">
                <img src="<?= URL; ?>/assets/img/user/<?= $post['username']; ?>/post/<?= $post['image'] ?>" alt="Can't load image!" width="200px">
              </div>
            </div>
            <?php endif;?>

            <div class="buttonLikeBookmarkPostContainer" id="buttonPostContainer">
              <div class="likeButton">
              <?php if (in_array($post['id'], $likedID)) : ?>
                <button id="UndoPostButton" class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>"><img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up.svg"></button>
                <?php else : ?>
                <button id="doPostButton" class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>"><img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up-outline.svg">
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
                <!-- bookmark -->
                <?php if (in_array($post['id'], $arrayId)) : ?>
                  <button id="UndoPostButton" class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>"><img class="ButtonIcons" id="BookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark.svg"></button>
                  <?php else : ?>
                  <button class="button-bookmark bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['username']; ?>"><img class="ButtonIcons" id="UnbookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark-outline.svg">
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
                        <?= $comment['username'];?> 
                      </div>
                      <div id="commentContent">
                        <span class="isi-comment"><?= $comment['comment']; ?></span>
                      </div>
                    </div>
                    <?php if ($comment['username'] === $data['username']) : ?>
                    <div class="commentEdit">                           
                      <span class="edit-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">edit</span> |
                      <span class="delete-comment" data-username="<?= $data['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">delete</span>
                    </div>
                    <?php endif;?>
                  </div>
                <?php endforeach;?>
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
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
        

        