<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seeds - Agri-Products</title>
    <link rel="stylesheet" href="sparate.css">
</head>
<body>
    <div >
        <img src="seedbanner.png" alt="" class="seeb">
    </div>
    <main>
        <div class="product-list">
            <!-- Example Product Item -->
            <div class="product-item container">
                <div class="inner-container">
                    <img src="images/seed1.jpg" alt="Seed 1">
                    <h2>Seed 1</h2>
                    <p>Price: $10.00</p>
                </div>

                <!-- <form action="test.php">
                    <input type="submit" value="Add to Cart">
                </form> -->

                <?php
                    for($i=0; $i<10; $i++) {
                        echo '<div class="inner-container">';
                        echo '<img src="images/se$i.jpg" alt="Seed 1">';
                        echo '<h2>Seed 1</h2>';
                        echo '<p>Price: $10.00</p>';
                        echo '</div>';
                    }
                ?>


                <!-- <p>Description: High-quality seed for your farm.</p> -->
            </div>

            <!-- Repeat for more items -->
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Agri-Products</p>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.add-to-cart');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const productItem = this.closest('.product-item');
            const productId = productItem.getAttribute('data-id');
            const productName = productItem.querySelector('h2').innerText;
            const productPrice = productItem.querySelector('p').innerText.replace('Price: $', '');

            const data = {
                id: productId,
                name: productName,
                price: productPrice
            };

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product added to cart successfully!');
                } else {
                    alert('Failed to add product to cart.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

    </script>
</body>
</html>
