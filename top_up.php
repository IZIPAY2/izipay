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
$sql = "SELECT wallet_address FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($wallet_address);
$stmt->fetch(); // Получаем данные из базы
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Top-Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000000;
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 500px;
            width: 90%;
            padding: 20px;
            background: #111;
            border-radius: 10px;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            color: #07B218;
            margin-bottom: 20px;
        }

        .crypto-option {
            display: flex;
            align-items: center;
            background: #222;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .crypto-option:hover {
            background: #07B218;
        }

        .crypto-option img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .wallet-address {
            margin-top: 20px;
            font-weight: bold;
            background: #222;
            padding: 15px;
            border-radius: 5px;
            display: none;
            color: #fff;
        }

        .copy-button {
            margin-left: 10px;
            padding: 5px 10px;
            background: #07B218;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .copy-button:hover {
            background: #05a115;
        }

        .transaction-section {
            display: none;
            margin-top: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: none;
            background: #222;
            color: #fff;
        }

        .confirm-button {
            margin-top: 15px;
            padding: 10px;
            background: #07B218;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .confirm-button:hover {
            background: #05a115;
        }

        .back-button {
            background: #555;
            margin-top: 10px;
        }

        .back-button:hover {
            background: #444;
        }

        @media screen and (max-width: 768px) {
            h2 {
                font-size: 1.8rem;
            }

            .container {
                max-width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Cryptocurrency</h2>

        <div class="crypto-option" onclick="showWallet('BTC')">
            <img src="https://cryptologos.cc/logos/bitcoin-btc-logo.png" alt="BTC"> Bitcoin (BTC)
        </div>
        <div class="crypto-option" onclick="showWallet('ETH')">
            <img src="https://cryptologos.cc/logos/ethereum-eth-logo.png" alt="ETH"> Ethereum (ETH)
        </div>
        <div class="crypto-option" onclick="showWallet('USDT_ERC20')">
            <img src="https://cryptologos.cc/logos/tether-usdt-logo.png" alt="USDT"> Tether (ERC20)
        </div>
        <div class="crypto-option" onclick="showWallet('USDT_TRC20')">
            <img src="https://cryptologos.cc/logos/tether-usdt-logo.png" alt="USDT"> Tether (TRC20)
        </div>
        <div class="crypto-option" onclick="showWallet('USDC')">
            <img src="https://cryptologos.cc/logos/usd-coin-usdc-logo.png" alt="USDC"> USDC (Ethereum)
        </div>

        <div id="walletAddress" class="wallet-address">
            <span id="walletText"></span>
            <button id="copyButton" class="copy-button" onclick="copyAddress()">Copy</button>
        </div>

<div class="profile-field">
    <label for="wallet-address">Please enter your wallet address.</label>
    <form action="upload.php" method="POST">
        <input type="text" id="wallet-address" name="wallet-address" value="<?php echo $wallet_address; ?>" required>
        <button class="confirm-button" type="submit">Submit</button>
    </form>
</div>

                

        <button onclick="window.location.href = 'dashboard.php'" class="back-button">Back to Dashboard</button>
    </div>

    <script>
        function showWallet(crypto) {
            var walletDiv = document.getElementById("walletAddress");
            var walletText = document.getElementById("walletText");
            var transactionDiv = document.getElementById("transactionSection");

            var wallets = {
                "BTC": "bc1qvjn8epw4l8hqm4y0rqy0dvjst279m3v7u9ru47",
                "ETH": "0xB1A08E801e3e79C0dEf1521263D7D54c6745D68c",
                "USDT_ERC20": "0xB1A08E801e3e79C0dEf1521263D7D54c6745D68c",
                "USDT_TRC20": "TYYF1FVn6vpEbq83s9QxCAXnkCzCDuqDSZ",
                "USDC": "0xB1A08E801e3e79C0dEf1521263D7D54c6745D68c"
            };

            walletText.textContent = "Top-Up Address: " + wallets[crypto];
            walletDiv.style.display = "block";
            transactionDiv.style.display = "block";
        }

        function copyAddress() {
            var walletText = document.getElementById("walletText").textContent.replace("Top-Up Address: ", "");
            navigator.clipboard.writeText(walletText);
            alert("Address copied to clipboard!");
        }

    </script>
</body>
</html>
