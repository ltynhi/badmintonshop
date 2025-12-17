
document.querySelectorAll('.dropdown > a').forEach(anchor => {
    anchor.addEventListener('click', e => {
        e.preventDefault();
        const dropdownMenu = anchor.nextElementSibling;
        if(dropdownMenu.style.display === 'flex'){
            dropdownMenu.style.display = 'none';
        } else {
            // close others
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
            dropdownMenu.style.display = 'flex';
        }
    });
});

// Close dropdown if clicked outside
document.addEventListener('click', e => {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    }
});

// Khởi tạo Swiper cho slider chính
const mainSlider = new Swiper('.main-slider', {
  loop: true,
  speed: 1500,
  autoplay: {
    delay: 5000, // Chuyển hình sau 5 giây (5000ms)
    disableOnInteraction: false,
  },

  speed: 1200,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});


//// Khởi tạo slider sản phẩm mới với swiper
const productSlider = new Swiper('.product-new-slider', {
  loop: true,
  speed: 700,
  slidesPerView: 5,
  spaceBetween: 25,
  navigation: {
    nextEl: '.product-new-slider .swiper-button-next',
    prevEl: '.product-new-slider .swiper-button-prev',
  },
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  breakpoints: {
    320: {
      slidesPerView: 2,
      spaceBetween: 12,
    },
    576: {
      slidesPerView: 3,
      spaceBetween: 15,
    },
    768: {
      slidesPerView: 4,
      spaceBetween: 18,
    },
    992: {
      slidesPerView: 5,
      spaceBetween: 25,
    }
  }
});

//// Khởi tạo slider Sale Off với swiper
document.addEventListener('DOMContentLoaded', function() {
  const saleOffSlider = new Swiper('.sale-off-slider', {
    loop: true,
    speed: 700,
    slidesPerView: 4,
    spaceBetween: 25,
    navigation: {
      nextEl: '.sale-off-slider .swiper-button-next',
      prevEl: '.sale-off-slider .swiper-button-prev',
    },
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    breakpoints: {
      320: {
        slidesPerView: 2,
        spaceBetween: 12,
      },
      576: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 18,
      },
      992: {
        slidesPerView: 4,
        spaceBetween: 25,
      }
    }
  });
});

// Lọc sản phẩm theo tab bấm
document.addEventListener('DOMContentLoaded', function() {
  const tabs = document.querySelectorAll('.product-tabs .tab');
  const slides = document.querySelectorAll('.product-new-slider .swiper-slide');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // Xóa active tab hiện tại
      document.querySelector('.product-tabs .tab.active').classList.remove('active');
      // Thêm active tab được click
      tab.classList.add('active');

      const filter = tab.dataset.category;

      // Ẩn/hiện slide theo filter
      slides.forEach(slide => {
        const slideCategory = slide.dataset.category;
        if (filter === 'all') {
          slide.style.display = ''; // Hiển thị tất cả
        } else {
          slide.style.display = slideCategory === filter ? '' : 'none'; // Hiển thị chỉ khớp
        }
      });

      // Tắt loop và autoplay khi lọc (để tránh lỗi với slide ẩn)
      if (filter !== 'all') {
        productSlider.params.loop = false;
        productSlider.autoplay.stop(); // Dừng autoplay
      } else {
        productSlider.params.loop = true;
        productSlider.autoplay.start(); // Bật lại autoplay
      }

      // Cập nhật swiper sau khi ẩn/hiện sản phẩm (với delay nhỏ để DOM ổn định)
      setTimeout(() => {
        productSlider.update();
        productSlider.slideTo(0); // Trả về slide đầu tiên sau khi lọc
      }, 100); // Delay 100ms
    });
  });
});
document.addEventListener('DOMContentLoaded', () => {
  const xemCuaHang = document.querySelector('.footer-column .highlight');
  if (xemCuaHang) {
    xemCuaHang.addEventListener('click', () => {
      alert('Chuyển đến trang danh sách cửa hàng VNB.');
      // window.location.href = 'link_to_store_list_page.html';
    });
  }
});
const scrollToTopBtn = document.getElementById("scrollToTopBtn");

window.addEventListener("scroll", () => {
  if (window.scrollY > 100) {
    scrollToTopBtn.classList.add("show");
  } else {
    scrollToTopBtn.classList.remove("show");
  }
});

