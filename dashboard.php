<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

// Получаем ID пользователя из сессии
$user_id = $_SESSION['user_id'];

// SQL запрос для получения данных пользователя
$sql = "SELECT username, email, balance, card_id FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $balance, $card_id);
$stmt->fetch();
$stmt->close();

// Проверка на существование и правильность баланса
if (!isset($balance) || !is_numeric($balance)) {
    $balance = 0;  // Если баланс пустой или не числовой, установим его в 0
}

// Список карт и их изображений для отображения на дашборде
$cards = [
    1 => 'images/metalbluecard.png',
    2 => 'images/metalredcard.png',
    3 => 'images/metalgreencard.png',
    4 => 'images/metalblackcard.png',
    5 => 'images/metalwhitecard.png'
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | IZI Pay</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <style>
        /* Позиционирование email в правом верхнем углу */
        .user-email-container {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #07B218;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Навигация -->
        <nav class="navbar">
            <div class="navbar-logo">
                <a href="index.html"><img src="images/logo.png" alt="IZI Pay Logo" class="logo"></a>
            </div>
            <ul class="navbar-menu">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Контент -->
        <div class="dashboard-content">
            <!-- Приветствие и баланс -->
            <div class="user-info">
                <div class="balance">
                    <h2>Your Balance</h2>
                    <div class="balance-amount"><?php echo "$" . number_format($balance, 2); ?></div>
                </div>
            </div>

            <!-- Карта -->
            <div class="card">
                <div class="card-info">
                    <?php if ($card_id && isset($cards[$card_id])): ?>
                        <img src="<?php echo $cards[$card_id]; ?>" alt="Your Card" class="card-image">
                    <?php else: ?>
                        <p>You have not selected a card yet.</p>
                    <?php endif; ?>
                    <p>**** ** ** 1234</p>
                    <div class="card-actions">
                        <a href="top_up.php" class="button">Top up</a>
                        <button class="button">Transfer</button>
                        <button class="button">Transactions</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Email пользователя под навигацией -->
    <div class="user-email-container">
            <span class="user-email"><?php echo $email; ?></span>
        </div>
    </div>
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/67b314a8d93d10191041466d/1ik9ohcjf';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>
</html>
