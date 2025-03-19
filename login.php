<?php
// Включаем отображение ошибок (уберите в продакшене)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Подключаем базу данных
include('db.php');
session_start(); // Запускаем сессию для хранения данных о пользователе

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-Type: application/json"); // Указываем, что ответ будет в JSON

    // Проверяем, пришли ли данные
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo json_encode(["status" => "error", "message" => "Missing email or password"]);
        exit();
    }

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Проверяем, не пустые ли данные
    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
        exit();
    }

    // Подготовленный SQL-запрос для предотвращения SQL-инъекций
    $sql = "SELECT id, username, password, card_id, is_verified FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password, $card_id, $is_verified);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        // Если пользователь найден и пароли совпадают, проверим статус верификации
        if ($is_verified == 0) {
            // Если пользователь не верифицирован, отправляем сообщение об ошибке
            echo json_encode(["status" => "error", "message" => "Please verify your email address first"]);
            exit();
        }

        // Если пользователь верифицирован, создаем сессию
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;

        // Отправляем JSON-ответ
        echo json_encode(["status" => "success", "message" => "Login successful", "redirect" => $card_id ? "dashboard.php" : "choose_card.php"]);
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
        exit();
    }
    
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | IZI Pay</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
    <!-- Логотип -->
    <div class="logo-container">
        <a href="index.html">
            <img src="images/logo.png" alt="IZI Pay Logo" class="logo">
        </a>
    </div>

    <!-- Форма входа -->
    <div class="auth-container">
        <div class="form-container">
            <h1>Login to Your Account</h1>
            <form id="loginForm">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
                <p><a href="forgot_password.php">Forgot your password?</a></p>
                <p id="errorMessage" style="color:red;"></p>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            fetch("login.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = data.redirect;
                } else {
                    document.getElementById("errorMessage").textContent = data.message;
                }
            })
            .catch(error => console.error("Error:", error));
        });
    </script>
</body>
</html>
