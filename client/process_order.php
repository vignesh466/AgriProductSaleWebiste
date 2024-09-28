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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $total_amount = $_POST['total_amount'];

    $payment_screenshot = null;
    if ($payment_method == 'Gpay' && isset($_FILES['screenshot'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["screenshot"]["name"]);
        if (move_uploaded_file($_FILES["screenshot"]["tmp_name"], $target_file)) {
            $payment_screenshot = $target_file;
        }
    }

    $sql = "INSERT INTO orders (name, mobile, address, payment_method, total_amount, payment_screenshot) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssds", $name, $mobile, $address, $payment_method, $total_amount, $payment_screenshot);

    if ($stmt->execute()) {
        // Clear the cart
    

        // Generate invoice
        header('Location: invoice.php?order_id=' . $stmt->insert_id);
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>