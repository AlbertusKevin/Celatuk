<body>
  <h4><?= Message::createGroup200(); ?></h4>
    <?php if(isset($_SESSION['groupname'])):?>
  <h4><?= Message::deleteGroup204($_SESSION['groupname']) ?></h4>
  <h4><?= Message::memberLeave204($_SESSION['groupname'],$data['username']); ?></h4>
    <?php endif; ?>
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
          <!-- <a href="<?= URL ?>/group/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a> -->
          <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
          <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>

<div class="container">
    <h2 class="coloringblack ppmargin">Group List</h2>
    <?php if(count($data['group']) == 0): ?>
      <h4>Belum ada grup yang dibuat pada aplikasi ini</h4>
    <?php endif; ?>
    <?php foreach($data['group'] as $group): ?>
    <div class="listContainer">
      <a class = "listGrid" href="<?=URL?>/group/homepage/<?=$group['groupName'].'/'.$data['username'];?>">
        <div class="pictureContainer">
        <img src="<?=URL?>/assets/img/group/<?=$group['groupName']?>/profile/<?=$group['picture']?>" alt="<?=$group['groupName']?> Picture" class="pp ppmargin">
        </div>
        <div class="ppmargin">
          <p><?= $group['groupName'];?></p>
        </div>
      </a>
    </div>
    <?php endforeach; ?>
    <a href="<?=URL?>/group/create/<?=$data['username']?>" class="ppmargin coloring">
      <div class="createList">
        <h6>Buat Group</h6>
      </div>
    </a>
</div>