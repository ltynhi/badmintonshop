<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $product->name }} - Coza Shop</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/list-product.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
    
    <style>
    .user-menu {
        position: relative;
        display: inline-block;
    }
    
    .user-button {
        background: none;
        border: none;
        color: #333;
        cursor: pointer;
        padding: 8px 15px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    
    .user-button:hover {
        background-color: #f0f0f0;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
    }
    
    .user-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        min-width: 200px;
        margin-top: 8px;
        display: none;
        z-index: 1000;
    }
    
    .user-dropdown.show {
        display: block;
    }
    
    .user-dropdown a,
    .user-dropdown button {
        display: block;
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .user-dropdown a:hover,
    .user-dropdown button:hover {
        background-color: #f8f9fa;
    }
    
    .user-dropdown button.logout {
        color: #e74c3c;
        border-top: 1px solid #eee;
        font-weight: 500;
    }
    
    .header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .btn-login {
        padding: 8px 20px;
        background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
        color: white;
        text-decoration: none;
        border-radius: 20px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(230, 86, 14, 0.4);
    }
    
    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #e74c3c;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
    }
    
    .product-detail-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .product-main {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 50px;
    }
    
    .product-image-section {
        position: sticky;
        top: 20px;
        height: fit-content;
    }
    
    .product-main-image {
        width: 100%;
        height: 500px;
        object-fit: contain;
        background: white;
        border-radius: 10px;
        padding: 20px;
        cursor: zoom-in;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .product-main-image:hover {
        transform: scale(1.02);
    }
    
    .product-info-section {
        padding: 20px 0;
    }
    
    .product-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 15px;
    }
    
    .product-category {
        display: inline-block;
        padding: 5px 15px;
        background: #ecf0f1;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #7f8c8d;
        margin-bottom: 20px;
    }
    
    .product-price-section {
        background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
        color: white;
    }
    
    .price-current {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .price-old {
        font-size: 1.3rem;
        text-decoration: line-through;
        opacity: 0.7;
        margin-right: 15px;
    }
    
    .price-discount {
        display: inline-block;
        padding: 5px 15px;
        background: #e74c3c;
        border-radius: 20px;
        font-weight: bold;
    }
    
    .product-stock {
        margin-bottom: 20px;
        padding: 15px;
        background: #d4edda;
        border-radius: 8px;
        color: #155724;
    }
    
    .product-stock.out-of-stock {
        background: #f8d7da;
        color: #721c24;
    }
    
    .product-options {
        margin-bottom: 30px;
    }
    
    .option-group {
        margin-bottom: 25px;
    }
    
    .option-label {
        font-weight: 600;
        font-size: 1.1rem;
        color: #2c3e50;
        margin-bottom: 10px;
        display: block;
    }
    
    .option-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .option-btn {
        padding: 10px 20px;
        border: 2px solid #ddd;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .option-btn:hover {
        border-color: #e6560e;
        color: #e6560e;
    }
    
    .option-btn.active {
        border-color: #e6560e;
        background: #e6560e;
        color: white;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .quantity-input {
        display: flex;
        align-items: center;
        border: 2px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .quantity-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: #f8f9fa;
        cursor: pointer;
        font-size: 1.2rem;
        transition: all 0.2s ease;
    }
    
    .quantity-btn:hover {
        background: #e9ecef;
    }
    
    .quantity-value {
        width: 60px;
        height: 40px;
        border: none;
        text-align: center;
        font-size: 1.1rem;
        font-weight: bold;
    }
    
    .add-to-cart-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.2rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }
    
    .add-to-cart-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(230, 86, 14, 0.4);
    }
    
    .add-to-cart-btn:disabled {
        background: #95a5a6;
        cursor: not-allowed;
        transform: none;
    }
    
    .product-description {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 50px;
    }
    
    .description-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 3px solid #e6560e;
    }
    
    .related-products {
        margin-top: 50px;
    }
    
    .related-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 30px;
        text-align: center;
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }
    
    .related-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .related-image {
        width: 100%;
        height: 250px;
        object-fit: contain;
        background: #f8f9fa;
        padding: 20px;
    }
    
    .related-info {
        padding: 15px;
    }
    
    .related-name {
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 10px;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .related-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #e74c3c;
    }
</style>
</head>
<body>
    @include('partials.header')

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; text-align: center; border-bottom: 3px solid #28a745;">
            ✓ {{ session('success') }}
        </div>
    @endif

