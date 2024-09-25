<?php
namespace Core;

class Post {
    public function get($arg) {
        if (isset($_POST[$arg])) {
            $elem = $_POST[$arg];
            if (!is_array($elem)) {
                return $elem;
            } else {
                return $elem;
            }
        } else {
            return '';
        }
    }
    public function set($key, $arg) {
        $_POST[$key] = $arg;
    }
    public function isRequest($key) {
        if (isset($_POST[$key])) {
            return true;
        } else {
            return false;
        }
    }

}
