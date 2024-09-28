<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="sign.css">
</head>
<body>
    <div class="container" id="defaultOpen">
        <div class="signin-box">
            <h2>Sign In</h2>
            <form method="post" action="">
                <div class="input-group">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit">Sign In</button>
                <div class="footer-links">
                    <a href="#">Forgot Password?</a>
                    <a href="Login_pages.html">Create an Account</a>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";    // Replace with your MySQL username
        $password = "";    // Replace with your MySQL password
        $dbname = "agri";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Function to hash password
        function hash_password($password) {
            return password_hash($password, PASSWORD_BCRYPT);
        }

        // Retrieve and hash the password
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed_password = hash_password($password);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ss", $email, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
