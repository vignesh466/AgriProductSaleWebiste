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

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $sql = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    $sql = "SELECT * FROM cart";
    $result = $conn->query($sql);
    $total = 0;
    while($row = $result->fetch_assoc()) {
        $total += floatval($row["product_price"]);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Agri-Products</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            background: white;
        }

        .container {
            width: 70%;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
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

        .order-info {
            text-align: right;
            margin-bottom: 20px;
        }

        .payment-method {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Invoice - Agri-Products</h1>
        </header>
        <div class="order-info">
            <h2>Order ID: <?php echo $order_id; ?></h2>
            <h2>Order Date: <?php echo date("Y-m-d"); ?></h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["product_name"]) . "</td>";
                    echo "<td>$" . htmlspecialchars($row["product_price"]) . "</td>";
                    echo "</tr>";
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
        <div class="payment-method">
            <h2>Payment Method: <?php echo $order['payment_method']; ?></h2>
            <?php if ($order['payment_method'] == 'Gpay'): ?>
                <img src="<?php echo $order['payment_screenshot']; ?>" alt="Gpay Screenshot">
            <?php endif; ?>
        </div>
        <div class="order-info">
            <h2>Name: <?php echo $order['name']; ?></h2>
            <h2>Mobile: <?php echo $order['mobile']; ?></h2>
            <h2>Address: <?php echo $order['address']; ?></h2>
        </div>
    </div>
</body>
</html>