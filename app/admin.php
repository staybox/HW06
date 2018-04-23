<?php
// Подключаемся к базе
$dbh = require_once 'dbconnect.php';
if ($dbh === false) {
    header("Location: /?errcode=4002");
    return;
}

function getUsers($pdo)
{
    $users = [];

    $stmt = $pdo->query('SELECT * FROM users ORDER BY user_id');

    while ($row = $stmt->fetch()) {
        $users[] = $row;
    }

    return $users;
}

$users = getUsers($dbh);

function getOrders($pdo)
{
    $orders = [];

    $stmt = $pdo->query('SELECT orders.*, users.name as username FROM orders,users WHERE orders.user_id=users.user_id ORDER BY orders.user_id');

    while ($row = $stmt->fetch()) {
        $orders[] = $row;
    }

    return $orders;
}

$users = getUsers($dbh);
$orders = getOrders($dbh);
/*
// Получаем данные из базы

    // Пользователи:
    $users = $dbh->query('SELECT * FROM users ORDER BY user_id');
    var_dump($users);
    // Заказы:
    $sql = 'SELECT orders.*, users.name as username FROM orders,users WHERE orders.user_id=users.user_id ORDER BY orders.user_id';
    $orders = $dbh->query($sql);
*/
// Отображаем данные: в admin_view идёт работа только с $sth_users и $sth_orders
require_once 'admin_view.php';
