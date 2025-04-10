
    // Lấy các phần tử DOM
    const btnMore = document.getElementById('btn-more');
    const modalReview = document.querySelector('.modal-review');
    
    // Thêm sự kiện click cho nút btn-more
    btnMore.addEventListener('click', function() {
        modalReview.style.display = 'flex';
    });

    // (Tùy chọn) Thêm chức năng đóng modal khi nhấn nút cancel
    const btnCancel = document.querySelector('.search2-cancel');
    btnCancel.addEventListener('click', function() {
        modalReview.style.display = 'none';
    });

    // (Tùy chọn) Đóng modal khi nhấp vào overlay
    const modalOverlay = document.querySelector('.modal__overlay');
    modalOverlay.addEventListener('click', function() {
        modalReview.style.display = 'none';
    });