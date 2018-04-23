<?php
// Подключаем полезные функции
require_once 'utils.php';
// Создаём папку для писем, если её нет
$emailsFolder = __DIR__ . DIRECTORY_SEPARATOR . '_emails_';
if (!file_exists($emailsFolder)) {
    try {
        mkdir($emailsFolder, 0777);
    } catch (ErrorException $e) {
        return null;
    }
}
// Файл для сохранения текста письма
$emailFileName = $emailsFolder . DIRECTORY_SEPARATOR . date('Y-m-d__H-i-s') . '.txt';
// Получаем адрес и номер заказа данного пользователя
$userAddress = makeBeautyAddress($_REQUEST['street'], $_REQUEST['home'], $_REQUEST['part'], $_REQUEST['appt'], $_REQUEST['floor']);
$userOrderNum = getOrderNumber($dbh, $userId);
// Текст письма
$mailText = "Заказ № $orderId\n\n";
$mailText .= "Ваш заказ будет доставлен по адресу:\n";
$mailText .= $userAddress . "\n\n";
$mailText .= "Содержимое заказа:\n";
$mailText .= "DarkBeefBurger за 500 рублей, 1 шт\n\n";
$mailText .= "Спасибо!\n";
$mailText .= "Это Ваш " . $userOrderNum . " заказ!\n";
// Пишем в файл
try {
    file_put_contents($emailFileName, $mailText);
} catch (ErrorException $e) {
    return null;
}

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.mail.ru";
$mail->Username = "andrewcool@mail.ru";
$mail->Password = '';
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to
$mail->setFrom('andrewcool@mail.ru', 'E-mail с сайта');
$mail->addAddress($_REQUEST['email'], 'Получатель');     // Add a recipient
//$mail->addCC($_POST['email'], $_POST['name']);
//$mail->addAttachment('composer.json');
$mail->addReplyTo('andrewcool@mail.ru', 'Robot');
$mail->CharSet = 'UTF-8';
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Письмо с сайта ' . date('d.m.Y H:i:s', time());
$mail->Body    = "Заказ № $orderId<br><br>";
$mail->Body    .= "Ваш заказ будет доставлен по адресу:<br>";
$mail->Body    .= $userAddress . "<br><br>";
$mail->Body    .= "Содержимое заказа:<br><br>";
$mail->Body    .= "DarkBeefBurger за 500 рублей, 1 шт<br><br>";
$mail->Body    .= "Спасибо!<br><br>";
$mail->Body    .= "Это Ваш " . $userOrderNum . " заказ!<br><br>";
$mail->Body    .= "DarkBeefBurger за 500 рублей, 1 шт<br><br>";
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    return;
} else {
    echo 'Message has been sent';
}
return true;