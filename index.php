<?php
/*
    Crypto Price Alert Dashboard
    ----------------------------
    This PHP app fetches real-time cryptocurrency prices from CoinGecko API.
    Users can:
    - View live prices of popular cryptocurrencies
    - Set price alerts for specific coins
    - Get a notification if the price crosses the alert threshold
*/

// --------------------
// 1. Define Coins to Track
// --------------------
$coins = ['bitcoin', 'ethereum', 'dogecoin']; // you can add more coins as needed
// --------------------
// 2. Fetch Crypto Prices from API
// --------------------
// CoinGecko public API URL
$apiUrl = 'https://api.coingecko.com/api/v3/simple/price?ids=' . implode(',', $coins) . '&vs_currencies=usd';

// Use file_get_contents to get API data
$apiResponse = file_get_contents($apiUrl);
$prices = json_decode($apiResponse, true); // Decode JSON into PHP array

// --------------------
// 3. Handle Price Alert Submission
// --------------------
$alertMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coin']) && isset($_POST['price'])) {
    $alertCoin = $_POST['coin'];
    $alertPrice = floatval($_POST['price']);

    // Check if current price crosses the alert
    if (isset($prices[$alertCoin]['usd'])) {
        $currentPrice = $prices[$alertCoin]['usd'];
        if ($currentPrice >= $alertPrice) {
            $alertMessage = "🚨 ALERT! {$alertCoin} price has reached \${$currentPrice}, crossing your target of \${$alertPrice}!";
        } else {
            $alertMessage = "{$alertCoin} price is \${$currentPrice}. Your alert is set at \${$alertPrice}.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crypto Price Alert Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background: #fff; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        form { margin-top: 20px; background: #fff; padding: 20px; border-radius: 8px; }
        input, select, button { padding: 10px; margin: 5px 0; width: 100%; }
        button { cursor: pointer; background: #4CAF50; color: white; border: none; border-radius: 5px; }
        .alert { padding: 15px; margin: 15px 0; border-radius: 8px; background: #ffecb3; color: #665200; }
    </style>
</head>
<body>
    <h1>Crypto Price Alert Dashboard</h1>

    <!-- --------------------
         Display Live Prices
    -------------------- -->
    <table>
        <tr>
            <th>Coin</th>
            <th>Price (USD)</th>
        </tr>
        <?php foreach ($coins as $coin): ?>
        <tr>
            <td><?php echo ucfirst($coin); ?></td>
            <td><?php echo isset($prices[$coin]['usd']) ? '$' . $prices[$coin]['usd'] : 'N/A'; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- --------------------
         Price Alert Form
    -------------------- -->
    <form method="POST">
        <h2>Set a Price Alert</h2>
        <select name="coin" required>
            <?php foreach ($coins as $coin): ?>
                <option value="<?php echo $coin; ?>"><?php echo ucfirst($coin); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" step="0.01" name="price" placeholder="Target Price in USD" required>
        <button type="submit">Set Alert</button>
    </form>

    <!-- Display Alert Message -->
    <?php if ($alertMessage): ?>
        <div class="alert"><?php echo $alertMessage; ?></div>
    <?php endif; ?>
</body>
</html>
