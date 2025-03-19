<?php
session_start();
require 'db.php';

// Проверяем, существует ли токен в URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Проверяем, существует ли токен в базе данных
    $sql = "SELECT id, username FROM users WHERE password_reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Токен найден в базе данных
        $stmt->bind_result($id, $username);
        $stmt->fetch();
        $_SESSION['token'] = $token; // Сохраняем токен в сессии для последующего использования
        $stmt->close();
    } else {
        // Токен не найден, выводим ошибку
        $_SESSION['error_message'] = "Invalid or expired token.";
        header("Location: forgot_password.php");
        exit;
    }
} else {
    // Токен не передан в URL
    $_SESSION['error_message'] = "No token provided.";
    header("Location: forgot_password.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | IZI Pay</title>
    <link rel="stylesheet" href="css/reset_password.css">
</head>
<body>
    <div class="logo-container">
        <a href="index.html">
            <img src="images/logo.png" alt="IZI Pay Logo" class="logo">
        </a>
    </div>

    <div class="auth-container">
        <div class="form-container">
            <h1>Reset Password</h1>
            
            <?php
            if (isset($_SESSION['error_message'])) {
                echo "<p class='error-message'>" . $_SESSION['error_message'] . "</p>";
                unset($_SESSION['error_message']);
            }
            ?>

            <form action="reset_password_process.php" method="POST">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <button type="submit">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>
