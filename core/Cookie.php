<?php
namespace Core;

class Cookie {
    // получение значение по ключу
    public function get($arg) {
        if (isset($_COOKIE[$arg])) {
            $elem = $_COOKIE[$arg];
            if (!is_array($elem)) {
                return $elem;
            } else {
                return $elem;
            }
        } else {
            return '';
        }
    }
    // запись значение по ключу
    public function set($key, $arg, $time=0, $where='/') {
        // по умолчанию 30д
        if ($time === 0) {
            $time = time() + (3600 * 24 * 30);
        }
        setcookie($key, $arg, $time, $where);
    }
    // проверка существавния COOKIE запроса по ключу
    public function isRequest($key) {
        if (isset($_COOKIE[$key])) {
            return true;
        } else {
            return false;
        }
    }
    // удаление cookie по ключу 
    public function remove($key) {
        if ($this->isRequest($key)) {
            unset($_COOKIE[$key]);
            $this->set($key, null, -1, '/');
            return true;
        } else {
            return false;
        }
    }
}
