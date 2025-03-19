<?php
session_start();
require 'db.php'; // Подключение к базе данных

$success_message = "";
$error_message = "";

// Проверка, был ли отправлен верификационный код
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verification_code = trim($_POST['verification_code']);

    if (empty($verification_code)) {
        $error_message = "Please enter the verification code.";
    } else {
        // Проверка кода в базе данных
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
                            // Перенаправление на страницу входа после успешной верификации
                            header("Location: login.php");
                            exit();
                        } else {
                            $error_message = "Error updating verification status.";
                        }
                    }
                } else {
                    $error_message = "Your account is already verified.";
                }
            } else {
                $error_message = "Invalid verification code. Please try again.";
            }

            $stmt->close();
        } else {
            $error_message = "Database error.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Черный фон */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff; /* Белый текст */
        }

        .verification-container {
            background-color: #333; /* Темный фон для бокса */
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .verification-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #fff;
        }

        .verification-container input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #444; /* Темный фон для инпутов */
            color: #fff;
        }

        .verification-container button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .verification-container button:hover {
            background-color:#07B218;
        }

        .notification {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="verification-container">
    <h1>Enter Verification Code</h1>

    <?php if ($success_message): ?>
        <div class="notification success">
            <p><?php echo $success_message; ?></p>
        </div>
    <?php elseif ($error_message): ?>
        <div class="notification error">
            <p><?php echo $error_message; ?></p>
        </div>
    <?php endif; ?>

    <form action="verify_code.php" method="POST">
        <input type="text" name="verification_code" placeholder="Enter your verification code" required>
        <button type="submit">Verify Code</button>
    </form>

    <p>If you didn’t receive the verification code, <a href="resend_code.php" style="color: #28a745;">click here</a> to resend it.</p>
</div>

</body>
</html>
