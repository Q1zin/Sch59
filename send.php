<?php

include 'config.php';

if (!isset($_POST['loginRecovery'])) {
    echo json_encode(array("error" => true, "initError" => true));
    exit;
}
$email = $_POST['loginRecovery'];
$form = "recovery-password";
$hash = md5(random_int(345, 9394526234));

$main_base = new DataBase(BASE_NAME, BASE_USER, BASE_PASS, CHARSET, BASE_HOST);

$sql = "UPDATE `users` SET `recovery`='$hash' WHERE `email` = '$email'";

$result = $main_base->query($sql, true);

if (empty($result)) {
    echo json_encode(array("error" => true, "queryError" => true));
    exit;
}

$link = "https://sch59.su/admin/recovery-password.php?hash=$hash";

// Файлы phpmailer

require "E:/OpenServer/domains/sch59.su/phpmailer/PHPMailer.php";
require 'E:/OpenServer/domains/sch59.su/phpmailer/SMTP.php';
require 'E:/OpenServer/domains/sch59.su/phpmailer/Exception.php';

// Формирование самого письма
if ($form == "recovery-password") {
    $title = "Восстановление пароля для sch59.su";
    $body = "
    <h2>Восстановление пароля</h2>
    <p>Для восстановления пароля перейдите по этой ссылке: <a href=\"$link\">ссылка</a></p><br>
    <p>Если вы не пытались восстановить пароль, то ничего не делайте, или смените логин</p>
    <br>
    <br>
    <b>Сайт школы 59, г. Барнаул</b>
    ";
} else {
    exit;
}

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    // $mail->SMTPDebug = 2;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['status'][] = $str;
    };

    // Настройки вашей почты
    $mail->Host       = 'smtp.mail.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'q1zin@mail.ru'; // Логин на почте
    $mail->Password   = 'LHNR5egwK9yvD94YdQgJ'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('q1zin@mail.ru', 'Владимир Шарапов'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress($email);

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Проверяем отравленность сообщения
    if ($mail->send()) {
        echo json_encode(array("error" => false));
        exit;
    } else {
        echo json_encode(array("error" => true, "sendError" => true));
        exit;
    }
} catch (Exception $e) {
    echo json_encode(array("error" => true, "exceptionError" => true));
    exit;
}
