<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Coza Shop - Trang chủ</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>
<body>
    @include('partials.header')
    @include('partials.alerts')

    <!-- Slider -->
    <div class="main-slider-wrapper">
      <div class="swiper main-slider">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <a href="{{ route('list-product') }}?category=1" style="display: block;">
              <img src="{{ asset('img/b1.png') }}" alt="Banner 1 - Sản phẩm cầu lông" />
            </a>
          </div>
          <div class="swiper-slide">
            <a href="{{ route('sale-off') }}" style="display: block;">
              <img src="{{ asset('img/b2.png') }}" alt="Banner 2 - Sale Off" />
            </a>
          </div>
          <div class="swiper-slide">
            <a href="{{ route('list-product') }}?category=2" style="display: block;">
              <img src="{{ asset('img/b3.png') }}" alt="Banner 3 - Giày cầu lông" />
            </a>
          </div>
          <div class="swiper-slide">
            <a href="{{ route('list-news') }}" style="display: block;">
              <img src="{{ asset('img/b4.png') }}" alt="Banner 4 - Tin tức" />
            </a>
          </div>
        </div>
      </div>
    </div>
<!-- Highlight section -->
    <div class="highlight-section">
        <div class="container">
            <div class="highlight-item">
                <i class="icon-ship"></i>
                <div>
                    <strong>Vận chuyển TOÀN QUỐC</strong><br/>
                    Thanh toán khi nhận hàng
                </div>
            </div>
            <div class="highlight-item">
                <i class="icon-quality"></i>
                <div>
                    <strong>Bảo đảm chất lượng</strong><br/>
                    Sản phẩm bảo đảm chất lượng.
                </div>
            </div>
            <div class="highlight-item">
                <i class="icon-payment"></i>
                <div>
                    <strong>Tiến hành THANH TOÁN</strong><br/>
                    Với nhiều PHƯƠNG THỨC
                </div>
            </div>
            <div class="highlight-item">
                <i class="icon-return"></i>
                <div>
                    <strong>Đổi sản phẩm mới</strong><br/>
                    nếu sản phẩm lỗi
                </div>
            </div>
        </div>
    </div>

    <!--Sản phẩm mới-->
  <section class="product-new-section container-wide">
    <h2 class="section-title">Sản phẩm mới</h2>

    <!-- Tabs danh mục -->
    <div class="product-tabs">
      <div class="tab active" data-category="all">Tất cả</div>
      @foreach($categories as $category)
        <div class="tab" data-category="{{ $category->id }}">{{ $category->name }}</div>
      @endforeach
    </div>

    <div class="product-slider-wrap">
      <div class="swiper product-new-slider" role="tabpanel">
        <div class="swiper-wrapper" id="product-slider-wrapper">
          @foreach($newProducts as $product)
          <div class="swiper-slide" data-category="{{ $product->category_id }}">
            <div class="product-cardnew">
              <a href="{{ route('product.detail', $product) }}" style="text-decoration: none; color: inherit;">
                @if($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}" 
                       alt="{{ $product->name }}" 
                       onclick="openImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')"
                       style="cursor: zoom-in; background: white; padding: 15px; border-radius: 8px;" 
                       title="Click để phóng to" />
                @else
                  <img src="https://via.placeholder.com/300x300?text=No+Image" alt="{{ $product->name }}" style="background: white; padding: 15px; border-radius: 8px;" />
                @endif
                <h3>{{ $product->name }}</h3>
                <p class="price">
                  @if($product->isOnSale())
                    <span style="color: #e74c3c; font-weight: bold;">{{ number_format($product->sale_price) }} đ</span>
                    <span style="text-decoration: line-through; color: #999; font-size: 0.9em; margin-left: 10px;">{{ number_format($product->price) }} đ</span>
                  @else
                    {{ number_format($product->price) }} đ
                  @endif
                </p>
                @if($product->isOnSale())
                  <span style="background: #e74c3c; color: white; padding: 3px 8px; border-radius: 3px; font-size: 0.85em;">
                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                  </span>
                @endif
              </a>
            </div>
          </div>
          @endforeach
        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
  </section>
  <!-- Sale off Section -->
  <section class="sale-off-section container-wide">
    <div style="position: relative; margin-bottom: 20px;">
      <h2 class="section-title">Sale off</h2>
      <a href="{{ route('sale-off') }}" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%); color: white; padding: 10px 25px; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(230, 86, 14, 0.3);">
        Xem thêm →
      </a>
    </div>
    
    <div class="product-slider-wrap sale-off-slider-wrap">
      <div class="swiper sale-off-slider" role="tabpanel">
        <div class="swiper-wrapper">
          @foreach($saleProducts as $product)
          <div class="swiper-slide">
            <div class="card_box">
              <a href="{{ route('product.detail', $product) }}" style="text-decoration: none; color: inherit;">
                <span class="discount-badge">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                @if($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}" 
                       alt="{{ $product->name }}" 
                       onclick="openImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')"
                       style="cursor: zoom-in; background: white; padding: 15px; border-radius: 8px;" 
                       title="Click để phóng to" />
                @else
                  <img src="img/sale1.png" alt="{{ $product->name }}" style="background: white; padding: 15px; border-radius: 8px;" />
                @endif
                <div class="card_label">{{ $product->name }}</div>
                <div style="text-align: center; margin-top: 10px;">
                  <span style="color: #e74c3c; font-weight: bold; font-size: 1.2em;">{{ number_format($product->sale_price) }}đ</span><br>
                  <span style="text-decoration: line-through; color: #999;">{{ number_format($product->price) }}đ</span>
                </div>
              </a>
            </div>
          </div>
          @endforeach
        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
  </section>


  <!-- Danh mục sản phẩm -->
  <section class="cau-long-products container-wide">
    <h2 class="section-title">Danh mục sản phẩm</h2>
    <div class="product-grid">
      @foreach($categories as $category)
      <div class="product-card">
        <a href="{{ route('list-product', ['category' => $category->id]) }}" style="text-decoration: none; color: inherit;">
          @if($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" 
                 alt="{{ $category->name }}" 
                 style="background: white; padding: 15px; border-radius: 8px;" />
          @else
            <img src="img/sale1.png" alt="{{ $category->name }}" style="background: white; padding: 15px; border-radius: 8px;" />
          @endif
          <div class="product-label">{{ $category->name }}</div>
        </a>
      </div>
      @endforeach
    </div>
  </section>
  <section class="news-section">
    <h2 class="news-title">Tin tức mới</h2>
    <div class="news-border"></div>

    <div class="news-cards">
      @foreach($latestNews as $news)
      <article class="news-card">
        <a href="{{ route('news.detail', $news) }}" style="text-decoration: none; color: inherit;">
          @if($news->image)
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" />
          @else
            <img src="https://via.placeholder.com/400x250?text=No+Image" alt="{{ $news->title }}" />
          @endif
          <div class="news-content">
            <h3>{{ $news->title }}</h3>
            <time datetime="{{ $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : $news->created_at->format('Y-m-d\TH:i') }}">
              {{ $news->published_at ? $news->published_at->format('d-m-Y H:i') : $news->created_at->format('d-m-Y H:i') }}
            </time>
            <p>{{ $news->excerpt ?? Str::limit(strip_tags($news->content), 150) }}</p>
          </div>
        </a>
      </article>
      @endforeach
    </div>
  </section>

  @include('partials.footer')

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    
    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <div class="image-modal-content">
            <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
            <img id="modalImage" src="" alt="">
            <div class="image-modal-caption" id="modalCaption"></div>
        </div>
    </div>

    <style>
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .image-modal-content {
        position: relative;
        margin: auto;
        padding: 20px;
        width: 90%;
        max-width: 1200px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .image-modal img {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        background: white;
        border-radius: 10px;
        padding: 20px;
    }

    .image-modal-close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-modal-caption {
        color: white;
        text-align: center;
        margin-top: 20px;
        font-size: 18px;
    }
    </style>

    <script>
    function openImageModal(imageSrc, caption) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalCaption = document.getElementById('modalCaption');
        
        modal.style.display = 'block';
        modalImg.src = imageSrc;
        modalCaption.textContent = caption;
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeImageModal();
    });



    // Khởi tạo Sale Off Slider ngay sau khi Swiper được load
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
        
        console.log('Sale Off Slider initialized:', saleOffSlider);
    });
    </script>
</body>
</html>
