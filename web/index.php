<?php
define("SITE_DIR", __DIR__);
define('TIMEZONE', 'Asia/Yekaterinburg');
date_default_timezone_set(TIMEZONE);
session_start();
require_once('../core/Autoload.php');

$config = new \Configuration\Config;
if ($config->getConfig('debug_mode')) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}
ini_set('log_errors', 'On');
ini_set('error_log', '../logs/php_errors.log');

// проверка доступа к файлам по прямому пути
$access = new \Core\Access;
$access->check();
// инициализация авторизации по cookie
$security = new \Core\Security;
$security->initialAuthCookie();
//маршрутизатор
$route = new \Core\Route;
$route->init();
  