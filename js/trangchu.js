btnSearch.addEventListener('click', ()=>{
    window.location.href = `./Template/Category/resultSearch.htm`;

});




// document.addEventListener("DOMContentLoaded", () => {
//     const basePath = localStorage.getItem('basePath');
//     const accountLink = document.getElementById('account-link'); // Tham chiếu đến thẻ tài khoản
//     const accountIconLink = document.getElementById('account-icon-link'); // Tham chiếu đến thẻ biểu tượng tài khoản
//     // Hàm chuyển hướng theo trạng thái đăng nhập
//     function handleAccountLinkClick(event) {
//         event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
//         const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true'; // Kiểm tra trạng thái đăng nhập
        
//         if (isLoggedIn) {
//             // Nếu đã đăng nhập, chuyển đến trang thông tin
//             window.location.href = `./Template/Information.htm`;
//         } else {
//             // Nếu chưa đăng nhập, chuyển đến trang đăng ký
//             window.location.href = `./Template/Category/formNK.htm`;
//         }
//     }
//      // Gán sự kiện nhấp chuột cho cả hai liên kết
//     if (accountLink) {
//         accountLink.addEventListener('click', handleAccountLinkClick);
//     }

//     if (accountIconLink) {
//         accountIconLink.addEventListener('click', handleAccountLinkClick);
//     }
// });