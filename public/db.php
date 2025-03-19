<?php
$servername = "localhost"; // Обычно localhost, если база на том же сервере
$username = "aiknikitaizipay";
$password = "Apple2003!-Apple2003";
$dbname = "aiknikitaizipay_izipay";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>