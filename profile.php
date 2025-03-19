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
$sql = "SELECT full_name, email, phone, wallet_address FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $phone, $wallet_address);
$stmt->fetch(); // Получаем данные из базы
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | IZI Pay</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
    <div class="navbar">
        <div class="navbar-logo">
            <a href="index.html">
                <img src="images/logo.png" alt="IZI Pay Logo" class="logo">
            </a>
        </div>
        <ul class="navbar-menu">
            <li><a href="dashboard.php">Account</a></li>
            <li><a href="index.html">Logout</a></li>
        </ul>
    </div>

    <div class="profile-container">
        <div class="profile-header">
            <h1>Profile</h1>
            <p>Manage your personal information</p>
        </div>
        
        <div class="profile-details">
            <h2>Personal Information</h2>
            <!-- Форма для обновления профиля -->
            <form action="update_profile.php" method="POST">
                <div class="profile-field">
                    <label for="full-name">Full Name</label>
                    <input type="text" id="full-name" name="full-name" value="<?php echo $full_name; ?>" required>
                </div>
                <div class="profile-field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="profile-field">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                </div>
                <div class="profile-field">
                    <label for="wallet-address">Wallet Address</label>
                    <input type="text" id="wallet-address" name="wallet-address" value="<?php echo $wallet_address; ?>" required>
                </div>
                <button type="submit">Update Profile</button>
            </form>
        </div>

        <div class="profile-password">
            <h2>Change Password</h2>

            <!-- Выводим сообщения об ошибке или успешном обновлении пароля -->
            <?php if (isset($_SESSION['password_update_error'])): ?>
                <div class="error-message">
                    <?php echo $_SESSION['password_update_error']; ?>
                </div>
            <?php unset($_SESSION['password_update_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['password_update_success'])): ?>
                <div class="success-message">
                    <?php echo $_SESSION['password_update_success']; ?>
                </div>
            <?php unset($_SESSION['password_update_success']); ?>
            <?php endif; ?>

            <form action="change_password.php" method="POST">
                <div class="profile-field">
                    <label for="current-password">Current Password</label>
                    <input type="password" id="current-password" name="current-password" required>
                </div>
                <div class="profile-field">
                    <label for="new-password">New Password</label>
                    <input type="password" id="new-password" name="new-password" required>
                </div>
                <div class="profile-field">
                    <label for="confirm-new-password">Confirm New Password</label>
                    <input type="password" id="confirm-new-password" name="confirm-new-password" required>
                </div>
                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>
    
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
