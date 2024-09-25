<?php
function autoloadClasses($class_name) {
    $path = explode('\\', $class_name);
    $path2 = ucfirst(array_pop($path));
    $path = array_map('strtolower', $path);
    if ($path !== [])
        $path2 = '../'.implode('/', $path) . '/' . $path2;
    if (!is_file($path2 . ".php")) {
        throw new Exception('autoload error: ' . $path2);
        //die('autoload error '.$path2);
    } else
        require_once($path2 . ".php");
}

spl_autoload_register('autoloadClasses');
