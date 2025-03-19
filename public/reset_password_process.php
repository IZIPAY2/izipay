<?php
session_start();
require 'db.php';

// Проверяем, что запрос был отправлен методом POST и что токен передан
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'])) {
    $token = $_POST['token']; // Токен из формы
    $password = $_POST['password']; // Новый пароль
    $confirm_password = $_POST['confirm_password']; // Подтверждение пароля

    // Проверка на совпадение паролей
    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Error: Passwords do not match!";
        header("Location: reset_password.php?token=" . $token);  // Перенаправляем на страницу сброса
        exit;
    }

    // Проверка на пустые поля
    if (empty($password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "Error: All fields are required!";
        header("Location: reset_password.php?token=" . $token);
        exit;
    }

    // Проверяем, существует ли токен в базе данных
    $sql = "SELECT id FROM users WHERE password_reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Токен найден в базе данных
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();

        // Хешируем новый пароль
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Обновляем пароль и очищаем токен
        $update_sql = "UPDATE users SET password = ?, password_reset_token = NULL WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $hashed_password, $id);

        if ($update_stmt->execute()) {
            // Если пароль успешно обновлен
            $_SESSION['success_message'] = "Your password has been successfully reset.";
            header("Location: login.php"); // Перенаправляем на страницу входа
            exit;
        } else {
            // Ошибка при обновлении пароля
            $_SESSION['error_message'] = "Error updating password. Please try again later.";
            header("Location: reset_password.php?token=" . $token);
            exit;
        }
    } else {
        // Токен не найден в базе данных
        $_SESSION['error_message'] = "Invalid or expired token.";
        header("Location: forgot_password.php");
        exit;
    }
} else {
    // Если токен не передан
    $_SESSION['error_message'] = "No token provided.";
    header("Location: forgot_password.php");
    exit;
}
?>
