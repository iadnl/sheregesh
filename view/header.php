<?php
$message = new \Core\Message;
$view = new \Core\View;

$config = new \Configuration\Config;
$url = new \Core\Url;
$session = new \Core\Session;

$class_name = $url->getClassName();
$method_name = $url->getMethodName();

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta property="og:image" content="/asset/img/template/favicon2.png" />
        <link rel="icon" type="image/png" href="/asset/img/template/favicon2.png" />
        <title><?= isset($title) ? $title : '' ?></title>
        <meta content="<?= isset($keywords) ? $keywords : '' ?>" name="keywords">
        <meta content="<?= isset($description) ? $description : '' ?>" name="description">
        <script src="/asset/js/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="/asset/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/asset/css/style.css?<?= time() ?>">
        <link rel="stylesheet" type="text/css" href="/asset/css/style2.css?<?= time() ?>">
    </head>
    <nav class="navbar navbar-expand-lg bg-ligth">
        <div class="container-fluid">
            <img src="/asset/img/logo.png" class="logo-main" alt="">
            <a class="navbar-brand" href="/">БЧП.Моменты</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-end" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a  href="/" class="nav-link nav-home">Как поехать</a>
                    </li>
                    <li class="nav-item">
                        <a  href="/page/meropriyatiya" class="nav-link">Участникам</a>
                    </li>
                    <li class="nav-item">
                        <a  href="/page/deyatelnost-centra" class="nav-link">FAQ</a>
                    </li>
                       
                </ul>
                <?php if ($session->userIsAuth()): ?>
                <div class="d-flex">
                    <a  href="/page/profile" class="btn btn-success" data-bs-target="#loginModal" class="login-button">Личный кабинет</a>
                </div>  
<!--                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">                 
                    <li class="nav-item">
                      <a  href="/" class="nav-link nav-home">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a  href="/page/meropriyatiya" class="nav-link">Раздел</a>
                    </li>
                    <li class="nav-item">
                        <a  href="/page/deyatelnost-centra" class="nav-link">Раздел</a>
                    </li>
                    <li class="nav-item">
                        <a  href="/page/obratnaya-svyaz" class="nav-link">Раздел</a>
                    </li>
                    <li class="nav-item">
                        <a  href="/page/karta" class="nav-link">Раздел</a>
                    </li>
                </ul> -->
                    <?php else: ?>
                <div class="d-flex">
                    <button  type="button" data-bs-toggle="modal" data-bs-target="#loginModal" class="login-button">Авторизация</button>
                </div>   
                    <?php endif; ?> 
                <ul class="navbar-nav  mb-2 mb-lg-0">
                    <?= $view->render('top_profile', []); ?>
                </ul>
            </div>
        </div>
    </nav>


