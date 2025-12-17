# Script to update headers in all blade files
$files = @(
    "resources/views/list-product.blade.php",
    "resources/views/cart.blade.php",
    "resources/views/sale-off.blade.php",
    "resources/views/list-news.blade.php",
    "resources/views/news-detail.blade.php",
    "resources/views/checkout.blade.php",
    "resources/views/profile.blade.php"
)

foreach ($file in $files) {
    if (Test-Path $file) {
        Write-Host "Updating $file..."
        $content = Get-Content $file -Raw -Encoding UTF8
        
        # Replace header section with include
        $pattern = '(?s)<body>\s*<!-- Header top -->.*?</nav>'
        $replacement = '<body>
    @include(''partials.header'')'
        
        $content = $content -replace $pattern, $replacement
        
        Set-Content $file -Value $content -Encoding UTF8 -NoNewline
        Write-Host "Updated $file successfully"
    }
}

Write-Host "All files updated!"
