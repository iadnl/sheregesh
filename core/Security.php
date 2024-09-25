<?php
namespace Core;

class Security {
    public function initialAuthCookie() {
        $session = new \Core\Session;
        $cookie = new \Core\Cookie;
        $user_model = new \Models\User;
        // если есть cookie пользователя
        if ($cookie->isRequest('_identityd') && $cookie->isRequest('_identity')) {
            $user_cookie_id = $cookie->get('_identityd');
            $user_cookie_hash = $cookie->get('_identity');
            // если пользователь не авторизован
            if (!$session->userIsAuth()) {
                // если это пользователь по id
                if ($user_model->isUserById($user_cookie_id)) {
                    $user_hash = $user_model->getUserById($user_cookie_id, ['auth_key'])['auth_key'];
                    if ($user_hash === $user_cookie_hash) {
                        $user_model->authorizeUserById($user_cookie_id);
                    }
                }
            }
        } 
    }
    public function generateRandomString($length = 20) {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";    
        for ($i = 0; $i < $length; $i++) {
            $str.=$chars[mt_rand(0, strlen($chars) - 1)];
        }
        $full_str = base64_encode($str);
        return substr($full_str, 0, $length);
    }
    // генерация кода для подстверждения
    public function generateCode() {
        $max = 999999;
        $min = 100000;
        $vendor_code = mt_rand($min, $max);

        return $vendor_code;
    }
    // генерация уникального логина пользователя
    public function generateUserLogin($count=8) {
        $user_model = new \Models\User;
        
        $login = $this->generateRandomString($count);
        while($user_model->isUser('login', $login)){
            $login = $this->generateRandomString($count);
        }
        return mb_strtolower($login, 'UTF-8');
    }
    // криптование строки с константой солью
    public function encryptString($string) {
        $config = new \Configuration\Config;
        
        $salt = $config->getConfig('salt');        
        return md5($string.$salt);
    }
    // хэширование пароля
    public function passwordHash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    // проверка хэша и пароля 
    public function passwordHashVerify($password, $hash) {
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }
}