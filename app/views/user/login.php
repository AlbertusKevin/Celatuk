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
        } ?>

            <h4><?= Message::username404(); ?></h4>
            <h4><?= Message::password406(); ?></h4>
            <h4><?= Message::register200(); ?></h4>
            <h4><?= Message::email200(); ?></h4>
            <h4><?= Message::updatePassword200(); ?></h4>
            <h4><?= Message::changePassword204(); ?></h4>
            <h4><?= Message::deleteAccount204(); ?></h4>
            <form action="<?= URL ?>/user/login" method="post">
                <div class="container">
                    <div class="logo"><img class="svg" src="<?= URL ?>/assets/images/logo.svg"></div>

                    <div class="label" id="InputTitle">Username</div>
                    <input type="text" placeholder="Enter Username" name="username" required>

                    <div class="label" id="InputTitle">Password</div>
                    <input type="password" id="password" name="password" minlength="8" required>

                    <div class="label">
                        <div class="container12Column">
                            <div class="column-10">
                                <input type="checkbox" name="remember">Remember Me
                            </div>
                            <div class="column-2" style="margin: 0 0 0 auto">
                                <span class="psw"><a href="<?= URL ?>/user/email_forgot_password"> Forgot password?</a></span>
                            </div>
                        </div>
                        
                    </div>

                    <div class="loginRegisterButton">
                        <button type="submit"><b>Login</b></button>
                    </div>
                    
                </div>
                
                <span>
                    <div class="registernow">Don't have an account? <a href="<?= URL ?>/user/form_register" class="">Sign up now</a></div>
                </span>
            </form>