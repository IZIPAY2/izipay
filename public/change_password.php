<?php
session_start();

// Подключаем базу данных
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_new_password = $_POST['confirm-new-password'];

    // Проверка, что новый пароль и подтверждение совпадают
    if ($new_password !== $confirm_new_password) {
        $_SESSION['password_update_error'] = "New passwords do not match.";
        header("Location: profile.php");
        exit();
    }

    // Получаем текущий пароль из базы данных
    $sql = "SELECT password FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Проверка текущего пароля
    if (!password_verify($current_password, $hashed_password)) {
        $_SESSION['password_update_error'] = "Current password is incorrect.";
        header("Location: profile.php");
        exit();
    }

    // Хэшируем новый пароль
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Обновляем пароль в базе данных
    $sql = "UPDATE users SET password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_hashed_password, $user_id);
    if ($stmt->execute()) {
        $_SESSION['password_update_success'] = "Password updated successfully.";
    } else {
        $_SESSION['password_update_error'] = "Failed to update password. Please try again.";
    }
    $stmt->close();

    header("Location: profile.php");
    exit();
}

$conn->close();
?>
