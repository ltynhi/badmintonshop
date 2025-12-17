document.querySelectorAll('.btn-qty').forEach(button => {
  button.addEventListener('click', () => {
    const input = button.parentElement.querySelector('input');
    let qty = parseInt(input.value);

    if(button.classList.contains('plus')) {
      qty += 1;
    } else if(button.classList.contains('minus') && qty > 1){
      qty -= 1;
    }

    input.value = qty;
    updateTotal();
  });
});

document.querySelectorAll('.btn-remove').forEach(button => {
  button.addEventListener('click', () => {
    const item = button.closest('.cart-item');
    if(item){
      item.remove();
      updateTotal();
    }
  });
});

function updateTotal() {
  let total = 0;
  document.querySelectorAll('.cart-item').forEach(item => {
    const priceText = item.querySelector('.item-price').textContent.trim();
    const qty = parseInt(item.querySelector('input').value);
    const price = Number(priceText.replace(/\D/g, ''));

    total += price * qty;
  });

  let formatted = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ';

  document.querySelector('.total-amount').textContent = formatted;
}
// Khởi tạo tổng tiền khi load trang
updateTotal();
// js/shopping-cart.js
const CART_KEY = 'vnb_cart';

function getCart() { return JSON.parse(localStorage.getItem(CART_KEY) || '[]'); }
function saveCart(cart) { localStorage.setItem(CART_KEY, JSON.stringify(cart)); updateCartCount(cart); }

function updateCartCount(cart = getCart()) {
  const countEl = document.querySelector('.cart-count');
  const count = cart.reduce((sum, i) => sum + i.qty, 0);
  if (countEl) countEl.textContent = count;
}
function updateTotal() {
  const cart = getCart();
  const total = cart.reduce((sum, i) => sum + i.price * i.qty, 0);
  document.querySelector('.total-amount').textContent = total.toLocaleString('vi-VN') + ' đ';
}
// Gắn event cho nút +/-, xóa
document.querySelectorAll('.btn-qty').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.closest('.cart-item').dataset.id;
    const cart = getCart();
    const item = cart.find(i => i.id == id);
    if (!item) return;
    if (btn.classList.contains('plus')) item.qty++;
    if (btn.classList.contains('minus')) item.qty = Math.max(1, item.qty - 1);
    saveCart(cart); updateTotal();
  });
});
document.querySelectorAll('.btn-remove').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.closest('.cart-item').dataset.id;
    const cart = getCart().filter(i => i.id != id);
    saveCart(cart); location.reload();
  });
});
window.addEventListener('DOMContentLoaded', () => { updateCartCount(); updateTotal(); });
