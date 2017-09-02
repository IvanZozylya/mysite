<?php

// FRONT CONTROLLER

// 1. Общие настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Время жизни сессионных куки
session_set_cookie_params(0);

//запуск сессии
session_start();

// 2. Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');


// 4. Вызов Router
$router = new Router();
$router->run();

