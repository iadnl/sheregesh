<?php
namespace Configuration;

class Config {
    private static $config = array(
        'db' => array(
            'username' => 'a0214888_sheregesh',
            'password' => 'afkpObJZ',
            'host' => 'localhost',
            'dbname' => 'a0214888_sheregesh',
            'prefix' => 'promo_'
        ),
        'domen' => 'https://izlagaj.ru/',
        'name' => 'БЧП',
        'submetatitle' => 'БЧП',
        'email' => 'd17best@yandex.ru', //admin email
        'mail' => array(// smtp 
            'host' =>  'smtp.bnke.ru', //from send
            'username' => 'help@bke.ru',//email from
            'password' => 'h6xswtaczD',
            'mail_from' => 'help@b.ru',// email from
            'from' => 'Б',// name from
        ),
        'site' => array(
            'title'=>'Моменты Больше чем путешествие',
            'description'=>'Моменты Больше чем путешествие',
            'keywords'=>'Моменты Больше чем путешествие',
        ),
        'salt' => 'fdsfEfdffewjGHsdfJKHHKJ',// soul security
        'debug_mode' => true,
    );
    public function getFullDomen() {
        return self::$config['domen'];
    }
    public function getConfig($key=NULL) {
        if ($key===NULL) {
            return self::$config;
        }
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        } else {
            return '';
        }
    }
    public function getSiteInfo($key) {
        $info_array = self::$config['site'];
        if ($key==='title') {
            return  $info_array['title'];
        } else if ($key==='description') {
            return  $info_array['description'];
        } else if ($key==='keywords') {
            return  $info_array['keywords'];
        } else {
            return '';
        }
    }
    public function getDataBase($key) {
        $db_array = self::$config['db'];

        if ($key==='username') {
            return  $db_array['username'];
        } else if ($key==='password') {
            return  $db_array['password'];
        } else if ($key==='host') {
            return  $db_array['host'];
        } else if ($key==='dbname') {
            return  $db_array['dbname'];
        } else if ($key==='prefix') {
            return  $db_array['prefix'];
        } else {
            return '';
        }
    }
}
