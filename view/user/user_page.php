<?php
$session = new \Core\Session;
$html = new \Core\Html;
$access = new \Core\Access;
$user_model = new \Models\User;
$comment_model = new \Models\Comments;
$date = new \Core\Date;

$user_rating = $comment_model->getUserCommentsRaiting($user_array['id']);
?>

<div class="user_page">
    <div class="row">
        <div class="col-md-4">
            <div class="user_page_left">
                <div class="user_page_avatar">
                    <img src="<?= $user_array['photo'] ?>" alt="">
                </div>
                <div class="user_page_rating user_page_rating-<?=(integer)$user_rating>0?'plus':''?><?=(integer)$user_rating<0?'minus':''?>">Рейтинг: <?=$user_rating?></div>
                <a href="/user/<?= $user_array['login'] ?>"><h1 class="user_page_login"><?= $user_array['name'] == '' ? '' : '[ '.$html->escape($user_array['name']).' ]' ?> <?= $user_array['login'] ?></h1></a>
                <span class="user_page_date" title="<?= date('d.m.Y h:m', $user_array['last_date']) ?>">Последняя активность: <?= $date->showDate($user_array['last_date']) ?></span>
                <span class="user_page_date" title="<?= date('d.m.Y h:m', $user_array['reg_date']) ?>">Дата регистрации: <?= $date->showDate($user_array['reg_date']) ?></span>
                <div class="user_page_devider"></div>
                <span class="user_page_header">Информация: </span>
                <div class="user_page_info_block">группа: 
                <?php
                    if ($user_array['degree'] === 'user') {
                        echo 'Пользователи';
                    } else if ($user_array['degree'] === 'moderator') {
                        echo 'Модераторы';
                    } else if ($user_array['degree'] === 'admin') {
                        echo 'Администраторы';
                    }
                ?>
                </div>
                <div class="user_page_info_block">пол:
                <?php
                    if ($user_array['gender'] === 1) {
                        echo 'мужской';
                    } elseif ($user_array['gender'] === 2) {
                        echo 'женский';
                    } else {
                        echo '-';
                    }
                ?>
                </div>
            </div>	
        </div>	
        <div class="col-md-8">
            <div class="user_page_feed">
                <div class="user_page_feed_about">
                    <span>О себе</span>
                    <div class="user_page_feed_about_text"><?= $user_array['about_me'] == '' ? '-' : $html->escape($user_array['about_me']) ?></div>
                </div>
                <div class="user_page_devider"></div>
                <span>Комментарии:</span>
                <?= $user_comments ?>
            </div>
        </div>	
    </div>
</div>


<?php if ($access->allowGroup(['admin'])): /* только для админа, дополнительные возможности */ ?>
    <script>
        var _option_array = {
            'type':'user',
            'id':<?=$user_array['id']?>,
        }
    </script>
<?php endif ?>

