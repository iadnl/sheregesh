<?php
namespace Controllers;

class Auth {
    public function login() {
        $view = new \Core\View;
        $check = new \Core\Check;
        $user_model = new \Models\User;
        $post = new \Core\Post;        
        $security = new \Core\Security;        
        $cookie = new \Core\Cookie;

        if (!$post->isRequest('login')) {
            $view->notFound();
        }
        $email = mb_strtolower(trim($post->get('login')), 'UTF-8');
        $password = $post->get('password');

        if (!$check->rangeStringLenght($password, 1, 40)) { // Длина пароля должна быть не менее 3-х и не более 40 символов
            $view->sendJsonError('Неверный логин/e-mail или пароль 1');
        }
        if ($check->email($email)) {
            if (!$user_model->isUser('email', $email)) {// Пользователя с таким email не существует
                $view->sendJsonError('Неверный логин/e-mail или пароль 2');
            }
            $user = $user_model->getUser('email', $email, ['id', 'login', 'password', 'banned', 'banned_descr', 'first_failed_login_time', 'failed_login_count', 'auth_key']);
        } else {
            $login = $email;
            if (!$check->rangeStringLenght($login, 1, 40)) {
                $view->sendJsonError('Неверный логин/e-mail или пароль 3');
            }
            if ($check->login($login) === true) {// Логин может состоять только из латинских букв и цифр
                $view->sendJsonError('Неверный логин/e-mail или пароль 4');
            }
            if (!$user_model->isUser('login', $login)) {// Пользователя с таким логином не существует
                $view->sendJsonError('Неверный логин/e-mail или пароль 5');
            }
            $user = $user_model->getUser('login', $login, ['id', 'login', 'password', 'banned', 'banned_descr', 'first_failed_login_time', 'failed_login_count', 'auth_key']);
        }
        if (strval($user['banned']) === '1') { //проверка заблокирован ли пользователь
            $view->sendJsonError('Пользователь заблокирован!' . ' Причина: ' . $user['banned_descr']);
        }
        
        $bad_login_limit = 3;
        $lockout_time = 600;
        $failed_login_count = (int)$user['failed_login_count'];
        $first_failed_login_time = (int)$user['first_failed_login_time'];
//        if (($failed_login_count >= $bad_login_limit) && (time() - $first_failed_login_time < $lockout_time)) {
//            $view->sendJsonError('Частое обращение, немного подождите. Если Вы забыли пароль вы можете восстановить его');
//        }
        if (time() - $first_failed_login_time > $lockout_time) { // первая авторизация за $lockout_time секунд 
            $user_model->updateAuthDataUserById($user['id'], 1, time());
        } else {
            $failed_login_count += $failed_login_count;
            $user_model->updateAuthDataUserById($user['id'], $failed_login_count);
        }

        // сверка паролей         
        if (!$security->passwordHashVerify($password, $user['password'])) {
            $view->sendJsonError('Неверный логин/e-mail или пароль 7');
        }

        if ($post->get('remember') === '1') {// отметка замомнить по cookie
            if (strlen($user['auth_key']) < 60) {
                $auth_key = $user_model->updateAuthkeyUserById($user['id']);
            } else {
                $auth_key = $user['auth_key'];
            }
            $cookie->set('_identityd', $user['id'], time() + 31556926); //user id на 1 год
            $cookie->set('_identity', $auth_key, time() + 31556926); //user id на 1 год
        }
        
        $this->auth($user['id']);
        $view->sendJsonSuccess('Успешно');
    }
    // обработка регистрация пользователя
    public function registration() {
        $view = new \Core\View;
        $session = new \Core\Session;
        $check = new \Core\Check;
        $model_user = new \Models\User;
        $post = new \Core\Post;
        $mail = new \Core\Mail;
        $security = new \Core\Security;
        $server = new \Core\Server;

        // если не пришла форма
        if (!$post->isRequest('email')) {
            $view->notFound();
        }
        $email = mb_strtolower($post->get('email'), 'UTF-8');
        $password = mb_strtolower($post->get('password'), 'UTF-8');
        $repassword = mb_strtolower($post->get('repassword'), 'UTF-8');
        $surname = mb_strtolower($post->get('surname'), 'UTF-8');
        $name = mb_strtolower($post->get('name'), 'UTF-8');
        $patronymic = mb_strtolower($post->get('patronymic'), 'UTF-8');
        $email = mb_strtolower($post->get('email'), 'UTF-8');
        $birthday = mb_strtolower($post->get('birthday'), 'UTF-8');
        $gender = mb_strtolower($post->get('gender'), 'UTF-8');
        if ($password !== $repassword) {
            $view->sendJsonError('Не совподает пароль');
        }
        if (!$check->email($email)) {//Введен некорректный E-mail
            $view->sendJsonError('Неккоректный e-mail');
        }
        if (!$check->rangeStringLenght($email, 3, 254)) {
            $view->sendJsonError('Неккоректный e-mail');
        }
        // проверка существования активированного пользователя
        if ($model_user->isUser('email', $email, 1)) {
            $view->sendJsonError('Вы уже зарегистрированы. Попробуйте восстановить пароль');
        }
        $code = $security->generateCode();
        if (!$check->email($email)) {//Введен некорректный E-mail
            $view->sendJsonError('Неккоректный e-mail');
        }
        // проверка существования активированного пользователя
        if ($model_user->isUser('email', $email, 1)) {
            $view->sendJsonError('Вы уже зарегистрированы. Попробуйте восстановить пароль');
        }

        if (!$model_user->isUser('email', $email)) {
            // добавление пользователя в базу
            $login = $security->generateUserLogin();
            $array_data = array(
                'login' => $login,
                'password' => $security->passwordHash($password),
                'email' => $email,
                'name' => $name,
                'surname' => $surname,
                'patronymic' => $patronymic,
                'birthday' => $birthday,
                'gender' => $gender,
                'date' => time(),
                'ip_registration' => $server->getClientIp(),
                'auth_key' => $security->generateRandomString(60),
            );
            if (!$model_user->registration($array_data)) { // если неуспешное добавление в базу
                $view->sendJsonError('Произошла ошибка, попробуйте позже или свяжитесь с администратором');
            }
        }
        $view->sendJsonSuccess('Успешно');
    }
    // выход из учетной записи
    public function logout() {
        $session = new \Core\Session;
        $view = new \Core\View;
        $message = new \Core\Message;
        $header = new \Core\Header;
        $cookie = new \Core\Cookie;
        $access = new \Core\Access;

        // если не авторизовать ошибка 404
        if (!$access->userAuth()) {
            $view->notFound();
        }

        $session->logout();
        $cookie->remove('_identityd');
        $cookie->remove('_identity');
        $message->send('info', 'До скорой встречи!');
        $header->redirect('/');
    }
// =========================== private ==============================
    // авторизация пользователя в системе
    private function auth($user_id) {
        $server = new \Core\Server;
        $message = new \Core\Message;
        $user_model = new \Models\User;
        
        $user_ip = $server->getClientIp();
        $user_model->updateLastDateLastIp($user_id, time(), $user_ip); // обновление даты последнего посещения 
        $user_model->updateAuthDataUserById($user_id, 1, time()); // обновление данных авторизации
        $user_model->authorizeUserById($user_id);
        $message->send('success', 'Успешная авторизация!');
    }
}
