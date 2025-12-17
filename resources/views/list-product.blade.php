<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VN B Admin Page</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/list-product.css') }}?v={{ time() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>
<body>
    @include('partials.header')
    
<!-- Page Content -->
<div class="filter-container container">
  <!-- Sidebar filter -->
  <aside class="filter-sidebar" aria-label="Bộ lọc sản phẩm">
    <h3>DANH MỤC</h3>
    <a href="{{ route('list-product') }}" style="display: block; padding: 10px 0; color: {{ !request('category') && !request('brand') ? '#e74c3c' : '#333' }}; text-decoration: none; font-weight: {{ !request('category') && !request('brand') ? 'bold' : 'normal' }}; transition: color 0.3s;">
      Tất cả sản phẩm
    </a>
    @foreach($categories as $category)
    <a href="{{ route('list-product', ['category' => $category->id] + (request('brand') ? ['brand' => request('brand')] : [])) }}" style="display: block; padding: 10px 0; color: {{ request('category') == $category->id ? '#e74c3c' : '#333' }}; text-decoration: none; font-weight: {{ request('category') == $category->id ? 'bold' : 'normal' }}; transition: color 0.3s;" onmouseover="this.style.color='#e74c3c'" onmouseout="this.style.color='{{ request('category') == $category->id ? '#e74c3c' : '#333' }}'">
      {{ $category->name }} ({{ $category->products->count() }})
    </a>
    @endforeach

    <h3 style="margin-top: 30px;">THƯƠNG HIỆU</h3>
    <form id="brandFilterForm" method="GET" action="{{ route('list-product') }}">
      @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
      @endif
      @if(request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
      @endif
      @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
      @endif
      
      @foreach($allBrands as $brand)
      <label style="cursor: pointer; transition: color 0.3s; display: block; margin-bottom: 12px; color: {{ in_array($brand, (array)request('brand', [])) ? '#e74c3c' : '#333' }}; font-weight: {{ in_array($brand, (array)request('brand', [])) ? 'bold' : 'normal' }};" onmouseover="this.style.color='#e74c3c'" onmouseout="this.style.color='{{ in_array($brand, (array)request('brand', [])) ? '#e74c3c' : '#333' }}'">
        <input type="checkbox" name="brand[]" value="{{ $brand }}" 
               {{ in_array($brand, (array)request('brand', [])) ? 'checked' : '' }}
               onchange="document.getElementById('brandFilterForm').submit()">
        {{ $brand }}
      </label>
      @endforeach
    </form>
    
    @if(request('category') || request('brand'))
    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
      <a href="{{ route('list-product') }}" style="display: inline-block; padding: 8px 16px; background: #e74c3c; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; transition: background 0.3s;" onmouseover="this.style.background='#c0392b'" onmouseout="this.style.background='#e74c3c'">
        <i class="fas fa-times"></i> Xóa bộ lọc
      </a>
    </div>
    @endif
  </aside>

  <!-- Product list -->
  <section class="product-list" aria-label="Danh sách sản phẩm">
    <div class="product-header">
      <h2 style="text-transform: capitalize;">
        @if(request('category'))
          @php
            $currentCategory = $categories->firstWhere('id', request('category'));
          @endphp
          {{ $currentCategory ? $currentCategory->name : 'Tất cả sản phẩm' }}
        @else
          Tất cả sản phẩm
        @endif
      </h2>
      <div class="sort">
        <label for="sort-select">Sắp xếp:</label>
        <form method="GET" style="display: inline;">
          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
          @if(request('brand'))
            @foreach((array)request('brand') as $brand)
              <input type="hidden" name="brand[]" value="{{ $brand }}">
            @endforeach
          @endif
          @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
          @endif
          <select name="sort" id="sort-select" onchange="this.form.submit()">
            <option value="">Mặc định</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
          </select>
        </form>
      </div>
    </div>

    <div class="products-grid">
      @forelse($products as $product)
      <article class="product-card">
        <a href="{{ route('product.detail', $product) }}" style="text-decoration: none; color: inherit;">
          @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 onclick="openImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')"
                 style="cursor: zoom-in;" 
                 title="Click để phóng to" />
          @else
            <img src="https://via.placeholder.com/300x300?text=No+Image" alt="{{ $product->name }}" />
          @endif
          <h3>{{ $product->name }}</h3>
          <p class="price">
            @if($product->isOnSale())
              <span style="color: #e74c3c; font-weight: bold;">{{ number_format($product->sale_price) }} đ</span>
              <span style="text-decoration: line-through; color: #999; font-size: 0.9em; display: block;">{{ number_format($product->price) }} đ</span>
            @else
              {{ number_format($product->price) }} đ
            @endif
          </p>
          @if($product->is_featured)
            <span class="badge premium">Nổi bật</span>
          @endif
          @if($product->isOnSale())
            <span class="badge" style="background: #e74c3c;">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
          @endif
        </a>
      </article>
      @empty
      <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
        <p style="font-size: 1.2em; color: #999;">Không tìm thấy sản phẩm nào</p>
      </div>
      @endforelse
    </div>
    
    <!-- Pagination -->
    @if($products->hasPages())
    <div style="margin-top: 30px; text-align: center;">
      <nav>
        <ul class="pagination" style="display: flex; justify-content: center; gap: 8px; list-style: none; padding: 0;">
          {{-- Previous Page Link --}}
          @if ($products->onFirstPage())
            <li class="disabled" style="opacity: 0.5;">
              <span style="display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border: 1px solid #ddd; border-radius: 5px; font-size: 18px;">‹</span>
            </li>
          @else
            <li>
              <a href="{{ $products->previousPageUrl() }}" style="display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; color: #333; font-size: 18px; transition: all 0.3s;">‹</a>
            </li>
          @endif

          {{-- Pagination Elements --}}
          @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if ($page == $products->currentPage())
              <li>
                <span style="display: flex; align-items: center; justify-content: center; min-width: 35px; height: 35px; padding: 0 10px; background: #e6560e; color: white; border-radius: 5px; font-size: 14px; font-weight: bold;">{{ $page }}</span>
              </li>
            @else
              <li>
                <a href="{{ $url }}" style="display: flex; align-items: center; justify-content: center; min-width: 35px; height: 35px; padding: 0 10px; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; color: #333; font-size: 14px; transition: all 0.3s;">{{ $page }}</a>
              </li>
            @endif
          @endforeach

          {{-- Next Page Link --}}
          @if ($products->hasMorePages())
            <li>
              <a href="{{ $products->nextPageUrl() }}" style="display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; color: #333; font-size: 18px; transition: all 0.3s;">›</a>
            </li>
          @else
            <li class="disabled" style="opacity: 0.5;">
              <span style="display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; border: 1px solid #ddd; border-radius: 5px; font-size: 18px;">›</span>
            </li>
          @endif
        </ul>
      </nav>
    </div>
    @endif
  </section>
</div>

@include('partials.footer')
<button id="scrollToTopBtn" aria-label="Scroll to top">&#8679;</button>

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
</script>

  <!-- JS -->
    <script src="{{ asset('js/list-product.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</body>
</html>
