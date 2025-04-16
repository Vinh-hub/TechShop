document.addEventListener('DOMContentLoaded', () => {
    // Hàm lấy categoryId từ URL hoặc biến global
    const getCategoryId = () => {
        if (typeof currentCategoryId !== 'undefined') {
            return currentCategoryId;
        }
        const params = new URLSearchParams(window.location.search);
        return params.get('categoryId') || '1'; // Mặc định là 1
    };

    // Xử lý nút tìm kiếm trong header
    const btnSearch = document.querySelector('.header_search-button');
    if (btnSearch) {
        btnSearch.addEventListener('click', () => {
            const searchInput = document.querySelector('.header_search-input');
            if (searchInput) {
                const searchTerm = searchInput.value;
                window.location.href = `../resultSearch.php?categoryId=${getCategoryId()}&search=${encodeURIComponent(searchTerm)}`;
            }
        });
    }

    // Xử lý modal bộ lọc
    const modal = document.querySelector('.modal-review');
    const btnMore = document.querySelector('#btn-more');
    const btnCancel = document.querySelector('.search2-cancel');
    const btnSave = document.querySelector('.search2-save');
    const modalOverlay = document.querySelector('.modal__overlay');

    if (btnMore && modal) {
        btnMore.addEventListener('click', () => {
            modal.style.display = 'flex';
        });
    }

    if (btnCancel && modal) {
        btnCancel.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    if (modalOverlay && modal) {
        modalOverlay.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    // Xử lý chọn hãng
    const brandButtons = document.querySelectorAll('.brand-options button');
    if (brandButtons.length > 0) {
        brandButtons.forEach(button => {
            button.addEventListener('click', () => {
                brandButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
    }

    // Xử lý thanh trượt giá và nút giá cố định
    const minRange = document.querySelector('#min-range');
    const maxRange = document.querySelector('#max-range');
    const minLabel = document.querySelector('#min-label');
    const maxLabel = document.querySelector('#max-label');
    const progress = document.querySelector('#progress');
    const priceButtons = document.querySelectorAll('.price-range button');

    if (minRange && maxRange && minLabel && maxLabel && progress) {
        const updateSlider = () => {
            let minVal = parseInt(minRange.value);
            let maxVal = parseInt(maxRange.value);

            // Đảm bảo minVal không lớn hơn maxVal
            if (minVal > maxVal) {
                [minVal, maxVal] = [maxVal, minVal];
                minRange.value = minVal;
                maxRange.value = maxVal;
            }

            // Cập nhật nhãn giá
            minLabel.textContent = minVal.toLocaleString('vi-VN') + 'đ';
            maxLabel.textContent = maxVal.toLocaleString('vi-VN') + 'đ';

            // Cập nhật thanh tiến trình
            const min = parseInt(minRange.min);
            const max = parseInt(minRange.max);
            const left = ((minVal - min) / (max - min)) * 100;
            const right = ((maxVal - min) / (max - min)) * 100;
            progress.style.left = left + '%';
            progress.style.right = (100 - right) + '%';
        };

        // Xử lý nút giá cố định
        if (priceButtons.length > 0) {
            priceButtons.forEach(button => {
                button.addEventListener('click', () => {
                    priceButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    const minPrice = parseInt(button.getAttribute('data-min'));
                    const maxPrice = parseInt(button.getAttribute('data-max'));

                    minRange.value = minPrice;
                    maxRange.value = maxPrice;

                    updateSlider();
                });
            });
        }

        // Cập nhật khi thay đổi thanh trượt
        minRange.addEventListener('input', updateSlider);
        maxRange.addEventListener('input', updateSlider);

        // Khởi tạo thanh trượt
        updateSlider();
    }

    // Xử lý lưu bộ lọc
    if (btnSave) {
        btnSave.addEventListener('click', () => {
            const searchInput = document.querySelector('.search3');
            const selectedBrand = document.querySelector('.brand-options button.active')?.dataset.brand || '';
            const minPrice = minRange ? parseInt(minRange.value) : 0;
            const maxPrice = maxRange ? parseInt(maxRange.value) : 999999999;
            const searchTerm = searchInput ? searchInput.value : '';

            let url = `../resultSearch.php?categoryId=${getCategoryId()}&search=${encodeURIComponent(searchTerm)}&minPrice=${minPrice}&maxPrice=${maxPrice}`;
            if (selectedBrand) {
                url += `&brand=${encodeURIComponent(selectedBrand)}`;
            }
            window.location.href = url;
        });
    }
});