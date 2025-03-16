// functions
// function render(list) {
//     productList.innerHTML = '';
//     list.forEach(item => {
//         productList.appendChild(item);
//     });
// };
const productList = document.querySelector('.product-list');
var productLists = document.querySelectorAll('.product-list');
var inputElement = document.querySelector('.header_search-input');
var buttonElement = document.querySelector('.header_search-button');
let productItems = Array.from(productList.children);
const originalArr = [...productItems];
const itemProducts = document.querySelectorAll('.product-item__cate');
var pagination = document.querySelector('.pagination-list');
var nonepagination = document.querySelector('.none-pagination');

function render(list) {
    productList.innerHTML = '';

    if (list.length > 0) {
        list.forEach(item => {
            productList.appendChild(item); 
        });
    } else {
        productList.innerHTML ='<div class="no-product"><span class="no-product__text">Không tìm thấy sản phẩm</span></div>';

        nonepagination.style.display = 'none';
        pagination.style.display = 'block';////
    }
};

const btndts = document.querySelectorAll('.btn-custom');
btndts.forEach(btndt => {
    btndt.addEventListener('click', function () {
        if (btndt.classList.contains('btn--primary')) {
            btndt.classList.remove('btn--primary');
        } else {
            btndts.forEach(btn => btn.classList.remove('btn--primary'));
            btndt.classList.add('btn--primary');
        }
    });
});

///////////////////////////////////////
if (nonepagination && pagination) {
    if (itemProducts.length > 5) {
        nonepagination.style.display = 'none';//block
        pagination.style.display = 'flex';
    } else {
        nonepagination.style.display = 'none';
        pagination.style.display = 'flex';
    }
} else {
    console.log("Không tìm thấy các phần tử cần thiết.");
}
//
var arr = [];

document.querySelectorAll('.product-item__cate').forEach(itemproduct => {
    arr.push(itemproduct);
});     
btndts.forEach(btn => {
    btn.addEventListener('click', e => {
        let className = e.currentTarget.getAttribute('class');
        let filterData = arr.filter(food => {
            return Array.from(food.classList).some(cls => className.includes(cls));
        });
    const isPrimary = btn.classList.contains('btn--primary');
        if (isPrimary) {
           render(filterData); 
        } else {
            render(arr); 
        }
    });
});


const btnPrices = document.querySelectorAll('.select-price-item');
btnPrices.forEach(btnPrice => {
    btnPrice.addEventListener('click', () => {
        if (btnPrice.classList.contains('active')) {
            btnPrice.classList.remove('active');
        } else {
            btnPrices.forEach(btn => btn.classList.remove('active'));
            btnPrice.classList.add('active');
        }
        // Kiểm tra nếu nút đã có class active
        if (btnPrice.classList.contains('active')) {
            productItems.sort((a, b) => {
                const priceA = parseInt(a.querySelector('.price-current').getAttribute('data-price').replace('.', '') || 0);
                const priceB = parseInt(b.querySelector('.price-current').getAttribute('data-price').replace('.', '') || 0);

                // Sắp xếp tăng dần
                if (btnPrice.classList.contains('asc')) {
                    return priceA - priceB;
                }
                // Sắp xếp giảm dần
                if (btnPrice.classList.contains('desc')) {
                    return priceB - priceA;
                }
            });
        } else {
            productItems = [...originalArr]; 
        }
        render(productItems);
    });
});

document.addEventListener("DOMContentLoaded", () => {
    let cartCount = parseInt(localStorage.getItem("cartCount")) || 0;
    const cartCountElement = document.getElementById("cart-count");
    if (cartCountElement) {
        cartCountElement.textContent = cartCount;
    }
});