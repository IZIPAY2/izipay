<?php
session_start(); // Запускаем сессию
require 'db.php'; // Подключение к базе
require 'send_reminder.php'; // Подключаем файл с функцией sendReminderEmail

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Проверяем, что пароли совпадают
    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Error: Passwords do not match!";
        header("Location: register.php");
        exit;
    }

    // Проверяем минимальные требования к паролю
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password)) {
        $_SESSION['error_message'] = "Error: Password must be at least 8 characters long, contain at least one uppercase letter and one number!";
        header("Location: register.php");
        exit;
    }
    
    // Проверка на пустые поля
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Error: All fields are required!";
        header("Location: register.php");
        exit;
    }

    // Проверка на существование email в базе данных
    $email_check_sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($email_check_sql);
    if ($stmt === false) {
        die("Error preparing email check query: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = "This email is already registered!";
        $stmt->close();
        header("Location: register.php");
        exit;
    }

    // Хешируем пароль
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Генерируем уникальный код для подтверждения email
    $verification_code = bin2hex(random_bytes(16));

    // SQL запрос для вставки данных в таблицу
    $sql = "INSERT INTO users (username, email, password, verification_code, is_verified) VALUES (?, ?, ?, ?, 0)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $verification_code);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();

            // Формируем сообщение для верификации
            $verification_message = "Your verification code is: " . $verification_code;

            // Формируем HTML-сообщение для верификации
            $email_content = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; color: #333333; }
        .email-container { width: 100%; max-width: 600px; margin: 40px auto; background-color: #e5e5e5; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); overflow: hidden; text-align: center; }
        .email-header { padding: 20px; background-color: #080808; }
        .email-header img { max-width: 150px; }
        .email-content { padding: 30px; color: #1d1d1d; font-size: 16px; line-height: 1.6; }
        .email-content h1 { font-size: 24px; margin-bottom: 15px; }
        .email-footer { background-color: #ececec; color: #777; text-align: center; padding: 15px; font-size: 14px; }
        .email-footer a { color: #28a745; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://izipay.me/images/logo.png" alt="Your Logo">
        </div>
        <div class="email-content">
            <h1>Email Verification for IZI Pay</h1>
            <p>Your verification code is: <strong>' . $verification_code . '</strong></p>
            <p>Please enter this code in the verification field on the website.</p>
        </div>
        <div class="email-footer">
            <p>If you did not request this, please ignore this email.</p>
            <p>For support, contact us at <a href="mailto:support@izipay.me">support@izipay.me</a></p>
        </div>
    </div>
</body>
</html>
            ';

            // Заголовки для верификационного письма
            $subject = "Email Verification for IZI Pay";
            $headers = "From: support@izipay.me\r\n";
            $headers .= "Reply-To: support@izipay.me\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // Отправляем верификационное письмо
            if (mail($email, $subject, $email_content, $headers)) {
                // Устанавливаем сообщение для пользователя
                $_SESSION['success_message'] = "Registration successful! Please check your email within 1 minute to verify your account. If you don’t see it, please check your spam or junk folder.";
                header("Location: verify_code.php?email=" . urlencode($email));
                exit;
            } else {
                $_SESSION['error_message'] = "Registration successful, but failed to send verification email.";
            }


            // Отправляем письмо-напоминание в фоне (результат не выводится пользователю)
            sendReminderEmail($username, $email);

        } else {
            $_SESSION['error_message'] = "Database error: " . $stmt->error;
        }
    } else {
        $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | IZI Pay</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
    <div class="logo-container">
        <a href="index.html">
            <img src="images/logo.png" alt="IZI Pay Logo" class="logo">
        </a>
    </div>

    <div class="auth-container">
        <div class="form-container">
            <h1>Create Your Account</h1>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="success-message">
                    <p><?php echo $_SESSION['success_message']; ?></p>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php elseif (isset($_SESSION['error_message'])): ?>
                <div class="error-message">
                    <p><?php echo $_SESSION['error_message']; ?></p>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                
                                <!-- Чекбокс для согласия с условиями -->
                <div class="checkbox-container">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        I agree to the <a href="terms-coditions.html" target="_blank">Terms & Conditions</a>
                        and <a href="privacy-policy.html" target="_blank">Privacy Policy</a>
                    </label>
                </div>

                <!-- Чекбокс для подписки на email-рассылку -->
                <div class="checkbox-container">
                    <input type="checkbox" id="newsletter" name="newsletter">
                    <label for="newsletter">
                        I'd like to stay up to date with IZI Pay over email
                    </label>
                </div>

                <button type="submit">Register</button>

                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>
</body>
</html>
