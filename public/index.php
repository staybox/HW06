<?php
// начинаем работать с сессией
session_start();
require "../vendor/autoload.php";
$appDir = realpath(__DIR__ . '/../app');

// стартовая страница
if ($_SERVER['REQUEST_URI'] == "/") {
    require_once($appDir . DIRECTORY_SEPARATOR . 'template.php');
    return 0;
}

// добавляем в базу
if (!empty($_POST) && $_SERVER['REQUEST_URI'] == "/order/add") {
    include_once($appDir . DIRECTORY_SEPARATOR . 'order.php');
    return 0;
}

// просмотр пользователей (административная панель)
if ($_SERVER['REQUEST_URI'] == "/admin/users") {
    include_once($appDir . DIRECTORY_SEPARATOR . 'admin.php');
    return 0;
}

// просмотр заказов (административная панель)
if ($_SERVER['REQUEST_URI'] == "/admin/orders") {
    // тут код вывода
    return 0;
}

// обработка ошибок
if (strpos($_SERVER['REQUEST_URI'], 'errcode') > 0) {
    require_once($appDir . '/error.php');
    return;
}

// такой страницы нет
header("HTTP/1.0 404 Not Found");
