<?php
namespace Core;

class Server {
    public function getClientIp() {
         if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = '';
        }
        
        return $ip;
    }
    // получение реферальной ссылки клиента (Необязательный параметр - нельзя доверять)
    public function getClientReferer() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        } else {
            $referer = '';
        }
        
        return $referer;
    }
}
