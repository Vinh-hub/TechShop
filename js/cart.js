
   
    // Lấy các phần tử HTML cần thiết
    const searchInput = document.querySelector('.header_search-input');
    const searchHistoryList = document.querySelector('.header_navbar-search-history-list');
    const searchHistoryContainer = document.querySelector('.header_navbar-search-history');
    
    // Hàm cập nhật danh sách gợi ý
    function updateSuggestions(query) {
        // Xóa các gợi ý cũ
        searchHistoryList.innerHTML = '';
    
        // Nếu ô tìm kiếm trống, ẩn lịch sử tìm kiếm
        if (!query.trim()) {
            searchHistoryContainer.style.display = 'none';
            return;
        }
    
        // Tìm các sản phẩm phù hợp
        const suggestions = products.filter(product => 
            product.toLowerCase().includes(query.toLowerCase())
        );
    
        // Hiển thị gợi ý nếu có sản phẩm phù hợp
        if (suggestions.length > 0) {
            searchHistoryContainer.style.display = 'block';
            suggestions.forEach(product => {
                const listItem = document.createElement('li');
                listItem.className = 'header_navbar-search-history-item';
                listItem.innerHTML = `
                    <a href="#">
                        <i class="header_search-icon fa-solid fa-clock-rotate-left"></i>
                        ${product}
                    </a>
                `;
                searchHistoryList.appendChild(listItem);
            });
        } else {
            searchHistoryContainer.style.display = 'none';
        }
    }
    
    // // Lắng nghe sự kiện nhập dữ liệu vào ô tìm kiếm
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value;
        updateSuggestions(query);
    });
    
    
    //Đổi màu của từ trùng khớp 
        // Hàm cập nhật danh sách gợi ý với hiệu ứng bôi đậm
    function updateSuggestions(query) {
        // Xóa các gợi ý cũ
        searchHistoryList.innerHTML = '';
    
        // Nếu ô tìm kiếm trống, ẩn lịch sử tìm kiếm
        if (!query.trim()) {
            searchHistoryContainer.style.display = 'none';
            return;
        }
    
        // Tìm các sản phẩm phù hợp
        const suggestions = products.filter(product =>
            product.toLowerCase().includes(query.toLowerCase())
        );
    
        // Hiển thị gợi ý nếu có sản phẩm phù hợp
        if (suggestions.length > 0) {
            searchHistoryContainer.style.display = 'block';
            suggestions.forEach(product => {
                // Xác định vị trí phần trùng khớp
                const startIndex = product.toLowerCase().indexOf(query.toLowerCase());
                const endIndex = startIndex + query.length;
    
                // Tách sản phẩm thành các phần trước, trùng khớp, và sau
                const beforeMatch = product.slice(0, startIndex);
                const matchText = product.slice(startIndex, endIndex);
                const afterMatch = product.slice(endIndex);
    
                // Tạo danh sách gợi ý với phần trùng khớp được bôi đậm
                const listItem = document.createElement('li');
                listItem.className = 'header_navbar-search-history-item';
                listItem.innerHTML = `
                    <a href="#">
                        <i class="header_search-icon fa-solid fa-clock-rotate-left"></i>
                        ${beforeMatch}<span class="highlight">${matchText}</span>${afterMatch}
                    </a>
                `;
                searchHistoryList.appendChild(listItem);
            });
        } else {
            searchHistoryContainer.style.display = 'none';
        }
    }
    
    
    //  Lưu lại văn bản vừa nhập 
    
        // Lấy danh sách từ Local Storage hoặc khởi tạo mảng trống
    let searchHistory = JSON.parse(localStorage.getItem('searchHistory')) || [];
    
    // Cập nhật lịch sử tìm kiếm từ Local Storage
    // Hàm thêm tìm kiếm mới vào lịch sử và giới hạn tối đa 5 mục
    function addSearchHistory(query) {
        if (!query.trim()) return;
    
        // Tránh lưu trùng lặp
        if (!searchHistory.includes(query)) {
            searchHistory.unshift(query); // Thêm vào đầu danh sách
            if (searchHistory.length > 5) {
                searchHistory.pop(); // Giới hạn lưu tối đa 5 mục, xóa mục cuối cùng
            }
            // Lưu lại vào Local Storage
            localStorage.setItem('searchHistory', JSON.stringify(searchHistory));
        }
        renderSearchHistory();
    }
    
    // Hàm cập nhật và hiển thị lịch sử tìm kiếm
    // Hàm cập nhật và hiển thị lịch sử tìm kiếm, chỉ hiển thị tối đa 5 mục
    function renderSearchHistory() {
        searchHistoryList.innerHTML = ''; // Xóa danh sách trước khi hiển thị lại
    
        // Chỉ lấy tối đa 5 mục đầu tiên từ mảng searchHistory
        const limitedHistory = searchHistory.slice(0, 3);
    
        if (limitedHistory.length > 0) {
            searchHistoryContainer.style.display = 'block'; // Hiển thị phần lịch sử tìm kiếm
            limitedHistory.forEach(item => {
                const listItem = document.createElement('li');
                listItem.className = 'header_navbar-search-history-item';
                listItem.innerHTML = `
                    <a href="#">
                        <i class="header_search-icon fa-solid fa-clock-rotate-left"></i>
                        ${item}
                    </a>
                `;
                searchHistoryList.appendChild(listItem);
            });
        } else {
            searchHistoryContainer.style.display = 'none'; // Ẩn nếu không có lịch sử tìm kiếm
        }
    }
    
    
    
    // Hàm thêm tìm kiếm mới vào lịch sử
    function addSearchHistory(query) {
        if (!query.trim()) return;
    
        // Tránh lưu trùng lặp
        if (!searchHistory.includes(query)) {
            searchHistory.unshift(query); // Thêm vào đầu danh sách
            if (searchHistory.length > 5) {
                searchHistory.pop(); // Giới hạn lưu tối đa 5 mục
            }
            // Lưu lại vào Local Storage
            localStorage.setItem('searchHistory', JSON.stringify(searchHistory));
        }
        renderSearchHistory();
    }
    
    // Lắng nghe sự kiện khi người dùng nhấn nút "Tìm kiếm"
    const searchButton = document.querySelector('.header_search-button');
    searchButton.addEventListener('click', () => {
        const query = searchInput.value.trim();
        if (query) {
            addSearchHistory(query); // Lưu lịch sử tìm kiếm
            searchInput.value = '';  // Xóa nội dung trong ô tìm kiếm
        }
    });
    
    // Khởi tạo: Hiển thị lịch sử tìm kiếm khi tải trang
    renderSearchHistory();
    
    // Lắng nghe sự kiện nhập dữ liệu để gợi ý sản phẩm
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value;
        updateSuggestions(query);
    });
    
    
        // Lấy phần tử container của lịch sử tìm kiếm
    const searchContainer = document.querySelector('.header_navbar-search');
    
    // Hàm ẩn lịch sử tìm kiếm
    function hideSearchHistory() {
        searchHistoryContainer.style.display = 'none';
    }
    
    // Lắng nghe sự kiện click trên toàn bộ tài liệu
    document.addEventListener('click', (event) => {
        // Kiểm tra xem nhấp chuột có nằm trong vùng tìm kiếm không
        if (!searchContainer.contains(event.target)) {
            hideSearchHistory();
        }
    });
    
    // Lắng nghe sự kiện focus vào ô tìm kiếm để hiển thị lịch sử
    searchInput.addEventListener('focus', () => {
        if (searchHistory.length > 0) {
            searchHistoryContainer.style.display = 'block';
        }
    });
    
    
    searchInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault(); // Ngừng hành động mặc định của Enter
            const query = searchInput.value.trim();
            if (query) {
                addSearchHistory(query); // Lưu vào lịch sử tìm kiếm
                searchInput.value = '';   // Xóa nội dung trong ô tìm kiếm
            }
        }
    });
    
    window.addEventListener('load', () => {
        searchHistoryContainer.style.display = 'none'; // Ẩn khi chưa focus vào ô tìm kiếm
    });
    
    // Chọn sp trong gợi ý
    function updateSuggestions(query) {
        // Xóa các gợi ý cũ
        searchHistoryList.innerHTML = '';
    
        // Nếu ô tìm kiếm trống, ẩn lịch sử tìm kiếm
        if (!query.trim()) {
            searchHistoryContainer.style.display = 'none';
            return;
        }
    
        // Tìm các sản phẩm phù hợp
        const suggestions = products.filter(product =>
            product.toLowerCase().includes(query.toLowerCase())
        );
    
        // Hiển thị gợi ý nếu có sản phẩm phù hợp
        if (suggestions.length > 0) {
            searchHistoryContainer.style.display = 'block';
            suggestions.forEach(product => {
                // Xác định vị trí phần trùng khớp
                const startIndex = product.toLowerCase().indexOf(query.toLowerCase());
                const endIndex = startIndex + query.length;
    
                // Tách sản phẩm thành các phần trước, trùng khớp, và sau
                const beforeMatch = product.slice(0, startIndex);
                const matchText = product.slice(startIndex, endIndex);
                const afterMatch = product.slice(endIndex);
    
                // Tạo danh sách gợi ý với phần trùng khớp được bôi đậm
                const listItem = document.createElement('li');
                listItem.className = 'header_navbar-search-history-item';
                listItem.innerHTML = `
                    <a href="#">
                        <i class="header_search-icon fa-solid fa-clock-rotate-left"></i>
                        ${beforeMatch}<span class="highlight">${matchText}</span>${afterMatch}
                    </a>
                `;
    
                // Thêm sự kiện click cho từng mục
                listItem.addEventListener('click', () => {
                    searchInput.value = product; // Điền sản phẩm vào ô tìm kiếm
                    searchHistoryContainer.style.display = 'none'; // Ẩn phần gợi ý
                });
    
                searchHistoryList.appendChild(listItem);
            });
        } else {
            searchHistoryContainer.style.display = 'none';
        }
    }
    const btnSearch = document.querySelector('.header_search-button')
    btnSearch.addEventListener('click', ()=>{
        window.location.href = `./Template/resultSearch.htm`;
    });


