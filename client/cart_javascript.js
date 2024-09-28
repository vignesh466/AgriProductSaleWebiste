document.addEventListener('DOMContentLoaded', function () {
    const cartItems = [
        { name: "Product 1", price: 100 },
        { name: "Product 2", price: 150 },
    ];

    const gstRate = 0.18;
    const packingCharge = 20;
    const deliveryCharge = 50;

    let totalProducts = cartItems.length;
    let totalPrice = cartItems.reduce((total, item) => total + item.price, 0);
    let gstAmount = totalPrice * gstRate;
    let finalAmount = totalPrice + gstAmount + packingCharge + deliveryCharge;

    document.getElementById('cart-items').innerHTML = cartItems.map(item => `<p>${item.name}: $${item.price}</p>`).join('');
    document.getElementById('total-products').textContent = `Total Products: ${totalProducts}`;
    document.getElementById('total-price').textContent = `Total Price: $${totalPrice.toFixed(2)}`;
    document.getElementById('gst').textContent = `GST: $${gstAmount.toFixed(2)}`;
    document.getElementById('packing').textContent = `Packing Charge: $${packingCharge.toFixed(2)}`;
    document.getElementById('delivery').textContent = `Delivery Charge: $${deliveryCharge.toFixed(2)}`;
    document.getElementById('final-amount').textContent = `Final Amount: $${finalAmount.toFixed(2)}`;

    const buyButton = document.getElementById('buy-button');
    const paymentModal = document.getElementById('payment-modal');
    const upiModal = document.getElementById('upi-modal');
    const closeButtons = document.querySelectorAll('.close-button');
    const upiButton = document.getElementById('upi-button');
    const paymentConfirmedButton = document.getElementById('payment-confirmed');

    buyButton.addEventListener('click', () => {
        paymentModal.style.display = 'flex';
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            paymentModal.style.display = 'none';
            upiModal.style.display = 'none';
        });
    });

    upiButton.addEventListener('click', () => {
        paymentModal.style.display = 'none';
        upiModal.style.display = 'flex';
    });

    paymentConfirmedButton.addEventListener('click', () => {
        upiModal.innerHTML = '<h2>Payment Confirmed</h2><div class="tick-mark">&#10004;</div>';
    });
});
