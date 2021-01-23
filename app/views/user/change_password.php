<?php $user = $data['user']; ?>
<body>
<h4><?= Message::oldpassword406(); ?></h4>
<h4><?= Message::confPassword406(); ?></h4>
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
          <a href="<?= URL ?>/home/index/<?=$data['user']['username']?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconHome" src="<?= URL ?>/assets/images/home_icon.svg"></a>
          <a href="<?= URL ?>/messenger/index/<?=$data['user']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconChat" src="<?= URL ?>/assets/images/mdi_forum.svg"></a>
          <a href="<?= URL ?>/friend/index/<?=$data['user']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
          <a href="<?= URL ?>/home/index_user/<?=$data['user']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
          <a href="<?= URL ?>/group/index/<?=$data['user']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
          <a href="<?= URL ?>/home/profile/<?=$data['user']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
          <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>
  <section class="editPassword">
    <h2>Change Password</h2>
    <div class="container gridContainer">
      <form action = "<?=URL?>/user/update_password/<?=$user['username']?>" method = "post">
        <h5>Old Password</h5>
        <input type="password" id = "password" name = "oldpwd">
        <h5>New Password</h5>
        <input type="password" id = "newpassword" name = "newpwd">
        <h5>Confirm Password</h5>
        <input type="password" id = "confpassword" name = "confpwd">
        <button type = "submit">Save</button>
      </form>
    </div>
  </section>