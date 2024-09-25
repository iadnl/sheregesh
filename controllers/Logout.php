<?php

// Сброс авторизации пользователя

namespace Controllers;

class Logout {

    // выход из учетной записи
    public static function index() {
        $session = new \Core\Session;
        $message = new \Core\Message;
        $header = new \Core\Header;
        $cookie = new \Core\Cookie;

        $session->logout();
        $cookie->remove('_identityd');
        $cookie->remove('_identity');
        $message->send('info', 'До скорой встречи!');
        $header->redirect('/');
    }

}