scrollToTopBtn.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});
//Phần lọc sale off
// Lấy checkbox chi nhánh và sản phẩm
const checkboxes = document.querySelectorAll(".filter-sidebar input[type='checkbox']");
const products = document.querySelectorAll(".product-card");

function filterProducts() {
  const checkedBranches = Array.from(document.querySelectorAll(".filter-sidebar input[name='branch']:checked")).map(cb => cb.value.toLowerCase());

  products.forEach(prod => {
    const prodBranch = prod.getAttribute("data-branch").toLowerCase();
    // Nếu không có chi nhánh nào chọn thì show tất cả, nếu có chọn thì show sản phẩm có thuộc chi nhánh được chọn
    if (checkedBranches.length === 0 || checkedBranches.includes(prodBranch)) {
      prod.style.display = "flex";
    } else {
      prod.style.display = "none";
    }
  });
}

// Gắn sự kiện change cho checkbox bộ lọc
checkboxes.forEach(cb => {
  cb.addEventListener("change", filterProducts);
});

// Lọc sản phẩm lần đầu khi trang được tải
window.addEventListener("DOMContentLoaded", filterProducts);

document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('searchForm');
    const keywordInput = document.getElementById('keyword');
    const cardList = document.querySelector('.card-list');

    searchForm.addEventListener('submit', e => {
        e.preventDefault();
        const keyword = keywordInput.value.toLowerCase().trim();

        // Filter cards by keyword in title or description
        const cards = cardList.querySelectorAll('.card');
        cards.forEach(card => {
            const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('p')?.textContent.toLowerCase() || '';
            if (title.includes(keyword) || desc.includes(keyword)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Optional: Add toggle functionality for sidebar categories if needed
    const toggles = document.querySelectorAll('.news-categories li span.toggle');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', e => {
            const li = e.target.parentElement;
            // Manage expanding or collapsing submenus here if needed
            // For demo: toggle plus/minus sign
            if (toggle.textContent === '+') {
                toggle.textContent = '-';
            } else {
                toggle.textContent = '+';
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');

    form.addEventListener('submit', e => {
        e.preventDefault();

        // Simple validation
        const fullname = form.fullname.value.trim();
        const email = form.email.value.trim();
        const phone = form.phone.value.trim();
        const message = form.message.value.trim();

        if (!fullname) {
            alert('Vui lòng nhập họ và tên.');
            form.fullname.focus();
            return;
        }

        if (!email || !validateEmail(email)) {
            alert('Vui lòng nhập email hợp lệ.');
            form.email.focus();
            return;
        }

        if (!phone || !validatePhone(phone)) {
            alert('Vui lòng nhập số điện thoại hợp lệ.');
            form.phone.focus();
            return;
        }

        if (!message) {
            alert('Vui lòng nhập nội dung.');
            form.message.focus();
            return;
        }

        // Nếu validation ok, có thể xử lý gửi form (ví dụ AJAX hoặc submit thật)
        alert('Thông tin đã được gửi thành công! Chúng tôi sẽ liên hệ lại bạn sớm.');
        form.reset();
    });

    function validateEmail(email) {
        // Regex email đơn giản
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        // Dùng pattern + số 9-15 chữ số
        const re = /^\+?\d{9,15}$/;
        return re.test(phone);
    }
});
 function goToBlog() {
      document.body.classList.add('fade-out');
      setTimeout(() => {
        window.location.href = 'blog.html';
      }, 500);
    }

    function goToHome() {
      document.body.classList.add('fade-out');
      setTimeout(() => {
        window.location.href = '#';
      }, 500);
    }

    function handleTransition(event, url) {
      event.preventDefault();
      document.body.classList.add('fade-out');
      setTimeout(() => {
        window.location.href = url;
      }, 500);
    }

    const carousel = document.getElementById('blogCarousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const notificationIcon = document.getElementById('notificationIcon');
    const profileIcon = document.getElementById('profileIcon');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const profileDropdown = document.getElementById('profileDropdown');

    function toggleDropdown(dropdown, otherDropdown) {
      if (dropdown.classList.contains('active')) {
        dropdown.classList.remove('active');
      } else {
        dropdown.classList.add('active');
        if (otherDropdown) {
          otherDropdown.classList.remove('active');
        }
      }
    }

    function closeAllDropdowns() {
      notificationDropdown.classList.remove('active');
      profileDropdown.classList.remove('active');
    }

    notificationIcon.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleDropdown(notificationDropdown, profileDropdown);
    });

    profileIcon.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleDropdown(profileDropdown, notificationDropdown);
    });

    document.addEventListener('click', (e) => {
      if (!notificationIcon.contains(e.target) && !notificationDropdown.contains(e.target) &&
          !profileIcon.contains(e.target) && !profileDropdown.contains(e.target)) {
        closeAllDropdowns();
      }
    });

    function updateCarousel() {
      const cards = document.querySelectorAll('.blog-card');
      const carouselRect = carousel.getBoundingClientRect();
      const center = carouselRect.left + carouselRect.width / 2;

      cards.forEach(card => {
        const cardRect = card.getBoundingClientRect();
        const cardCenter = cardRect.left + cardRect.width / 2;
        const distance = Math.abs(center - cardCenter);
        const maxDistance = carouselRect.width / 2;

        const rotation = (distance / maxDistance) * 20;
        const opacity = 1 - (distance / maxDistance) * 0.3;

        if (distance > maxDistance) {
          card.classList.add('out-of-view');
          card.style.transform = `rotateY(${rotation}deg)`;
          card.style.opacity = opacity;
        } else {
          card.classList.remove('out-of-view');
          card.style.transform = 'rotateY(0deg)';
          card.style.opacity = 1;
        }
      });
    }

    prevBtn.addEventListener('click', () => {
      carousel.scrollBy({ left: -280, behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', () => {
      carousel.scrollBy({ left: 280, behavior: 'smooth' });
    });

    carousel.addEventListener('scroll', updateCarousel);
    window.addEventListener('resize', updateCarousel);
    updateCarousel();

    //gio hang
    document.querySelectorAll('.btn-qty').forEach(button => {
  button.addEventListener('click', () => {
    const isPlus = button.classList.contains('plus');
    const input = button.parentElement.querySelector('input');
    let currentValue = parseInt(input.value, 10);

    if(isPlus) {
      input.value = currentValue + 1;
    } else {
      if(currentValue > 1) {
        input.value = currentValue - 1;
      }
    }
    updateTotalPrice();
  });
});

document.querySelectorAll('.btn-remove').forEach(button => {
  button.addEventListener('click', () => {
    button.closest('.cart-item').remove();
    updateTotalPrice();
  });
});

function updateTotalPrice() {
  const cartItems = document.querySelectorAll('.cart-item');
  let total = 0;

  cartItems.forEach(item => {
    const priceText = item.querySelector('.item-price').textContent.trim();
    const priceNumber = Number(priceText.replace(/\D/g, ''));
    const qty = parseInt(item.querySelector('input').value, 10);
    total += priceNumber * qty;
  });

  const formattedTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ';

  const totalDisplay = document.querySelector('.total-amount');
  if(totalDisplay) {
    totalDisplay.textContent = formattedTotal;
  }
}
// Star Rating Functionality
document.addEventListener('DOMContentLoaded', function() {
    const starRating = document.getElementById('star-rating');
    if (starRating) {
        const stars = starRating.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');
        
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingInput.value = rating;
                
                // Update star display
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.textContent = '⭐';
                        s.style.color = '#f39c12';
                    } else {
                        s.textContent = '☆';
                        s.style.color = '#ddd';
                    }
                });
            });
            
            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.textContent = '⭐';
                        s.style.color = '#f39c12';
                    } else {
                        s.textContent = '☆';
                        s.style.color = '#ddd';
                    }
                });
            });
        });
        
        // Reset to current rating on mouse leave
        starRating.addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value);
            stars.forEach((s, i) => {
                if (i < currentRating) {
                    s.textContent = '⭐';
                    s.style.color = '#f39c12';
                } else {
                    s.textContent = '☆';
                    s.style.color = '#ddd';
                }
            });
        });
        
        // Set initial state (5 stars selected by default)
        const initialRating = parseInt(ratingInput.value);
        stars.forEach((s, i) => {
            if (i < initialRating) {
                s.textContent = '⭐';
                s.style.color = '#f39c12';
            } else {
                s.textContent = '☆';
                s.style.color = '#ddd';
            }
        });
    }
});