<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VN B Admin Page</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/sale.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/optimized.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>
<body>
    @include('partials.header')
    </body>
    </html>
     <!-- BỘ LỌC & DANH SÁCH SẢN PHẨM -->
  <div class="filter-container container">

    <!-- Sidebar bộ lọc -->
    <aside class="filter-sidebar" aria-label="Bộ lọc ">
      <h3>MỨC GIẢM GIÁ</h3>
      <form id="discountFilterForm" method="GET" action="{{ route('sale-off') }}">
        @if(request('category'))
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if(request('price_range'))
          @foreach((array)request('price_range') as $range)
            <input type="hidden" name="price_range[]" value="{{ $range }}">
          @endforeach
        @endif
        
        <label class="filter-label {{ in_array('10', (array)request('discount', [])) ? 'active' : '' }}">
          <input type="checkbox" name="discount[]" value="10" {{ in_array('10', (array)request('discount', [])) ? 'checked' : '' }} onchange="this.form.submit()"> 10% - 20%
        </label>
        <label class="filter-label {{ in_array('20', (array)request('discount', [])) ? 'active' : '' }}">
          <input type="checkbox" name="discount[]" value="20" {{ in_array('20', (array)request('discount', [])) ? 'checked' : '' }} onchange="this.form.submit()"> 20% - 30%
        </label>
        <label class="filter-label {{ in_array('30', (array)request('discount', [])) ? 'active' : '' }}">
          <input type="checkbox" name="discount[]" value="30" {{ in_array('30', (array)request('discount', [])) ? 'checked' : '' }} onchange="this.form.submit()"> 30% - 40%
        </label>
        <label class="filter-label {{ in_array('40', (array)request('discount', [])) ? 'active' : '' }}">
          <input type="checkbox" name="discount[]" value="40" {{ in_array('40', (array)request('discount', [])) ? 'checked' : '' }} onchange="this.form.submit()"> 40% - 50%
        </label>
        <label class="filter-label {{ in_array('50', (array)request('discount', [])) ? 'active' : '' }}">
          <input type="checkbox" name="discount[]" value="50" {{ in_array('50', (array)request('discount', [])) ? 'checked' : '' }} onchange="this.form.submit()"> Trên 50%
        </label>
      </form>
   
      <h3 style="margin-top: 30px;">CHỌN MỨC GIÁ</h3>
      <form id="priceFilterForm" method="GET" action="{{ route('sale-off') }}">
        @if(request('category'))
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if(request('discount'))
          @foreach((array)request('discount') as $disc)
            <input type="hidden" name="discount[]" value="{{ $disc }}">
          @endforeach
        @endif
        
        <label style="cursor: pointer; display: block; margin-bottom: 12px; color: {{ in_array('under_500k', (array)request('price_range', [])) ? '#e74c3c' : '#333' }}; font-weight: {{ in_array('under_500k', (array)request('price_range', [])) ? 'bold' : 'normal' }};">
          <input type="checkbox" name="price_range[]" value="under_500k" {{ in_array('under_500k', (array)request('price_range', [])) ? 'checked' : '' }} onchange="this.form.submit()"> Dưới 500.000 VND
        </label>
        <label style="cursor: pointer; display: block; margin-bottom: 12px; color: {{ in_array('500k_1m', (array)request('price_range', [])) ? '#e74c3c' : '#333' }}; font-weight: {{ in_array('500k_1m', (array)request('price_range', [])) ? 'bold' : 'normal' }};">
          <input type="checkbox" name="price_range[]" value="500k_1m" {{ in_array('500k_1m', (array)request('price_range', [])) ? 'checked' : '' }} onchange="this.form.submit()"> Từ 500.000 VND đến 1.000.000 VND
        </label>
        <label style="cursor: pointer; display: block; margin-bottom: 12px; color: {{ in_array('1m_2m', (array)request('price_range', [])) ? '#e74c3c' : '#333' }}; font-weight: {{ in_array('1m_2m', (array)request('price_range', [])) ? 'bold' : 'normal' }};">
          <input type="checkbox" name="price_range[]" value="1m_2m" {{ in_array('1m_2m', (array)request('price_range', [])) ? 'checked' : '' }} onchange="this.form.submit()"> Từ 1.000.000 VND đến 2.000.000 VND
        </label>
        <label style="cursor: pointer; display: block; margin-bottom: 12px; color: {{ in_array('2m_3m', (array)request('price_range', [])) ? '#e74c3c' : '#333' }}; font-weight: {{ in_array('2m_3m', (array)request('price_range', [])) ? 'bold' : 'normal' }};">
          <input type="checkbox" name="price_range[]" value="2m_3m" {{ in_array('2m_3m', (array)request('price_range', [])) ? 'checked' : '' }} onchange="this.form.submit()"> Từ 2.000.000 VND đến 3.000.000 VND
        </label>
      </form>
      
      <h3 style="margin-top: 30px;">DANH MỤC SẢN PHẨM</h3>
      <a href="{{ route('sale-off') }}" style="display: block; padding: 10px 0; color: {{ !request('category') ? '#e74c3c' : '#333' }}; text-decoration: none; font-weight: {{ !request('category') ? 'bold' : 'normal' }}; transition: color 0.3s;">
        Tất cả danh mục
      </a>
      @foreach($categories as $category)
      <a href="{{ route('sale-off', ['category' => $category->id] + (request('discount') ? ['discount' => request('discount')] : []) + (request('price_range') ? ['price_range' => request('price_range')] : [])) }}" 
         style="display: block; padding: 10px 0; color: {{ request('category') == $category->id ? '#e74c3c' : '#333' }}; text-decoration: none; font-weight: {{ request('category') == $category->id ? 'bold' : 'normal' }}; transition: color 0.3s;" 
         onmouseover="this.style.color='#e74c3c'" 
         onmouseout="this.style.color='{{ request('category') == $category->id ? '#e74c3c' : '#333' }}'">
        {{ $category->name }}
      </a>
      @endforeach
      
      @if(request('category') || request('discount') || request('price_range'))
      <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
        <a href="{{ route('sale-off') }}" style="display: inline-block; padding: 8px 16px; background: #e74c3c; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; transition: background 0.3s;" onmouseover="this.style.background='#c0392b'" onmouseout="this.style.background='#e74c3c'">
          <i class="fas fa-times"></i> Xóa bộ lọc
        </a>
      </div>
      @endif
