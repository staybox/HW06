<?php
// Входной контроль
$secret = "6LeG01QUAAAAAPqimtu5AbLJc0pYjnVpBn1oS92v";
if (isset($_POST['g-recaptcha-response'])) {
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);
    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER["REMOTE_ADDR"]);

    if ($resp->isSuccess()) {
        echo "Вы прошли проверку!";
    } else {
        echo "Вы не прошли проверку сударь";
        return header("Refresh: 5; url=/");
    }
}

// Надо проверить, что поля email и phone точно есть (т.к. в базе они помечены NOT NULL)
if ((empty($_REQUEST['email'])) || (empty($_REQUEST['phone']))) {
    echo json_encode(['result' => 'fail', 'error_code' => 4001], JSON_UNESCAPED_UNICODE);
    return;
}
// Подключаемся к базе
$dbh = require_once 'dbconnect.php';
if ($dbh === false) {
    echo json_encode(['result' => 'fail', 'error_code' => 4002], JSON_UNESCAPED_UNICODE);
    return;
}
// Фаза 1: Регистрация или "авторизация" пользователя
// По окончании этой фазы имеем в наличии userId
$userId = require_once 'auth.php';
if (empty($userId)) {
    echo json_encode(['result' => 'fail', 'error_code' => 4003], JSON_UNESCAPED_UNICODE);
    return;
}

// Фаза 2: Оформление заказа
// Записываем данные заказа в таблицу orders: в результате имеем orderId
$orderId = require_once 'write_order.php';
if (empty($orderId)) {
    echo json_encode(['result' => 'fail', 'error_code' => 4004], JSON_UNESCAPED_UNICODE)."\n";
    echo "Заказ не оформлен, попробуйте снова";
    return;
}
// Фаза 3: "Письмо" пользователю
$result = require_once 'send_mail.php';
if (empty($result)) {
    echo json_encode(['result' => 'fail', 'error_code' => 4005], JSON_UNESCAPED_UNICODE);
    return;
}
// Работа выполнена успешно. Отдаём хороший json :)
echo json_encode(['result' => 'success', 'order_id' => $orderId, 'message' => 'Вам будет отправлено сообщение на электронную почту ' . $_REQUEST['email']], JSON_UNESCAPED_UNICODE);
header("Refresh: 5; url=/");
