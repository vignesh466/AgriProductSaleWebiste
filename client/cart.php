<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "agri";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart items
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Agri-Products</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, rgba(215, 240, 215, 0.8), rgba(45, 255, 119, 0.8));
        }

        header {
            background: #000000;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
        }

        main {
            width: 70%;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1, h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .checkout-button {
            display: inline-block;
            background-color: #28A745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .checkout-button:hover {
            background-color: #218838;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Your Cart</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["product_name"]) . "</td>";
                        echo "<td>$" . htmlspecialchars($row["product_price"]) . "</td>";
                        echo "</tr>";
                        $total += floatval($row["product_price"]);
                    }
                } else {
                    echo "<tr><td colspan='2'>Your cart is empty</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </tfoot>
        </table>
        <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
    </main>
    <footer>
        <p>&copy; 2024 Agri-Products</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>