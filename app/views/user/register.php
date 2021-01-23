<h4><?= Message::confPassword406(); ?></h4>
<h4><?= Message::picture404(); ?></h4>
<h4><?= Message::picture406(); ?></h4>
<h4><?= Message::uniqueUsername406(); ?></h4>

<body>
<form action="<?= URL; ?>/user/register" method = "post" enctype = "multipart/form-data">
    <div class="container register">
      <div class="logo"><img class="svg" src="<?=URL?>/assets//images/logo.svg"></div>
      <div class="gridContainer">
        <div class="border-right">
          <h5>Name</h5>
          <input type="text" placeholder="Enter Your Name" name="name" required 
          <?php if(isset($data['name'])): ?>
              value  = "<?= $data['name'] ?>"
          <?php endif; ?>
          >
          
          <h5>Username</h5>
          <input type="text" placeholder="Enter username" name="username" required
          <?php if(isset($data['username'])): ?>
              value  = "<?= $data['username'] ?>"
          <?php endif; ?>
          >

          <h5>Password</h5>
          <input type="password" id="pwd" name="pwd" minlength="8" required>
          
          <h5>Confirm Password</h5>
          <input type="password" id="conf_pwd" name="conf_pwd" minlength="8" required>
          
          <h5>E-mail</h5>
          <input type="email" placeholder="Enter E-mail" name="email" required
          <?php if(isset($data['email'])): ?>
              value  = "<?= $data['email'] ?>"
          <?php endif; ?>
          >
          
          <h5>Phone</h5>
          <input type="number" placeholder="Enter Phone Number" name="phone" required
          <?php if(isset($data['phone'])): ?>
              value  = "<?= $data['phone'] ?>"
          <?php endif; ?>
          >
          
          <h5>Profile Picture</h5>
          <input type="file" id = "picture" name = "picture" required>
          
          <h5>Background Picture</h5>
          <input type="file" id = "bg_picture" name = "bg_picture" required>
          
          <div class="label"><input type="checkbox" name="remember">By creating an account means you’re okay with our <a href="#" class="term">Terms of Service</a>, <a href="#" class="term">Privacy Policy</a>.</div>
          <button type="submit" class="registerbtn"><b>Register</b></button>
        </div>
        <div class="rowContainer">
          <h1>Welcome to Celatuk</h1>
          <div class="registernow">Already have an account? <a href="<?=URL?>/user/form_login" class="">Sign in now</a></div>
        </div>
        
      </div>
    </div>
</form>