</aside>
    <!-- Danh sách sản phẩm -->
    <section class="product-list" aria-label="Danh sách sản phẩm giảm giá">
      <h2>SẢN PHẨM SALE-OFF</h2>

      <div class="products-grid" id="productsGrid">
        @forelse($products as $product)
        <article class="product-card">
          <a href="{{ route('product.detail', $product) }}" style="text-decoration: none; color: inherit;">
            <div class="product-badge">Giảm {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</div>
            @if($product->image)
              <img src="{{ asset('storage/' . $product->image) }}" 
                   alt="{{ $product->name }}" 
                   class="product-image"
                   onclick="openImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')"
                   style="cursor: zoom-in; background: white; padding: 15px; border-radius: 8px;" 
                   title="Click để phóng to" />
            @else
              <img src="https://via.placeholder.com/220x160?text=No+Image" alt="{{ $product->name }}" class="product-image" style="background: white; padding: 15px; border-radius: 8px;" />
            @endif
            <div class="product-info">
              <h3 class="product-title">{{ $product->name }}</h3>
              <p>
                <span class="product-price">{{ number_format($product->sale_price) }} đ</span> 
                <span class="product-price-old">{{ number_format($product->price) }} đ</span>
              </p>
            </div>
          </a>
        </article>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
          <p style="font-size: 1.2em; color: #999;">Hiện tại chưa có sản phẩm giảm giá nào</p>
        </div>
        @endforelse
      </div>
      
      @if($products->hasPages())
      <div style="margin-top: 30px; text-align: center;">
        {{ $products->links() }}
      </div>
      @endif
    </section>

  </div>
@include('partials.footer')
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
