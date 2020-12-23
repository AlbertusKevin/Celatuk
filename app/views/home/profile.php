<body onload="darkmode()">
  <?php
  // Data untuk mengetahui postingan mana saja yang sudah pernah di like atau di bookmark oleh user tertentu
  // Abstraksi dari class Helper dengan method static
  $arrayId = Helper::isBookmarked($data['profile']['username']);
  $likedID = Helper::isLiked($data['profile']['username']);
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
        <a href="<?= URL ?>/home/index/<?= $data['setting']['username'] ?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconHome" src="<?= URL ?>/assets/images/home_icon.svg"></a>
        <a href="<?= URL ?>/messenger/index/<?= $data['setting']['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconChat" src="<?= URL ?>/assets/images/mdi_forum.svg"></a>
        <a href="<?= URL ?>/friend/index/<?= $data['setting']['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
        <a href="<?= URL ?>/home/index_user/<?= $data['setting']['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
        <a href="<?= URL ?>/group/index/<?= $data['setting']['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
        <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>
  <section class="profile">
    <div class="backgroundProfileImage">
      <img src="<?= URL ?>/assets/img/user/<?= $data['profile']['username'] ?>/background/<?= $data['profile']['bgPicture'] ?>" alt="<?= $data['profile']['username'] ?> Profile Picture" width="1160" height="250">
      <div class="profileImage">
        <div class="imageContainer">
          <img src="<?= URL ?>/assets/img/user/<?= $data['profile']['username'] ?>/profile/<?= $data['profile']['picture'] ?>" alt="<?= $data['profile']['username'] ?> Profile Picture" width="250" height="250" class="pp">
        </div>
      </div>
    </div>
    <div class="container">
      <div class="userInformation">
        <div>
          <h4>Username:</h4>
          <h1><?= $data['setting']['username'] ?></h1>
        </div>
        <div class="userDetails">
          <p>Name: <?= $data['profile']['name']; ?></p>
          <p>Email: <?= $data['profile']['email']; ?></p>
          <p>Phone: <?= $data['profile']['phone']; ?></p>
        </div>
      </div>
      <div class="userContainer"id='coba'>
        <div class="userSettings">
          <form action="<?= URL; ?>/home/darkmode/<?= $data['profile']['username']; ?>" method='post'>
            Darkmode: <button type="submit">
            <?php if ($data['setting']['darkmode'] == 1) : ?>
              <input type="hidden" value="off" name="value">
              <span id='darkmode'>off</span>
            <?php else : ?>
              <input type="hidden" value="on" name="value">
              <span id='darkmode'>on</span>
            <?php endif; ?>
            </button>
          </form>
          <div>
            <a href="<?= URL ?>/post/mybookmark/<?= $data['profile']['username'] ?>" class="profilemargin coloring">My Bookmarked</a>
          </div>
          <div>
          <a href="<?= URL ?>/user/edit/<?= $data['profile']['username'] ?>" class="coloring profilemargin">Edit</a>
          </div>
          <div>
          <a href="<?= URL; ?>/user/delete/<?= $data['profile']['username'] ?>" onclick="confirm('Are you sure want to delete this account?');" class="coloring ppmargin">Delete Account</a>
          </div>
        </div>
        <div class="postContainer">
          <?php if (empty($data['post'])) : ?>
            <h4>Belum ada Postingan</h4>
          <?php endif; ?>
          <!-- Untuk menampilkan postingan, jika ada postingan -->
          <?php foreach ($data['post'] as $post) : ?>
          <div class="post">
            <!-- Menampilkan user yang post -->
            <div class="ProfilePicturePostContainer">
              <a href="<?= URL ?>/home/profile/<?= $data['profile']['username'] ?>">
                <div class="ProfilePicturePost">
                  <span><img src="<?= URL; ?>/assets/img/user/<?= $data['profile']['username'] ?>/profile/<?= $data['profile']['picture'] ?>" width="50"></span>
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
                <!-- tombol like -->
                <?php if (in_array($post['id'], $likedID)) : ?>
                <button id="UndoPostButton" class="button-like unlike" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>">
                  <img class="ButtonIcons" id="LikePostButtonIcons" src="<?= URL ?>/assets/images/mdi_thumb-up.svg">
                </button>
                <?php else : ?>
                <button id="doPostButton" class="button-like like" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>">
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
                <!-- bookmark -->
                <?php if (in_array($post['id'], $arrayId)) : ?>
                <button id="UndoPostButton" class="button-bookmark delete-bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>">
                  <img class="ButtonIcons" id="BookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark.svg">
                </button>
                <?php else : ?>
                <button id="doPostButton"  class="button-bookmark bookmark" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>">
                  <img class="ButtonIcons" id="UnbookmarkPostButtonIcons" src="<?= URL ?>/assets/images/mdi_bookmark-outline.svg">
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
                  <?php if ($comment['username'] === $data['profile']['username']) : ?>
                  <div class="commentEdit"><!-- <div id="EditDeleteComment"> -->
                    <span class="edit-comment" data-username="<?= $data['profile']['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">edit</span> |
                    <span class="delete-comment" data-username="<?= $data['profile']['username']; ?>" data-id="<?= $comment['id'] ?>" data-idPost="<?= $post['id'] ?>">delete</span>
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
                <button class="button-comment" data-id="<?= $post['id']; ?>" data-username="<?= $data['profile']['username']; ?>">Kirim</button>
              </div>
            </div>
            <div class="editPost">
              <a href="<?= URL; ?>/post/edit_form/<?= $post['username']; ?>/<?= $post['id'] ?>" class="coloring">Edit</a>
              <a href="<?= URL; ?>/post/delete/<?= $post['username']; ?>/<?= $post['id'] ?>" class="coloring">Delete</a>
            </div>
          </div>                   
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>