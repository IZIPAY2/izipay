<?php
// Включаем отображение ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Подключаем базу данных
include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Проверяем, существует ли пользователь с таким email
    $sql = "SELECT id, username FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Генерация уникального токена для сброса пароля
        $token = bin2hex(random_bytes(16)); // Генерация случайного токена

        // Сохраняем токен в базе данных
        $stmt->bind_result($id, $username);
        $stmt->fetch();
        $stmt->close();
        
        $update_sql = "UPDATE users SET password_reset_token = ? WHERE email = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Отправляем письмо пользователю с ссылкой для сброса пароля
        $reset_link = "http://izipay.me/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Hello $username,\n\nPlease click the link below to reset your password:\n$reset_link";
        $headers = "From: support@izipay.me";

        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email. Please check your inbox within 1 minute. If you don’t see it, check your spam or junk folder.";
        } else {
            echo "Error sending email.";
        }
    } else {
        echo "No account found with that email address.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | IZI Pay</title>
    <link rel="stylesheet" href="css/forgot_password.css">
</head>
<body>
    <div class="logo-container">
        <a href="index.html">
            <img src="images/logo.png" alt="IZI Pay Logo" class="logo">
        </a>
    </div>

    <div class="auth-container">
        <div class="form-container">
            <h1>Forgot Password</h1>

            <!-- Выводим сообщение, если оно установлено в сессии -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <p style="color: green;"><?= $_SESSION['success_message']; ?></p>
                <?php unset($_SESSION['success_message']); // Очищаем сообщение после его отображения ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <p style="color: red;"><?= $_SESSION['error_message']; ?></p>
                <?php unset($_SESSION['error_message']); // Очищаем сообщение после его отображения ?>
            <?php endif; ?>

            <form action="forgot_password_process.php" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <button type="submit">Send Reset Link</button>

                <p>Remember your password? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>
</body>
</html>