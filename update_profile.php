<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

// Получаем ID пользователя из сессии
$user_id = $_SESSION['user_id'];

// Проверяем, что форма была отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $full_name = $_POST['full-name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $wallet_address = $_POST['wallet-address']; // Получаем адрес кошелька

    // SQL запрос для обновления данных пользователя
    $sql = "UPDATE users SET full_name = ?, email = ?, phone = ?, wallet_address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $full_name, $email, $phone, $wallet_address, $user_id);

    // Выполняем запрос
    if ($stmt->execute()) {
        // Если данные успешно обновлены, редиректим на страницу профиля с сообщением об успешном обновлении
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } else {
        // В случае ошибки
        $_SESSION['error'] = "Error updating profile. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>