//giahang.php
    // Cập nhật trạng thái giỏ hàng
    function updateCartStatus() {
        const cartProducts = document.querySelectorAll('.header_cart-wrap');
        const cartEmptyMessage = document.querySelector('.header_navbar-cart');
        const cartFooter = document.querySelector('.cart_footer');

        if (cartProducts.length === 0) {
            cartEmptyMessage.style.display = 'block';
            cartFooter.style.display = 'none';
        } else {
            cartEmptyMessage.style.display = 'none';
            cartFooter.style.display = 'flex';
        }

        // Cập nhật số lượng sản phẩm trong giỏ hàng
        const cartCountElement = document.getElementById('cart-count');
        cartCountElement.textContent = cartProducts.length;
        localStorage.setItem('cartCount', cartProducts.length);
    }

    // Tính tổng giá
    function calculateTotalPrice() {
        let total = 0;
        const priceElements = document.querySelectorAll('.header_cart-price-1[data-price]');
        priceElements.forEach(function (priceElement) {
            const price = parseInt(priceElement.getAttribute('data-price')) || 0;
            total += price;
        });
        const footerPriceElement = document.querySelector('.footer-price');
        footerPriceElement.textContent = total.toLocaleString('vi-VN') + 'đ';
    }

    // Khởi tạo trạng thái ban đầu
    updateCartStatus();
    calculateTotalPrice();