<?php
namespace Core;

class Header {

    public function redirect($url) {
        header('Location: ' . $url);
        exit();
    }
}
