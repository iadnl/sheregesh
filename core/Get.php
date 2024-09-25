<?php
namespace Core;

class Get {

    // получение значение по ключу
    public function get($arg) {
        if (isset($_GET[$arg])) {
            return trim($_GET[$arg]);
        } else {
            return '';
        }
    }

    // запись значение по ключу 
    public function set($key, $arg) {
        $_GET[$key] = $arg;
    }

    // получение массива значений с ключами
    public function getArray() {
        return $_GET;
    }

}
