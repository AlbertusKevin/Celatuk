<?php $user = $data['profile']; ?>
<body>
  <h4><?= Message::updateProfile200(); ?></h4>
  <h4><?= Message::picture406(); ?></h4>
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
          <a href="<?= URL ?>/home/index/<?=$data['profile']['username']?>"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconHome" src="<?= URL ?>/assets/images/home_icon.svg"></a>
          <a href="<?= URL ?>/messenger/index/<?=$data['profile']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconChat" src="<?= URL ?>/assets/images/mdi_forum.svg"></a>
          <a href="<?= URL ?>/friend/index/<?=$data['profile']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconFriends" src="<?= URL ?>/assets/images/mdi_friends.svg"></a>
          <a href="<?= URL ?>/home/index_user/<?=$data['profile']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconUser" src="<?= URL ?>/assets/images/mdi_userlist.svg"></a>
          <a href="<?= URL ?>/group/index/<?=$data['profile']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconGroup" src="<?= URL ?>/assets/images/group_icon.svg"></a>
          <a href="<?= URL ?>/home/profile/<?=$data['profile']['username']?>"><img class="topNavigationBarLinkIcons"id="TopNavigationBarLinkIconProfile" src="<?= URL ?>/assets/images/mdi_user.svg"></a>
          <a href="<?= URL ?>/user/logout"><img class="topNavigationBarLinkIcons" id="TopNavigationBarLinkIconLogout"src="<?= URL ?>/assets/images/mdi_power.svg"></a>
      </div>
    </section>
  </header>
  <section class="userEditInfo">
    <div class="container">
      <h2>Update Profile Info</h2>
      <div class="userPersonalInfoContainer">
        <div class="userPersonalInfo border-right">
          <form action="<?= URL; ?>/user/update/<?=$user['username'] ?>" method = "post" enctype = "multipart/form-data">
                  <input type="hidden" name="username" value = "<?=$user['username']; ?>">
                  <h5>Name</h5>
                  <input type="text" placeholder="Enter Your Name" name="name" value = "<?=$user['name'] ?>" required >

                  <h5>E-mail</h5>
                  <input type="email" placeholder="Enter E-mail" name="email" value = <?=$user['email'] ?> required>
                  
                  <h5>Phone</h5>
                  <input type="number" placeholder="Enter Phone Number" name="phone" value = <?=$user['phone'] ?> required>
                  
                 
                  <h5>Profile Picture</h5>
                  <input type="file" id = "picture" name = "picture">
                  
                  <h5>Background Picture</h5>
                  <input type="file" id = "bg_picture" name = "bg_picture">

                  <button type="submit"><b>Edit</b></button>
          </form>
        </div>
        <div class="userPersonalPreview">
          <div class="profileCard">
            <div class="userPicture">
              <div class="userBackgroundPicture">
                <img src="<?=URL?>/assets/img/user/<?=$data['profile']['username']?>/background/<?=$data['profile']['bgPicture']?>" alt="<?=$data['profile']['username']?> Profile Picture" width = "200">
              </div>
              <div class="userProfilePicture">
                <div class="imageContainer">
                  <img src="<?=URL?>/assets/img/user/<?=$data['profile']['username']?>/profile/<?=$user['picture']?>" alt="<?=$data['profile']['username']?> Profile Picture" width = "200">
                </div>
              </div>
            </div>
            <div class="userInfoPreview">
              <div>
                <h6>Username:</h6>
                <h3><?=$data['profile']['username']?></h3>
              </div>
            </div>
          </div>
          <div class="accountPass">
            <h6>Security Settings</h6>
            <a href="<?= URL; ?>/user/change_password/<?=$user['username']?>" class="coloring" style="margin-left:10px;">Change Password</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- username: mikazuki
pwd: BarbatosLupus

username: vin_albertus
pwd: Barbatos@08

username: vernaprilia
pwd: INA1762020 -->