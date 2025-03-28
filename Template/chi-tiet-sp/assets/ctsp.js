// document.addEventListener('DOMContentLoaded', function() {
//         const descriptionContainer = document.querySelector('.option-promotions__p');
//         const descriptionText = document.querySelector('.description-text');

//         // Kiểm tra xem nội dung có vượt quá chiều cao giới hạn hay không
//         const isOverflowing = descriptionText.scrollHeight > descriptionContainer.clientHeight;

//         if (isOverflowing) {
//             descriptionContainer.addEventListener('scroll', function() {
//                 // Nếu cuộn lên trên cùng (scrollTop = 0), thu gọn lại
//                 if (descriptionContainer.scrollTop === 0 && descriptionContainer.classList.contains('expanded')) {
//                     descriptionContainer.classList.remove('expanded');
//                 }
//                 // Nếu cuộn xuống (dù chỉ một chút), mở rộng
//                 else if (descriptionContainer.scrollTop > 0) {
//                     descriptionContainer.classList.add('expanded');
//                 }
//             });
//         }
//     });