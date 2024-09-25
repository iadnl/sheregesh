<?php
$session = new \Core\Session;
$date = new \Core\Date;
$check = new \Core\Check;

?>
<div class="bg-gradient-form">
    <div class="card shadow-lg">
        <div class="card-body p-4 p-md-5">
            <?php if ($session->userIsAuth()): ?>
                <div class="success-block">
                    Авторизация пройдена! <i class="glyphicon glyphicon-ok"></i>
                </div>
            <?php else: ?>
                <h1 class="display-4">Авторизация</h1>
                <p class="lead">Этот текст написан для макета. Этот текст написан для макета. </p>
                <form  method="POST" action="/login">
                    <label for="">E-mail</label>
                    <input class="form-control form-control-lg" type="text" name="login" placeholder=""
                           aria-label=".form-control-lg example">
                    <label for="">Пароль</label>
                    <input class="form-control form-control-lg" type="password" name="password" placeholder=""
                           aria-label=".form-control-lg example">
                    <p></p>
                    <?php
                    if (isset($errors)) {
                        foreach ($errors as $error) {
                            echo '<div class="alert alert-warning" role="alert">' . $error . '</div>';
                        }
                    }

                    ?>
                    <input type="hidden" name="login-form" value="log">
                    <div class="w-100 text-center bg-gradient-form__but">
                        <button type="submit" name="login-form" class="btn btn-primary btn-lg">Войти</button>
                        <button type="button" class="btn btn-outline-primary btn-lg">Регистрация</button>
                    </div>
                </form>
                <hr>
                <h5>Войти через</h5>
                <div class="w-100 text-center bg-gradient-form_aa">
                    <img src="/web/asset/img/gosuslugi.jpg" alt="">
                    <img src="/web/asset/img/VK_Compact.png" class="vkauth" alt="">
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<section class="bg-gradient">
    <div class="bg-gradient-pas"></div>
    <div class="container-fluid">
        <div class="row">
            <?php
            $arr = [
                '/web/asset/img/template/imgae/img.jpg',
                '/web/asset/img/template/imgae/img2.png',
                '/web/asset/img/template/imgae/img3.jpg',
                '/web/asset/img/template/imgae/img4.png',
                '/web/asset/img/template/imgae/img5.jpg',
                '/web/asset/img/template/imgae/img6.png',
                '/web/asset/img/template/imgae/img7.png',
                '/web/asset/img/template/imgae/img8.png',
                '/web/asset/img/template/imgae/img9.png',
                '/web/asset/img/template/imgae/img10.png',
            ];
            shuffle($arr);
            ?>
            <?php foreach ($arr as $i => $value): ?>
                <?php
                if ($i === 8) {
                    break;
                }
                ?>
                <div class="col-6 col-md-4 col-lg-3 mb-3">
                    <a href="landing-insurance.html">
                        <img src="<?= $value ?>" alt="Insurance" class="rounded">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>