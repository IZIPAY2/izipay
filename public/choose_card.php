<?php
session_start();

// Проверка, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db.php');
// Получаем ID пользователя из сессии
$user_id = $_SESSION['user_id'];

// Проверка, была ли уже выбрана карта
$sql = "SELECT card_id FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($card_id);
$stmt->fetch();
$stmt->close();

// Если карта уже выбрана, перенаправляем на dashboard
if ($card_id) {
    header("Location: dashboard.php");
    exit();
}

// Обработка выбора карты
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['card_id'])) {
    $card_id = $_POST['card_id'];
    $user_id = $_SESSION['user_id'];

    // Проверка, что card_id — это допустимое значение
    if (in_array($card_id, [1, 2, 3, 4, 5])) {  // Доступные ID карт от 1 до 5
        // Обновляем информацию о карте пользователя в базе данных
        $sql = "UPDATE users SET card_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $card_id, $user_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            // Если обновление прошло успешно, сохраняем выбор карты в сессию
            $_SESSION['choose_card'] = $card_id;
            $_SESSION['email_verified'] = "Card selected successfully!";
        } else {
            // Если обновление не прошло, выводим ошибку
            $_SESSION['email_verified'] = "Failed to update your card. Please try again.";
        }

        $stmt->close();
    } else {
        // Если передан недопустимый card_id
        $_SESSION['email_verified'] = "Invalid card selection!";
    }

    // Перенаправляем обратно на dashboard
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Card | IZI Pay</title>
    <link rel="stylesheet" href="css/choose_card.css"> <!-- Подключаем стили -->
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
    <div class="logo-container">
        <!-- Логотип с ссылкой на index.html -->
        <a href="index.html">
            <img src="images/logo.png" alt="IZI Pay Logo" class="logo">
        </a>
    </div>

    <!-- Выводим сообщение, если оно есть в сессии -->
    <?php if (isset($_SESSION['email_verified'])): ?>
        <div id="email-confirmation-message" class="confirmation-message">
            <?php echo $_SESSION['email_verified']; ?>
        </div>
        <?php unset($_SESSION['email_verified']); // Очищаем сообщение после отображения ?>
    <?php endif; ?>

    <div class="container">
        <h1>Choose Your Card</h1>
        <p>Select a card that suits you best:</p>

        <form method="POST" action="choose_card.php">
            <div class="card-selection">
                <label class="card-option">
                    <input type="radio" name="card_id" value="1" required>
                    <img src="images/card1.png" alt="Card 1" class="card-image">
                </label>

                <label class="card-option">
                    <input type="radio" name="card_id" value="2" required>
                    <img src="images/card2.png" alt="Card 2" class="card-image">
                </label>

                <label class="card-option">
                    <input type="radio" name="card_id" value="3" required>
                    <img src="images/card3.png" alt="Card 3" class="card-image">
                </label>

                <label class="card-option">
                    <input type="radio" name="card_id" value="4" required>
                    <img src="images/card4.png" alt="Card 4" class="card-image">
                </label>

                <label class="card-option">
                    <input type="radio" name="card_id" value="5" required>
                    <img src="images/card5.png" alt="Card 5" class="card-image">
                </label>
            </div>
            <button type="submit" class="submit-btn">Confirm Selection</button>
        </form>

        <!-- Ошибка, если карта не выбрана -->
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['card_id'])): ?>
            <div class="error-message">
                <p>Please select a card before submitting!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Скрипт для скрытия сообщения через 3 секунды -->
    <script>
        setTimeout(function() {
            var message = document.getElementById("email-confirmation-message");
            if (message) {
                message.style.display = "none";
            }
        }, 3000);
    </script>

    <!-- Start of Tawk.to Script -->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/67b314a8d93d10191041466d/1ik9ohcjf';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!-- End of Tawk.to Script -->

</body>
</html>
