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
    $wallet_address = $_POST['wallet-address'];

    // Проверяем, что адрес кошелька не пустой
    if (!empty($wallet_address)) {
        // SQL запрос для обновления адреса кошелька пользователя
        $sql = "UPDATE users SET wallet_address = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $wallet_address, $user_id);

        // Выполняем запрос
        if ($stmt->execute()) {
            // Устанавливаем сессионное сообщение об успехе
            $_SESSION['message'] = "Wallet address has been successfully saved!";
        } else {
            // В случае ошибки
            $_SESSION['error'] = "Error updating wallet address. Please try again.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Please enter a valid wallet address.";
    }
}

$conn->close();

// Перенаправление обратно на страницу, где будет отображено сообщение
header("Location: top_up.php");
exit();
?>
