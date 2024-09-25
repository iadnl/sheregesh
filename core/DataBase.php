<?php
namespace Core;

class DataBase {

    private static $db_connection = null;
    private static function init() {
        $config = new \Configuration\Config;

        $username = $config->getDataBase('username');
        $password = $config->getDataBase('password');
        $host = $config->getDataBase('host');
        $db = $config->getDataBase('dbname');

        $options = [
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ];
        try {
            $connection = new \PDO("mysql:dbname=$db;host=$host; charset=utf8", $username, $password, $options);
            if ($connection) {
                return $connection;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'Error _con';
            die();
        }
    }
    public static function getConnection() {
        if (!is_null(self::$db_connection)) {
            return self::$db_connection;
        }
        self::$db_connection = self::init();
        return self::$db_connection;
    }

}
