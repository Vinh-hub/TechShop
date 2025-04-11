function fetchCartCount() {
    fetch('./giohang.php?action=getCartCount')
    .then(response => response.json())
    .then(data => {
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = data.cartCount;
        }
    })
    .catch(error => console.error('Error fetching cart count:', error));
}