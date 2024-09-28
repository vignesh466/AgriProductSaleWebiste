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
    <title>Checkout - Agri-Products</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, rgba(215, 240, 215, 0.8), rgba(45, 255, 119, 0.8));
        }

        .container {
            width: 70%;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        header {
            background: #000000;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
        }

        h1, h2, h3 {
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

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="tel"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        #gpay-qr {
            margin-top: 15px;
        }

        #gpay-qr img {
            max-width: 200px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #28A745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
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
        <h1>Checkout</h1>
    </header>
    <div class="container">
        <h2>Order Summary</h2>
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
        
        <h2>Order Information</h2>
        <form action="process_order.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="mobile">Mobile:</label>
            <input type="tel" id="mobile" name="mobile" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <h3>Payment Method:</h3>
            <div>
                <input type="radio" id="cod" name="payment_method" value="Cash on Delivery" checked>
                <label for="cod">Cash on Delivery</label>
            </div>
            <div>
                <input type="radio" id="gpay" name="payment_method" value="Gpay">
                <label for="gpay">Gpay</label>
            </div>

            <div id="gpay-qr" style="display: none;">
                <img src="pay.jpg" alt="Gpay QR Code"><br>
                <input type="file" id="screenshot" name="screenshot" accept="image/*">
            </div>

            <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
            <input type="submit" value="Place Order">
        </form>
    </div>
                

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gpayRadio = document.getElementById('gpay');
            const gpayQR = document.getElementById('gpay-qr');

            gpayRadio.addEventListener('change', function() {
                gpayQR.style.display = this.checked ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>