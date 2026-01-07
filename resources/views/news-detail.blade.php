<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $news->title }} - VNB Sports</title>
    <meta name="description" content="{{ $news->excerpt }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <style>
        .news-detail-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .news-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e6560e;
        }
        
        .news-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .news-meta {
            display: flex;
            justify-content: center;
            gap: 30px;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .news-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .news-excerpt {
            font-size: 1.2rem;
            color: #555;
            font-style: italic;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .news-content {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 40px;
            margin-top: 40px;
        }
        
        .news-main {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        
        .news-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .news-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }
        
        .news-body h2, .news-body h3, .news-body h4 {
            color: #e6560e;
            margin: 30px 0 15px 0;
        }
        
        .news-body p {
            margin-bottom: 20px;
            text-align: justify;
        }
        
        .news-body ul, .news-body ol {
            margin: 20px 0;
            padding-left: 30px;
        }
        
        .news-body li {
            margin-bottom: 8px;
        }
        
        .news-sidebar {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        
        .sidebar-title {
            font-size: 1.3rem;
            color: #e6560e;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e6560e;
            font-weight: 600;
        }
        
        .related-news-item {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }
        
        .related-news-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 10px;
            margin: -10px;
            margin-bottom: 10px;
        }
        
        .related-news-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .related-news-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            flex-shrink: 0;
        }
        
        .related-news-content {
            flex: 1;
        }
        
        .related-news-title {
            font-size: 14px;
            font-weight: 500;
            line-height: 1.4;
            margin-bottom: 5px;
            color: #333;
        }
        
        .related-news-date {
            font-size: 12px;
            color: #999;
        }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #e6560e;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        
        .back-button:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(230, 86, 14, 0.3);
            color: white;
            text-decoration: none;
        }
        

        
        /* Responsive */
        @media (max-width: 768px) {
            .news-detail-container {
                padding: 0 15px;
            }
            
            .news-title {
                font-size: 1.8rem;
            }
            
            .news-meta {
                flex-direction: column;
                gap: 10px;
            }
            
            .news-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .news-main {
                padding: 20px;
            }
            
            .news-image {
                height: 250px;
            }
            
            .news-body {
                font-size: 1rem;
            }
            
            .news-sidebar {
                position: static;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')
    @include('partials.alerts')

    <div class="news-detail-container">
        <!-- Back Button -->
        <a href="{{ route('list-news') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Quay lại danh sách tin tức
        </a>

        <!-- News Header -->
        <div class="news-header">
            <h1 class="news-title">{{ $news->title }}</h1>
            
            <div class="news-meta">
                <div class="news-meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $news->published_at ? $news->published_at->format('d/m/Y') : $news->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="news-meta-item">
                    <i class="fas fa-user"></i>
                    <span>{{ $news->user->name ?? 'VNB Sports' }}</span>
                </div>
                <div class="news-meta-item">
                    <i class="fas fa-eye"></i>
                    <span>{{ rand(100, 1000) }} lượt xem</span>
                </div>
            </div>
            
            @if($news->excerpt)
            <div class="news-excerpt">
                {{ $news->excerpt }}
            </div>
            @endif
        </div>

        <!-- News Content -->
        <div class="news-content">
            <!-- Main Content -->
            <div class="news-main">
                @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="news-image">
                @endif
                
                <div class="news-body">
                    {!! nl2br(e($news->content)) !!}
                </div>
                

            </div>

            <!-- Sidebar -->
            <div class="news-sidebar">
                <h3 class="sidebar-title">
                    <i class="fas fa-newspaper"></i>
                    Tin tức liên quan
                </h3>
                
                @forelse($relatedNews as $item)
                <a href="{{ route('news.detail', $item) }}" class="related-news-item">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="related-news-image">
                    @else
                    <div class="related-news-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-newspaper" style="color: #ccc;"></i>
                    </div>
                    @endif
                    <div class="related-news-content">
                        <div class="related-news-title">{{ Str::limit($item->title, 60) }}</div>
                        <div class="related-news-date">
                            {{ $item->published_at ? $item->published_at->format('d/m/Y') : $item->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </a>
                @empty
                <p style="color: #999; text-align: center; padding: 20px;">
                    <i class="fas fa-info-circle"></i><br>
                    Chưa có tin tức liên quan
                </p>
                @endforelse
                
                <!-- Quick Links -->
                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <h4 style="color: #e6560e; margin-bottom: 15px; font-size: 1.1rem;">
                        <i class="fas fa-link"></i> Liên kết nhanh
                    </h4>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="{{ route('list-product') }}" style="color: #666; text-decoration: none; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                            <i class="fas fa-shopping-bag"></i> Sản phẩm cầu lông
                        </a>
                        <a href="{{ route('sale-off') }}" style="color: #666; text-decoration: none; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                            <i class="fas fa-fire"></i> Khuyến mãi hot
                        </a>
                        <a href="{{ route('contact') }}" style="color: #666; text-decoration: none; padding: 8px 0;">
                            <i class="fas fa-phone"></i> Liên hệ tư vấn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script>
        // Smooth scroll for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });
    </script>
</body>
</html>