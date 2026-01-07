<!DOCTYPE html>
<html>
<head>
    <title>Test Review Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        .star-rating { font-size: 1.5rem; margin: 10px 0; }
        .star { cursor: pointer; margin-right: 5px; }
        textarea { width: 100%; padding: 10px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-top: 5px; }
        .success { color: green; padding: 10px; background: #d4edda; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Test Review Form</h2>
    <p>Product: {{ $product->name }}</p>
    <p>User: {{ Auth::user()->name ?? 'Not logged in' }}</p>
    
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
    
    <form action="{{ route('review.store', $product) }}" method="POST" id="reviewForm">
        @csrf
        
        <div class="form-group">
            <label>Rating:</label>
            <div class="star-rating">
                <span class="star" data-rating="1" onclick="setRating(1)">☆</span>
                <span class="star" data-rating="2" onclick="setRating(2)">☆</span>
                <span class="star" data-rating="3" onclick="setRating(3)">☆</span>
                <span class="star" data-rating="4" onclick="setRating(4)">☆</span>
                <span class="star" data-rating="5" onclick="setRating(5)">☆</span>
            </div>
            <input type="hidden" name="rating" id="rating" value="5">
            @error('rating')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Comment:</label>
            <textarea name="comment" rows="4" placeholder="Enter your review (min 10 characters)">{{ old('comment') }}</textarea>
            @error('comment')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit">Submit Review</button>
    </form>
    
    <hr>
    <h3>Test with AJAX</h3>
    <button onclick="submitWithAjax()">Submit with AJAX</button>
    
    <div id="ajaxResult"></div>

    <script>
        function setRating(rating) {
            console.log('Setting rating to:', rating);
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

        // Set default rating
        document.addEventListener('DOMContentLoaded', function() {
            setRating(5);
            
            // Add form submit handler
            document.getElementById('reviewForm').addEventListener('submit', function(e) {
                const rating = document.getElementById('rating').value;
                const comment = document.querySelector('textarea[name="comment"]').value;
                
                console.log('Form submitting:');
                console.log('Rating:', rating);
                console.log('Comment:', comment);
                console.log('Comment length:', comment.length);
                
                if (!comment || comment.trim().length < 10) {
                    e.preventDefault();
                    alert('Comment must be at least 10 characters');
                    return false;
                }
            });
        });
        
        function submitWithAjax() {
            const rating = document.getElementById('rating').value;
            const comment = document.querySelector('textarea[name="comment"]').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('/test-review-submit/{{ $product->id }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    rating: rating,
                    comment: comment
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('ajaxResult').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('ajaxResult').innerHTML = '<div class="error">Error: ' + error + '</div>';
            });
        }
    </script>
</body>
</html>