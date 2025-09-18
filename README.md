# Crypto Price Alert Dashboard

A **PHP web application** that fetches **real-time cryptocurrency prices** from the [CoinGecko API](https://www.coingecko.com/en/api) and allows users to **set price alerts**. This project demonstrates **API calls, JSON handling, dynamic HTML rendering, and user interaction in PHP**.

---

## Features

- Live cryptocurrency prices for Bitcoin, Ethereum, and Dogecoin.  
- Set price alerts and get instant notifications if a target price is reached.  
- Beginner-friendly with extensive inline comments for learning PHP.  
- Fully functional dashboard without the need for a database.

---

## How It Works

1. PHP calls the CoinGecko API using `file_get_contents()`.  
2. The API response is JSON, decoded into a PHP array using `json_decode()`.  
3. Prices are displayed in a dynamically generated HTML table.  
4. Users can submit a price alert for a coin; PHP checks the current price against the target.  
5. An alert message is displayed if the price crosses the target.

---

## Installation

### Ubuntu / Linux

```bash
sudo apt update
sudo apt install apache2 php libapache2-mod-php -y
sudo mkdir /var/www/html/crypto-dashboard
cd /var/www/html/crypto-dashboard
# Place index.php here
sudo chmod -R 755 /var/www/html/crypto-dashboard
sudo systemctl start apache2
```
##open the browser at : **http://localhost/crypto-dashboard/**