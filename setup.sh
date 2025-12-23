#!/bin/bash

echo "🏸 Badminton Shop - Auto Setup Script"
echo "======================================"

# Kiểm tra PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP không được tìm thấy. Vui lòng cài đặt PHP >= 8.1"
    exit 1
fi

# Kiểm tra Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer không được tìm thấy. Vui lòng cài đặt Composer"
    exit 1
fi

# Kiểm tra Node.js
if ! command -v node &> /dev/null; then
    echo "❌ Node.js không được tìm thấy. Vui lòng cài đặt Node.js"
    exit 1
fi

echo "✅ Kiểm tra dependencies thành công"

# Cài đặt PHP dependencies
echo "📦 Đang cài đặt PHP dependencies..."
composer install

# Cài đặt Node.js dependencies  
echo "📦 Đang cài đặt Node.js dependencies..."
npm install

# Copy .env file
if [ ! -f .env ]; then
    echo "📝 Tạo file .env..."
    cp .env.example .env
else
    echo "⚠️  File .env đã tồn tại"
fi

# Generate application key
echo "🔑 Tạo application key..."
php artisan key:generate

# Create storage link
echo "🔗 Tạo storage link..."
php artisan storage:link

# Build assets
echo "🎨 Build assets..."
npm run build

echo ""
echo "✅ Setup hoàn tất!"
echo ""
echo "📋 Các bước tiếp theo:"
echo "1. Cấu hình database trong file .env"
echo "2. Tạo database: CREATE DATABASE badminton_shop;"
echo "3. Chạy migration: php artisan migrate"
echo "4. Chạy seeder: php artisan db:seed"
echo "5. Khởi động server: php artisan serve"
echo ""
echo "🎯 Tài khoản mặc định:"
echo "   Admin: admin@admin.com / 123456"
echo "   Customer: customer@test.com / 123456"
echo ""
echo "🚀 Chúc bạn thành công!"