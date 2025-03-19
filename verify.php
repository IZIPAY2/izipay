<?php
require 'db.php'; // Подключение к базе

// Получаем код подтверждения из URL или формы
$verification_code = $_POST['verification_code'] ?? ($_GET['code'] ?? null);

$success_message = ""; // Сообщение об успехе

if ($verification_code) {
    // Проверка на наличие кода в базе
    $sql = "SELECT id, is_verified FROM users WHERE verification_code = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $verification_code);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $is_verified);
            $stmt->fetch();

            // Если пользователь еще не подтвержден
            if ($is_verified == 0) {
                $update_sql = "UPDATE users SET is_verified = 1 WHERE id = ?";
                if ($update_stmt = $conn->prepare($update_sql)) {
                    $update_stmt->bind_param("i", $user_id);
                    if ($update_stmt->execute()) {
                        $success_message = "Your email has been successfully verified!";
                    }
                }
            } else {
                $success_message = "Your account is already verified.";
            }
        } else {
            $success_message = "Invalid verification code.";
        }

        $stmt->close();
    } else {
        $success_message = "Database error.";
    }
} else {
    $success_message = "No verification code provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        .notification {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            display: none;
        }
    </style>
    <script>
        window.onload = function() {
            const message = "<?php echo $success_message; ?>";
            if (message) {
                const notification = document.querySelector('.notification');
                notification.innerText = message;
                notification.style.display = 'block';

                // Через 3 секунды перенаправляем на login.php
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 3000);
            }
        };
    </script>
</head>
<body>
    <div class="notification"></div>
</body>
</html>
