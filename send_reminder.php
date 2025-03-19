<?php
require 'db.php'; // Подключение к базе
function sendReminderEmail($username, $email) {
    $subject = "Friendly Reminder: Complete Your First Top-Up";

    $message = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Friendly Reminder</title>
     <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            background-color: #e5e5e5;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
        }
        .email-header {
            padding: 20px;
            background-color: #080808;
        }
        .email-header img {
            max-width: 150px;
        }
        .email-content {
            padding: 30px;
            color: #1d1d1d;
            font-size: 16px;
            line-height: 1.6;
        }
        .email-content h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .email-button {
            display: inline-block;
            margin: 20px auto;
            padding: 12px 25px;
            background-color: #07B218;
            color: #ffffff !important;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .email-footer {
            background-color: #ececec;
            color: #777;
            text-align: center;
            padding: 15px;
            font-size: 14px;
        }
        .email-footer a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>
    <body>
     <div class="email-container">
        <div class="email-header">
            <img src="https://izipay.me/images/logo.png" alt="Your Logo">
        </div>
        <div class="email-content">
        <p>Dear ' . htmlspecialchars($username) . ',</p>
        <p>At IZI Pay, we strive to provide the best possible service to all our clients. To ensure that our cards remain active and in use, we kindly remind you to top up your non-KYC card with the minimum required amount, as per our link <a href="privacy.policy.html">privacy policy</a>.</p>
        <p>If you currently do not plan to use your card, we completely understand! In that case, please notify us via email so we can temporarily deactivate your account. If we do not hear from you, your account will be deactivated automatically in 7 days.</p>
        <p>Whenever you\'re ready to use our services again, you’re always welcome to <a href="register.php">register a new account</a>.</p>
        <p>Thank you for your understanding and cooperation.</p>
        <p>Sincerely,</p>
        <p>The IZI Pay Team</p>
         </div>
        <div class="email-footer">
            <p>If you did not request this, please ignore this email.</p>
            <p>For support, contact us at <a href="mailto:support@izipay.me">support@izipay.me</a></p>
        </div>
    </div>
    </body>
    </html>';

    // Заголовки для отправки HTML-письма
    $headers = "From: support@izipay.me\r\n";
    $headers .= "Reply-To: support@izipay.me\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Отправка письма
    if (mail($email, $subject, $message, $headers)) {
        return true; // Письмо успешно отправлено
    } else {
        return false; // Ошибка отправки письма
    }
}
?>
