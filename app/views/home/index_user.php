<?php  $friend = $data['friendlist']; ?>
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
        <a href="<?= URL ?>/friend/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
        <a href="<?= URL ?>/group/index/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
        <a href="<?= URL ?>/home/profile/<?= $data['username'] ?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
        <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>

  <div class="container">
    <div class="mainLeftGrid">
      <h2 class="coloringblack ppmargin marginTB1">User List</h2>
    </div>
    <!-- Jika belum ada user yang terdaftar -->
    <?php if(empty($data['user'])): ?>
      <div>Belum ada user yang terdaftar</div>
    <?php else:

    //Jika sudah ada user, akan ditampilkan dengan beberapa pengkondisian
    foreach($data['user'] as $user):
    $i = 0;
    $found = false;
    // var_dump($user['username'] == $friend[$i]['username'] || $user['username'] == $friend[$i]['friendUserName']);die;s
    while(!$found && $i < count($friend)):
    //untuk kasus user tersebut sudah mengirim request // sudah request, tapi belum ada response
      if($user['username'] == $friend[$i]['username'] || $user['username'] == $friend[$i]['friendUserName']): ?>
        <div class="listContainer mainLeftGrid">
          <div>
            <a href = "<?=URL?>/user/profile/<?=$data['username'];?>/<?= $user['username']; ?>" class="ppmargin coloring listGrid">
              <div class="pictureContainer">
                <img src="<?=URL;?>/assets/img/user/<?=$user['username'];?>/profile/<?=$user['picture'];?>" alt="<?=$user['username'];?> profile picture" class="pp ppmargin">
              </div>
              <div class="nameContainer">
                <p><?= $user['name']; ?></p>
                <p class="username"><?=$user['username'];?></p>
              </div>
            </a>
          </div>
          <div class="operationButtonContainer">
            <?php if($friend[$i]['status'] == 0): ?>
              <?php if($user['username'] == $friend[$i]['friendUserName']): ?>
                <a href="<?=URL?>/friend/abort/<?=$data['username']?>/<?=$user['username']?>"><div class="ppmargin coloring">Abort</div></a>
                <?php else: ?>
                <a href="<?=URL?>/friend/accept/<?=$data['username']?>/<?=$user['username']?>" class="ppmargin" style="color:green;">Accept</a> 
                <a href="<?=URL?>/friend/reject/<?=$data['username']?>/<?=$user['username']?>" class="ppmargin" style="color:red">Reject</a> 
              <?php endif; ?>
            <?php else: ?>
            <div class="ppmargin" style="color:purple;">Sudah Berteman</div>
            <?php endif;?>
          </div>
        </div>
                                        
        <?php $found = true;
        endif;
        $i++;
      endwhile;
      if(!$found): ?>
        <div class="listContainer mainLeftGrid">
          <div>
            <a href = "<?=URL?>/user/profile/<?=$data['username'];?>/<?= $user['username']; ?>" class="ppmargin coloring listGrid">
              <div class="pictureContainer">
                <img src="<?=URL;?>/assets/img/user/<?=$user['username'];?>/profile/<?=$user['picture'];?>" alt="<?=$user['username'];?> profile picture" class="pp ppmargin">
              </div>
              <div class="nameContainer">
                <p><?= $user['name']; ?></p>
                <p class="username"><?=$user['username'];?></p>
              </div>
            </a>
          </div>
          <div class="operationButtonContainer">
            <a href="<?=URL?>/friend/add/<?=$data['username']?>/<?=$user['username']?>"><div class="ppmargin coloring">Add</div></a>
          </div>
        </div>
      <?php endif;
      endforeach;
    endif; ?>
    </div>