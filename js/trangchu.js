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
document.addEventListener('DOMContentLoaded', () => {
    // Xử lý nút tìm kiếm trong header
    const btnSearch = document.querySelector('.header_search-button');
    if (btnSearch) {
        btnSearch.addEventListener('click', () => {
            const searchInput = document.querySelector('.header_search-input');
            if (searchInput) {
                const searchTerm = searchInput.value.trim();
                if (searchTerm) {
                    // Lấy categoryId từ URL nếu có
                    const params = new URLSearchParams(window.location.search);
                    const categoryId = params.get('categoryId') || '';
                    // Xác định đường dẫn cơ bản
                    const basePath = window.location.pathname.includes('Template/Category') ? '../' : 'Template/';
                    // Xây dựng URL với cú pháp đúng
                    const queryParams = [];
                    if (categoryId) {
                        queryParams.push(`categoryId=${categoryId}`);
                    }
                    queryParams.push(`search=${encodeURIComponent(searchTerm)}`);
                    const queryString = queryParams.length ? `?${queryParams.join('&')}` : '';
                    window.location.href = `${basePath}resultSearch.php${queryString}`;
                }
            }
        });
    }
});