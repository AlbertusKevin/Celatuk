<body>
  <?php
  if (isset($_SESSION['updatepwd500'])) : ?>
    <h4>Server error. Can't update</h4>
    <?php unset($_SESSION['updatepwd500']);
  endif;

  if (isset($_COOKIE['name'])) {
    if (isset($_SESSION['cookie406'])) : ?>
    <h4><?= Message::cookie406(); ?><h4>
  <?php elseif (isset($_SESSION['cookie404'])) : ?>
    <h4><?= Message::cookie404(); ?></h4>
  <?php else :
    header('Location: ' . URL . '/user/cookie');
    endif;
  }?>
  <h4><?= Message::username404(); ?></h4>
  <h4><?= Message::password406(); ?></h4>
  <h4><?= Message::register200(); ?></h4>
  <h4><?= Message::email200(); ?></h4>
  <h4><?= Message::updatePassword200(); ?></h4>
  <h4><?= Message::changePassword204(); ?></h4>
  <h4><?= Message::deleteAccount204(); ?></h4>
  
  <div class="container login">
    <form action="<?= URL ?>/user/login" method="post">
    <div class="logo"><img class="svg" src="<?= URL ?>/assets/images/logo.svg"></div>

    <section class="userDataInput">
      <div class="border-right">
        <h5 id="InputTitle">Username</h5>
        <input type="text" placeholder="E.g. john_doe" name="username" required>
        <h5 id="InputTitle">Password</h5>
        <input type="password" placeholder="●●●●●●●●" id="password" name="password" minlength="8" required>
        <div class="operation">
          <div><input type="checkbox" name="remember"><p>Remember Me</p></div>
          <span class="psw"><a href="<?= URL ?>/user/email_forgot_password"> Forgot password?</a></span>
        </div>
      </div>
      <div class="loginOverview">
        <h3>“Open your mouth for the mute, for the rights of all who are destitute. Open your mouth, judge righteously, defend the rights of the poor and needy.”</h3>
        <h5>Proverbs 31:8-9</h5>
      </div>
    </section>

    <section class="actionButton">
      <button type="submit"><b>Login</b></button>   
      <span><div class="registernow">Don't have an account? <a href="<?= URL ?>/user/form_register" class="">Sign up now</a></div></span>
    </section>
    </form>
  </div>