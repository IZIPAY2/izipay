<?php
session_start();
require 'db.php';

// Проверка, был ли отправлен запрос через POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Проверяем, существует ли пользователь с таким email
    $sql = "SELECT id, username FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Генерируем токен для сброса пароля
        $token = bin2hex(random_bytes(16));
        $stmt->bind_result($id, $username);
        $stmt->fetch();
        $stmt->close();

        // Сохраняем токен в базе данных
        $update_sql = "UPDATE users SET password_reset_token = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $token, $id);
        $stmt->execute();

        // Формируем ссылку для сброса пароля
        $reset_link = "http://izipay.me/reset_password.php?token=" . $token;

        // HTML-сообщение для письма
        $subject = "Password Reset Request";
        $message = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Password Reset Request</title>
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
                <h1>Password Reset Request</h1>
                <p>Hello ' . htmlspecialchars($username) . ',</p>
                <p>You have requested to reset your password. Please click the button below to reset it:</p>
                <a href="' . $reset_link . '" class="email-button">Reset Password</a>
                <p>If you did not request a password reset, please ignore this email or contact support.</p>
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
            $_SESSION['success_message'] = "A password reset link has been sent to your email. Please check your inbox within 1 minute. If you don’t see it, check your spam or junk folder.";
        } else {
            $_SESSION['error_message'] = "Error sending email. Please try again later.";
        }
    } else {
        $_SESSION['error_message'] = "No account found with that email.";
    }

    // Перенаправление на страницу с формой после отправки
    header("Location: forgot_password.php");
    exit;
}
?>