<div class="product-detail-container">
    <div class="product-main">
        <!-- Product Image -->
        <div class="product-image-section">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="product-main-image"
                     onclick="openImageModal(this.src, '{{ $product->name }}')"
                     title="Click để phóng to">
            @else
                <div class="product-main-image" style="display: flex; align-items: center; justify-content: center; font-size: 5rem; background: white;">
                    🏸
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="product-info-section">
            <h1 class="product-title">{{ $product->name }}</h1>
            
            <span class="product-category">📂 {{ $product->category->name }}</span>
            
            @if($product->brand)
                <span class="product-category" style="margin-left: 10px;">🏷️ {{ $product->brand }}</span>
            @endif

            <!-- Price -->
            <div class="product-price-section">
                <div class="price-current">{{ number_format($product->getCurrentPrice()) }}đ</div>
                @if($product->isOnSale())
                    <div>
                        <span class="price-old">{{ number_format($product->price) }}đ</span>
                        <span class="price-discount">Giảm {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                    </div>
                @endif
            </div>

            <!-- Stock Status -->
            <div class="product-stock {{ $product->stock <= 0 ? 'out-of-stock' : '' }}">
                @if($product->stock > 0)
                    ✓ Còn hàng ({{ $product->stock }} sản phẩm)
                @else
                    ✗ Hết hàng
                @endif
            </div>

            <form action="{{ route('cart.add', $product) }}" method="POST" id="addToCartForm">
                @csrf
                
                <!-- Product Options -->
                <div class="product-options">
                    @php
                        $categoryName = strtolower($product->category->name);
                    @endphp
                    
                    @if(str_contains($categoryName, 'vợt'))
                        <!-- Vợt options -->
                        <div class="option-group">
                            <label class="option-label">Chiều dài cán vợt:</label>
                            <div class="option-buttons">
                                <button type="button" class="option-btn active" data-option="200mm">200mm</button>
                                <button type="button" class="option-btn" data-option="205mm">205mm</button>
                                <button type="button" class="option-btn" data-option="210mm">210mm</button>
                            </div>
                            <input type="hidden" name="handle_length" value="200mm">
                        </div>
                        
                        <div class="option-group">
                            <label class="option-label">Trọng lượng:</label>
                            <div class="option-buttons">
                                <button type="button" class="option-btn active" data-option="3U">3U (85-89g)</button>
                                <button type="button" class="option-btn" data-option="4U">4U (80-84g)</button>
                                <button type="button" class="option-btn" data-option="5U">5U (75-79g)</button>
                            </div>
                            <input type="hidden" name="weight" value="3U">
                        </div>
                    @elseif(str_contains($categoryName, 'giày'))
                        <!-- Giày options -->
                        <div class="option-group">
                            <label class="option-label">Size giày:</label>
                            <div class="option-buttons">
                                <button type="button" class="option-btn" data-option="38">38</button>
                                <button type="button" class="option-btn" data-option="39">39</button>
                                <button type="button" class="option-btn active" data-option="40">40</button>
                                <button type="button" class="option-btn" data-option="41">41</button>
                                <button type="button" class="option-btn" data-option="42">42</button>
                                <button type="button" class="option-btn" data-option="43">43</button>
                            </div>
                            <input type="hidden" name="size" value="40">
                        </div>
                    @elseif(str_contains($categoryName, 'áo') || str_contains($categoryName, 'quần') || str_contains($categoryName, 'váy'))
                        <!-- Quần áo options -->
                        <div class="option-group">
                            <label class="option-label">Size:</label>
                            <div class="option-buttons">
                                <button type="button" class="option-btn" data-option="S">S</button>
                                <button type="button" class="option-btn active" data-option="M">M</button>
                                <button type="button" class="option-btn" data-option="L">L</button>
                                <button type="button" class="option-btn" data-option="XL">XL</button>
                                <button type="button" class="option-btn" data-option="XXL">XXL</button>
                            </div>
                            <input type="hidden" name="size" value="M">
                        </div>
                    @endif

                    <!-- Quantity -->
                    <div class="option-group">
                        <label class="option-label">Số lượng:</label>
                        <div class="quantity-selector">
                            <div class="quantity-input">
                                <button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="quantity-value" readonly>
                                <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                            </div>
                            <span style="color: #7f8c8d;">Tối đa: {{ $product->stock }}</span>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <button type="submit" class="add-to-cart-btn" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    🛒 {{ $product->stock > 0 ? 'THÊM VÀO GIỎ HÀNG' : 'HẾT HÀNG' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Product Description -->
    @if($product->description)
    <div class="product-description">
        <h2 class="description-title">📝 Mô tả sản phẩm</h2>
        <div style="line-height: 1.8; color: #555;">
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>
    @endif

    <!-- Reviews Section -->
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 50px;">
        <h2 style="color: #333; margin-bottom: 20px; font-size: 1.5rem;">⭐ Đánh giá sản phẩm</h2>
        
        <!-- Simple Rating Display -->
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <div style="font-size: 1.8rem; font-weight: bold; color: #e6560e;">
                {{ number_format($averageRating, 1) }}/5
            </div>
            <div style="color: #f39c12; font-size: 1.2rem;">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($averageRating))
                        ⭐
                    @else
                        ☆
                    @endif
                @endfor
            </div>
            <div style="color: #666; font-size: 0.9rem;">
                {{ $totalReviews }} đánh giá và nhận xét
            </div>
        </div>

        <!-- Review Form -->
        @auth
            @php
                $userReview = $reviews->where('user_id', Auth::id())->first();
            @endphp
            @if(!$userReview)
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <h3 style="margin-bottom: 15px; color: #333;">Viết đánh giá của bạn</h3>
                    <form action="{{ route('review.store', $product) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Đánh giá của bạn:</label>
                            <div class="star-rating" style="font-size: 1.5rem;">
                                <span class="star" data-rating="1" onclick="setRating(1)" style="cursor: pointer;">☆</span>
                                <span class="star" data-rating="2" onclick="setRating(2)" style="cursor: pointer;">☆</span>
                                <span class="star" data-rating="3" onclick="setRating(3)" style="cursor: pointer;">☆</span>
                                <span class="star" data-rating="4" onclick="setRating(4)" style="cursor: pointer;">☆</span>
                                <span class="star" data-rating="5" onclick="setRating(5)" style="cursor: pointer;">☆</span>
                            </div>
                            <input type="hidden" name="rating" id="rating" value="5" required>
                        </div>
                        
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nhận xét của bạn:</label>
                            <textarea name="comment" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; resize: vertical;" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..." required>{{ old('comment') }}</textarea>
                        </div>
                        
                        <button type="submit" style="padding: 10px 20px; background: #e6560e; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                            Gửi đánh giá
                        </button>
                    </form>
                </div>
            @endif
        @else
            <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                <p style="margin: 0;">Vui lòng <a href="{{ route('login') }}" style="color: #e6560e; font-weight: bold;">đăng nhập</a> để đánh giá sản phẩm</p>
            </div>
        @endauth

        <!-- Reviews List -->
        @if($reviews->count() > 0)
            <div>
                <h3 style="margin-bottom: 20px; color: #333;">Các đánh giá ({{ $totalReviews }})</h3>
                @foreach($reviews as $review)
                    <div style="border-bottom: 1px solid #eee; padding: 15px 0;">
                        <div style="display: flex; gap: 12px; margin-bottom: 8px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #e6560e; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: bold; margin-bottom: 3px;">{{ $review->user->name }}</div>
                                <div style="color: #f39c12; margin-bottom: 3px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <div style="color: #666; font-size: 0.85rem;">{{ $review->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        <div style="padding-left: 52px; color: #555; line-height: 1.5;">
                            {{ $review->comment }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 30px; color: #666;">
                <div style="font-size: 2rem; margin-bottom: 10px;">💬</div>
                <p>Chưa có đánh giá nào cho sản phẩm này</p>
            </div>
        @endif
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="related-products">
        <h2 class="related-title">🔗 Sản phẩm liên quan</h2>
        <div class="related-grid">
            @foreach($relatedProducts as $related)
            <div class="related-card" onclick="window.location='{{ route('product.detail', $related) }}'">
                @if($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="related-image">
                @else
                    <div class="related-image" style="display: flex; align-items: center; justify-content: center; font-size: 4rem;">🏸</div>
                @endif
                <div class="related-info">
                    <h3 class="related-name">{{ $related->name }}</h3>
                    <div class="related-price">{{ number_format($related->getCurrentPrice()) }}đ</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
    // Handle option buttons
    document.querySelectorAll('.option-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const group = this.closest('.option-group');
            group.querySelectorAll('.option-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const hiddenInput = group.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                hiddenInput.value = this.dataset.option;
            }
        });
    });

    // Quantity controls
    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    }

    // Star rating function
    function setRating(rating) {
        document.getElementById('rating').value = rating;
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.textContent = '⭐';
                star.style.color = '#f39c12';
            } else {
                star.textContent = '☆';
                star.style.color = '#ddd';
            }
        });
    }

    // Set default 5 stars on page load
    document.addEventListener('DOMContentLoaded', function() {
        setRating(5);
    });

</script>
</script>

<script>
    function toggleUserMenu() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('show');
    }
    
    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.user-menu')) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown) {
                dropdown.classList.remove('show');
            }
        }
    });
</script>

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
/* Image Modal Styles */
.image-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    animation: fadeIn 0.3s ease;
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
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
}

.image-modal-close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10000;
    background: rgba(0,0,0,0.5);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.image-modal-close:hover {
    background: rgba(0,0,0,0.8);
    transform: scale(1.1);
}

.image-modal-caption {
    color: white;
    text-align: center;
    margin-top: 20px;
    font-size: 18px;
    font-weight: 500;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Update product images in lists */
.product-card img,
.product-cardnew img,
.card_box img {
    background: white !important;
    padding: 10px;
    object-fit: contain;
}

.swiper-slide img {
    background: white !important;
    padding: 15px;
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
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});

// Prevent modal from closing when clicking on image
document.getElementById('modalImage').addEventListener('click', function(event) {
    event.stopPropagation();
});
</script>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
