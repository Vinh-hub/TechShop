

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.querySelector('.modal-review');
    const btnMore = document.querySelector('#btn-more');
    const btnCancel = document.querySelector('.search2-cancel');
    const btnSave = document.querySelector('.search2-save');
    const priceButtons = document.querySelectorAll('.price-range button');
    const minRange = document.querySelector('#min-range');
    const maxRange = document.querySelector('#max-range');
    const minLabel = document.querySelector('#min-label');
    const maxLabel = document.querySelector('#max-label');
    const progress = document.querySelector('#progress');

    // Hiển thị modal khi nhấn nút lọc
    btnMore.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    // Ẩn modal khi nhấn Hủy
    btnCancel.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Xử lý khi nhấn các nút giá cố định
    priceButtons.forEach(button => {
        button.addEventListener('click', function() {
            priceButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const minPrice = parseInt(this.getAttribute('data-min'));
            const maxPrice = parseInt(this.getAttribute('data-max'));

            minRange.value = minPrice;
            maxRange.value = maxPrice;

            updateSlider();
        });
    });

    // Cập nhật thanh trượt và nhãn giá
    function updateSlider() {
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
    }

    // Cập nhật khi thay đổi thanh trượt
    minRange.addEventListener('input', updateSlider);
    maxRange.addEventListener('input', updateSlider);

    // Khởi tạo thanh trượt
    updateSlider();

    // Xử lý khi nhấn Lưu
    btnSave.addEventListener('click', function() {
        const minPrice = parseInt(minRange.value);
        const maxPrice = parseInt(maxRange.value);

        // Cập nhật URL với tham số minPrice và maxPrice
        const url = new URL(window.location.href);
        url.searchParams.set('minPrice', minPrice);
        url.searchParams.set('maxPrice', maxPrice);
        url.searchParams.set('page', 1); // Reset về trang 1
        window.location.href = url.toString();
    });

    // Đóng modal khi nhấn bên ngoài
    modal.addEventListener('click', function(event) {
        if (event.target === modal.querySelector('.modal__overlay')) {
            modal.style.display = 'none';
        }
    });
});