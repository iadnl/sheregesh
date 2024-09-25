<?php
$session = new \Core\Session;
$captcha = new \Core\Captcha;
$post = new \Core\Post;
?>
<div class="content-block">
    <div class="row">
        <div class="col-md-8">
            <div class="full-content">
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <div class="reg_form">
                            <?php if ($session->userIsAuth()): ?>
                                <div class="success-block">
                                    Авторизация пройдена! <i class="glyphicon glyphicon-ok"></i>
                                </div>
                            <?php else: ?>
                                    <span>Регистрация</span>
                                    <?php
                                    if (isset($errors)) {
                                        foreach ($errors as $error) {
                                            echo '<div class="alert alert-warning" role="alert">' . $error . '</div>';
                                        }
                                    }
                                    ?>
                                    <div class="reg-form">
                                        <form method="POST">
                                            <label for="login">Логин</label>
                                            <input type="text" class="form-control" name="login" id="login" value="<?= $post->get('login') ?>" placeholder="user" required>
                                            <label for="email">E-mail</label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?= $post->get('email') ?>" placeholder="mail@email.ru" required>
                                            <label for="password">Пароль</label>
                                            <input type="password" id="password" value="<?= $post->get('password') ?>" class="form-control" name="password" required>
                                            <label for="repassword">Повторите пароль</label>
                                            <input type="password" id="repassword" value="<?= $post->get('repassword') ?>" class="form-control" name="repassword" required>
                                            <label for="captcha">Введите код с картинки</label>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <img class="captcha-image" src="<?= $captcha->getImageLink() ?>" alt="капча">
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" id="captcha" class="form-control" name="captcha" required>
                                                </div>
                                            </div>
                                            <button type="submit" name="registration-form">Регистрация</button>
                                        </form>
                                    </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-content-block">
            <div class="col-md-4">
                <div class="right-content">
                    <?= isset($sidebar_content) ? $sidebar_content : '' ?>
                </div>
            </div>
        </div>
    </div>
</div>