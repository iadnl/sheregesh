<?php
$post = new \Core\Post;
$session = new \Core\Session;

// если ошибки заполнения формы
if (isset($errors) && (count($errors) !== 0)) {
    $user['email'] = $post->get('email');
    $user['name'] = $post->get('full_name');
    if ($post->get('gender') === 'man') {
        $user['gender'] = 1;
    } elseif ($post->get('gender') === 'woman') {
        $user['gender'] = 0;
    } else {
        $user['gender'] = '';
    }
    $user['about_me'] = $post->get('about_me');
} else {
    $errors = [];
}
?>
<div class="user_page">
    <div class="row">
        <div class="col-md-3">
            <div class="user_settings_buttons_block">
                <a href="/user/<?= $user['login'] ?>" class="user_page_left_info_button_default"><i class=" glyphicon glyphicon-menu-left"></i> Вернуться назад </a>
                <?php foreach ($errors as $key => $error): ?>
                    <div class="alert alert-warning" role="alert"><?=$error?></div>
                <?php endforeach ?>
            </div>
        </div>	
        <div class="col-md-9">
            <div class="user_settings">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#user_settings_profile" aria-controls="user_settings_profile" data-toggle="tab">Основные настройки</a></li>
                    <li><a href="#user_settings_photo" aria-controls="user_settings_photo" data-toggle="tab">Изменить фотографию</a></li>
                    <li><a href="#user_settings_password" aria-controls="user_settings_password" data-toggle="tab">Сменить пароль</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="user_settings_profile">
                        <form enctype="multipart/form-data" method="post">
                            <label for="">Полное имя</label>
                            <input type="text" class="form-control" name="full_name" value="<?= $user['name'] ?>">
                            <label for="">E-mail</label>
                            <input type="text" class="form-control" name="email" value="<?= $user['email'] ?>">    	
                            <label for="">Пол</label>
                            <select name="gender">
                                    <option value="0">-</option>
                                    <option value="1" <?=$user['gender']===1?'selected':''?>>Мужчина</option>
                                    <option value="2" <?=$user['gender']===2?'selected':''?>>Женщина</option>
                            </select>
                            <label for="about_me">Информация о себе</label>
                            <textarea name="about_me" id="about_me"><?= $user['about_me'] ?></textarea>
                            <input type="submit" name="update-user-profile-form" value="Отправить" />
                        </form>
                    </div>
                    <div class="tab-pane" id="user_settings_photo">
                        <img src="<?php //$session->getPhoto() ?>" alt="">
                        <form enctype="multipart/form-data" method="post">
                            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                            <p>Изображение должно быть в формате PNG или JPEG и не более 500 кб.</p>
                            <input name="new_user_photo" type="file" />
                            <input type="submit" name="change-user-photo-form" value="Отправить" />
                        </form>
                    </div>
                    <div class="tab-pane" id="user_settings_password">
                        <form enctype="multipart/form-data" method="post">
                            <label for="">Текущий пароль</label>
                            <input type="password" class="form-control" name="present_password">    	
                            <p>Пароль должен быть не меньше 3-х символов и не больше 40</p>
                            <label for="">Новый пароль</label>
                            <input type="password" class="form-control" name="password">
                            <label for="">Повтор пароля</label>
                            <input type="password" class="form-control" name="repeat_password">
                            <input type="submit" name="change-user-password-form" value="Отправить" />
                        </form>
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>