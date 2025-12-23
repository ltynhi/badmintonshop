@echo off
echo 🏸 Badminton Shop - Auto Setup Script
echo ======================================

REM Kiểm tra PHP
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PHP không được tìm thấy. Vui lòng cài đặt PHP >= 8.1
    pause
    exit /b 1
)

REM Kiểm tra Composer
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Composer không được tìm thấy. Vui lòng cài đặt Composer
    pause
    exit /b 1
)

REM Kiểm tra Node.js
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Node.js không được tìm thấy. Vui lòng cài đặt Node.js
    pause
    exit /b 1
)

echo ✅ Kiểm tra dependencies thành công

REM Cài đặt PHP dependencies
echo 📦 Đang cài đặt PHP dependencies...
composer install

REM Cài đặt Node.js dependencies
echo 📦 Đang cài đặt Node.js dependencies...
npm install

REM Copy .env file
if not exist .env (
    echo 📝 Tạo file .env...
    copy .env.example .env
) else (
    echo ⚠️  File .env đã tồn tại
)

REM Generate application key
echo 🔑 Tạo application key...
php artisan key:generate

REM Create storage link
echo 🔗 Tạo storage link...
php artisan storage:link

REM Build assets
echo 🎨 Build assets...
npm run build

echo.
echo ✅ Setup hoàn tất!
echo.
echo 📋 Các bước tiếp theo:
echo 1. Cấu hình database trong file .env
echo 2. Tạo database: CREATE DATABASE badminton_shop;
echo 3. Chạy migration: php artisan migrate
echo 4. Chạy seeder: php artisan db:seed
echo 5. Khởi động server: php artisan serve
echo.
echo 🎯 Tài khoản mặc định:
echo    Admin: admin@admin.com / 123456
echo    Customer: customer@test.com / 123456
echo.
echo 🚀 Chúc bạn thành công!
pause