<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "agri_collection"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $data = $_POST;

    // Check if $data is set and contains the keys 'name' and 'price'
    if (isset($data['name']) && isset($data['price'])) {
        $productName = $conn->real_escape_string($data['name']);
        $productPrice = $conn->real_escape_string($data['price']);

        // Prepare SQL statement to insert data into the table
        $sql = "INSERT INTO cart (productName, prodduct_Price) VALUES ('$productName', '$productPrice')";

        if ($conn->query($sql) === TRUE) {
            header("Location: addtocart.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Handle the case where $data is not set or doesn't contain 'name' or 'price'
        echo "Error: Product name or price is not set.";
    }
}

// Close the connection
$conn->close();
?>
