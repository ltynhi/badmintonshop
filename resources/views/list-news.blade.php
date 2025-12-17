<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tin tức - Coza Shop</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}" />
    <link rel="stylesheet" href="{{ asset('css/list-news.css') }}?v={{ time() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>
<body>
    @include('partials.header')

    <main>
        <section class="info-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>THÔNG TIN TỔNG HỢP CẦU LÔNG</h2>
                @if(request('search'))
                <a href="{{ route('list-news') }}" style="padding: 8px 16px; background: #e74c3c; color: white; text-decoration: none; border-radius: 5px; font-size: 14px;">
                    <i class="fas fa-times"></i> Xóa tìm kiếm
                </a>
                @endif
            </div>
            
            <!-- Form tìm kiếm tin tức - KHÔNG được xóa -->
            <form method="GET" action="{{ route('list-news') }}" id="newsSearchForm" style="margin-bottom: 30px; display: flex !important; align-items: center; gap: 10px; background: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <label for="keyword" style="font-weight: bold; font-size: 14px; color: #333; min-width: 80px;">Từ khóa:</label>
                <input type="text" 
                       id="keyword" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nhập từ khóa tìm kiếm tin tức..." 
                       style="flex-grow: 1; padding: 10px 15px; border: 2px solid #ddd; border-radius: 6px; font-size: 14px; transition: all 0.3s ease;" />
                <button type="submit" style="background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%); border: none; color: white; padding: 10px 24px; font-weight: bold; border-radius: 6px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(230, 86, 14, 0.3);">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </form>
            
            @if(request('search'))
            <div style="margin-bottom: 20px; padding: 12px; background: #e7f3ff; border-left: 4px solid #2196F3; border-radius: 4px;">
                <strong>Kết quả tìm kiếm cho:</strong> "{{ request('search') }}" 
                <span style="color: #666;">({{ $news->total() }} kết quả)</span>
            </div>
            @endif

            <div class="card-list">
                @forelse($news as $item)
                <article class="card">
                    <a href="{{ route('news.detail', $item) }}" style="text-decoration: none; color: inherit;">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" />
                        @else
                            <img src="https://via.placeholder.com/400x250?text=No+Image" alt="{{ $item->title }}" />
                        @endif
                        <div class="card-content">
                            <h3>{{ $item->title }}</h3>
                            <div class="date-time">{{ $item->published_at ? $item->published_at->format('d-m-Y H:i') : $item->created_at->format('d-m-Y H:i') }}</div>
                            <p>{{ $item->excerpt ?? Str::limit(strip_tags($item->content), 150) }}</p>
                        </div>
                    </a>
                </article>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    @if(request('search'))
                        <div style="font-size: 3rem; opacity: 0.3; margin-bottom: 20px;">🔍</div>
                        <p style="font-size: 1.2em; color: #999;">Không tìm thấy tin tức nào với từ khóa "{{ request('search') }}"</p>
                        <a href="{{ route('list-news') }}" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #e6560e; color: white; text-decoration: none; border-radius: 5px;">
                            Xem tất cả tin tức
                        </a>
                    @else
                        <p style="font-size: 1.2em; color: #999;">Chưa có tin tức nào</p>
                    @endif
                </div>
                @endforelse
            </div>
            
            @if($news->hasPages())
            <div style="margin-top: 30px; text-align: center;">
                {{ $news->links() }}
            </div>
            @endif
        </section>


    </main>
    
@include('partials.footer')
<button id="scrollToTopBtn" aria-label="Scroll to top">&#8679;</button>

</body>
</html>
