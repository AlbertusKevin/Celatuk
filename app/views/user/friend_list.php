<?php
$friendsL = $data['friend'];
$friendsR = $data['friendUsername'];
?>

<body>
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
          <a href="<?= URL ?>/home/index/<?= $data['username']?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconHome" src="<?= URL ?>/assets/images/home_icon.svg"></a>
          <a href="<?= URL ?>/messenger/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconChat" src="<?= URL ?>/assets/images/mdi_forum.svg"></a>
          <a href="<?= URL ?>/home/index_user/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
          <a href="<?= URL ?>/group/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
          <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
          <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>
    
  <div class="container">
    <div class="mainLeftGrid">
      <h2 class="coloringblack">Friend List</h2>
      <a href="<?= URL; ?>/friend/requested_friend/<?= $data['username']; ?>" class="coloring createList">Friend Request</a>
    </div>
    <?php if (empty($friendsL) && empty($friendsR)) : ?>
      <div>Still Empty!</div>
    <?php endif; ?>
    <?php foreach ($friendsL as $friend) : ?>
      <div class="listContainer mainLeftGrid">
        <div>
          <a href="<?= URL ?>/user/profile/<?= $data['username']; ?>/<?= $friend['friendUserName']; ?>" class="ppmargin coloring listGrid">
            <div class="pictureContainer">
              <img src="<?= URL; ?>/assets/img/user/<?= $friend['username']; ?>/profile/<?= $friend['picture']; ?>" alt="<?= $friend['username']; ?> profile picture">
            </div>
            <div class="nameContainer">
              <p><?= $friend['name']; ?></p>
              <p class="username"><?= $friend['username']; ?></p>
            </div>
          </a>       
        </div>
        <div class="operationButtonContainer">
          <a href="<?= URL ?>/friend/chat/<?= $data['username'] ?>/<?= $friend['friendUserName'] ?>" class="coloring">Chat</a>
          <!-- <?php if ($friend['isBlocked'] == 1) : ?>
            <a href="<?= URL ?>/friend/unblock/<?= $data['username'] ?>/<?= $friend['friendUserName'] ?>">Unblock</a> 
          <?php else : ?>
            <a href="<?= URL ?>/friend/block/<?= $data['username'] ?>/<?= $friend['friendUserName'] ?>">Block</a> 
          <?php endif; ?> -->
          <a href="<?= URL ?>/friend/delete/<?= $data['username'] ?>/<?= $friend['friendUserName'] ?>" class="coloring">Delete</a>
        </div>
      </div>
            <?php endforeach; ?>

            <?php foreach ($friendsR as $friend) : ?>
              <div class="listContainer mainLeftGrid">
                <div>
                  <a href="<?= URL ?>/user/profile/<?= $data['username']; ?>/<?= $friend['username']; ?> " class="ppmargin coloring listGrid">
                    <div class="pictureContainer">
                      <img src="<?= URL; ?>/assets/img/user/<?= $friend['username']; ?>/profile/<?= $friend['picture']; ?>" alt="<?= $friend['username']; ?> profile picture" width="150">
                    </div>
                    <div class = "nameContainer">
                      <p><?= $friend['name']; ?></p>
                      <p class="username"><?= $friend['username']; ?></p>
                    </div>
                  </a>
                </div>
                <div class="operationButtonContainer">
                  <a href="<?= URL ?>/friend/chat/<?= $data['username'] ?>/<?= $friend['username'] ?>">Chat</a>
                      <!-- <?php if ($friend['isBlocked'] == 1) : ?>
                      <a href="<?= URL ?>/friend/unblock/<?= $data['username'] ?>/<?= $friend['username'] ?>">Unblock</a> 
                      <?php else : ?>
                      <a href="<?= URL ?>/friend/block/<?= $data['username'] ?>/<?= $friend['username'] ?>">Block</a> 
                      <?php endif; ?> -->
                  <a href="<?= URL ?>/friend/delete/<?= $data['username'] ?>/<?= $friend['username'] ?>">Delete</a>
                </div>
            </div>
            <?php endforeach; ?>
    </div>