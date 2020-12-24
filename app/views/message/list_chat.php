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
          <a href="<?= URL ?>/friend/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
          <a href="<?= URL ?>/home/index_user/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
          <a href="<?= URL ?>/group/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
          <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
          <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>

  <div class="container">
    <h2 class="coloringblack ppmargin">Contact Chat</h2>
    
    <?php $friend = [];
    $i = 0;
    if (empty($data['chat_list'])) : ?>
    <div>Still Empty!</div>
    <?php else :
    foreach ($data['chat_list'] as $contact) :
      if ($contact['toUser'] == $data['username']) :
        if (!in_array($contact['fromUser'], $friend)) :
          $friend[] = $contact['fromUser']; ?>
          <div class="listContainer">
            <div>
              <a class = "listGrid" href="<?= URL ?>/friend/chat/<?= $data['username'] ?>/<?= $contact['fromUser'] ?>">
                <div class="pictureContainer">
                  <img src="<?= URL ?>/assets/img/user/<?= $contact['fromUser'] ?>/profile/<?= $data['picture'][$i]['picture'] ?>" width="100">
                </div>
                <div class = "ppmargin nameContainer">
                  <p><?= $contact['fromUser']; ?></p> 
                </div>
              </a>
            </div>
            <div class="operationButtonContainer">
              <a href="<?= URL ?>/messenger/delete/<?= $data['username'] ?>/<?= $contact['fromUser'] ?>">
                Delete
              </a>
            </div>
          </div>
        <?php $i++;
        endif;
      else :
        if (!in_array($contact['toUser'], $friend)) :
          $friend[] = $contact['toUser']; ?>
          <div class="listContainer mainLeftGrid">
            <div>
              <a class = "listGrid" href="<?= URL ?>/friend/chat/<?= $data['username'] ?>/<?= $contact['toUser'] ?>" class="coloring">
                <div class="pictureContainer">
                  <img src="<?= URL ?>/assets/img/user/<?= $contact['toUser'] ?>/profile/<?= $data['picture'][$i]['picture'] ?>" width="100">
                </div>
                <div class = "ppmargin nameContainer">
                <p><?= $contact['toUser']; ?></p>
                </div>
              </a>
            </div>
            <div class="operationButtonContainer listChatButtonContainer">
              <div></div>
              <a href="<?= URL ?>/messenger/delete/<?= $data['username'] ?>/<?= $contact['fromUser'] ?>">
                Delete
              </a>
            </div>
          </div>
    <?php $i++;
    endif; ?>
    <?php endif;
    endforeach; ?>
    <?php endif; ?>
  </div>