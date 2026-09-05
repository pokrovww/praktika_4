<?php
// send_mail.php

// 1. Получаем данные из формы и защищаемся от XSS
$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$subject = htmlspecialchars(trim($_POST['subject']));
$message = htmlspecialchars(trim($_POST['message']));

// 2. Валидация на стороне сервера
if (empty($name) || empty($email) || empty($message)) {
    echo "error";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "error";
    exit;
}

// 3. Формируем письмо
$to = "your_email@example.com"; // ⚠️ ЗАМЕНИ НА СВОЮ ПОЧТУ, КУДА ПРИДУТ ПИСЬМА
$email_subject = "Новое сообщение с сайта Центра Кисти: " . $subject;
$email_body = "
<html>
<head>
    <title>Сообщение с сайта</title>
</head>
<body>
    <h2>Новое обращение</h2>
    <p><strong>Имя:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Тема:</strong> $subject</p>
    <p><strong>Сообщение:</strong><br>$message</p>
</body>
</html>
";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: no-reply@centrkisti.ru" . "\r\n"; // Email отправителя
$headers .= "Reply-To: $email" . "\r\n";

// 4. Отправляем письмо
if (mail($to, $email_subject, $email_body, $headers)) {
    echo "success"; // Возвращаем успех для JS
} else {
    echo "error";   // Возвращаем ошибку
}
?>