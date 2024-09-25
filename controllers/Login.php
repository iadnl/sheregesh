<?php

// Авторизация пользователя

namespace Controllers;

class Login {
    // авторизация
    public function index() {
        $view = new \Core\View;
        $check = new \Core\Check;
        $user_model = new \Models\User;
        $post = new \Core\Post;
        $session = new \Core\Session;
        $message = new \Core\Message;
        //$captcha = new \Core\Captcha;
        $server = new \Core\Server;
        $cookie = new \Core\Cookie;
        $header = new \Core\Header;

        if ($post->isRequest('login-form')) { // пришла форма
            $errors=[];
            $login = trim($post->get('login'));
            $password = $post->get('password');
            // счетчик количества попыток авторизации
//            if ($session->is('count_try_login')) {
//                $count = $session->get('count_try_login');
//                $session->set('count_try_login', $count+1);
//            } else {
//                $session->set('count_try_login', 1);
//            }
//            if (count($errors)===0) {
//                if ($session->get('count_try_login')>3) {
//                    $session_captcha = $captcha->getCode();
//                    $captcha_code = $post->get('captcha');
//                    if (md5($captcha_code) !== $session_captcha) {
//                        $captcha->generateCaptcha(); // Заново генерируем капчу
//                        $errors[] = "Неверный код с картинки";
//                    } else {// сброс предыдущей капчи !ВАЖНО
//                        $captcha->generateCaptcha(); // генерация капчи
//                    }
//                }
//            }

            if (!$check->rangeStringLenght($login, 3, 40)) {
                $errors[] = "Длина логина должна быть не менее 3-х и не более 40 символов!";
            }
            if (count($errors)===0) {
                if ($check->login($login) === true) {
                    $errors[] = "Логин может состоять только из латинских букв и цифр";
                }
            }
            if (count($errors)===0) {
                if (!$check->rangeStringLenght($password, 3, 40)) {
                    $errors[] = "Длина пароля должна быть не менее 3-х и не более 40 символов!";
                }
            }
            if (count($errors)===0) {
                if (!$user_model->isUser('login', $login)) {
                    $errors[] = 'Пользователя с таким логином не существует';
                }
            }
            if (count($errors)===0) {
                $auth = new \Core\Security;
                $user = $user_model->getUserByLogin($login, ['id', 'login', 'password','banned', 'banned_descr']);
                if (!$auth->passwordHashVerify($password, $user['password'])) {
                    $errors[] = 'Неверный логин или пароль';
                }
            }
            if (count($errors)===0) {
                if (strval($user['banned']) === '1') { //проверка заблокирован ли пользователь
                    $errors[] = 'Пользователь заблокирован!';
                    $errors[] .= ' Причина: '.$user['banned_descr'];
                }
            }
            if (count($errors)===0) { // получение пользователя из базы
                $session->remove('count_try_login');// обнуление попыток авторизации
                if ($post->get('remember')==='1') {// отметка замомнить по cookie
                    if (strlen($user['auth_key'])<60) {
                        $auth_key = $user_model->updateAuthkeyUserById($user['id']);
                    } else {
                        $auth_key = $user['auth_key'];
                    }
                    $cookie->set('_identityd', $user['id'], time()+31556926);//user id на 1 год
                    $cookie->set('_identity', $auth_key, time()+31556926);//user id на 1 год
                }
                $user_ip = $server->getClientIp();
                $user_model->updateLastDateLastIp($login, time(), $user_ip);// обновление даты последнего посещения
                $user_model->authorizeUserById($user['id']);
                $message->send('success', 'Успешная авторизация!');
                $header->redirect($server->getClientReferer());
            } else { // Вывод ошибок
                $content = $view->render('index', [
                    'header' => $view->render('header', [
                        'title' => 'Авторизация',
                    ]),
                    'main_content' => $view->render('main', [
                        'errors' => $errors,
                    ]),
                    'footer' => $view->render('footer', []),
                ]);
                $view->send($content);
            }
        } else { // по умолчанию
            $content = $view->render('index', [
                'header' => $view->render('header', [
                    'title' => 'Авторизация',
                ]),
                'main_content' => $view->render('main', [
                ]),
                'footer' => $view->render('footer', []),
            ]);
            $view->send($content);
        }
    }

}
