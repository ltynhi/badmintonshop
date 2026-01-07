# 🛍️ COZA Store - Hệ thống quản lý cửa hàng trực tuyến

Hệ thống website bán hàng trực tuyến COZA Store được xây dựng bằng Laravel với giao diện hiện đại và tính năng đầy đủ.

## 🚀 Tính năng chính

- ✅ **Quản lý sản phẩm** - Danh mục, sản phẩm, hình ảnh
- ✅ **Hệ thống người dùng** - Đăng ký, đăng nhập, profile
- ✅ **Giỏ hàng & Thanh toán** - Đặt hàng, quản lý đơn hàng
- ✅ **Đánh giá sản phẩm** - Hệ thống review với duyệt
- ✅ **Tin tức** - Quản lý bài viết tin tức
- ✅ **Liên hệ** - Form liên hệ với email tự động
- ✅ **Admin Panel** - Quản trị toàn diện
- ✅ **Responsive Design** - Tối ưu mobile

## 📋 Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Apache/Nginx

## 🛠️ Hướng dẫn cài đặt

### Cách 1: Sử dụng Auto Setup Script (Khuyến nghị)

#### Linux/Mac:
```bash
git clone https://github.com/ltynhi/coza-store.git
cd coza-store
chmod +x setup.sh
./setup.sh
```

#### Windows:
```bash
git clone https://github.com/ltynhi/coza-store.git
cd coza-store
setup.bat
```

### Cách 2: Cài đặt thủ công

#### 1. Clone repository

```bash
git clone https://github.com/ltynhi/coza-store.git
cd coza-store
```

#### 2. Cài đặt dependencies

```bash
# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies
npm install
```

#### 3. Cấu hình môi trường

```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Cấu hình database

Mở file `.env` và cập nhật thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=badminton_shop
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Tạo database và chạy migration

```bash
# Tạo database (MySQL)
mysql -u root -p
CREATE DATABASE badminton_shop;
exit

# Chạy migration
php artisan migrate

# Chạy seeder (dữ liệu mẫu)
php artisan db:seed
```

#### 6. Tạo symbolic link cho storage

```bash
php artisan storage:link
```

#### 7. Build assets

```bash
npm run build
# hoặc cho development
npm run dev
```

#### 8. Chạy server

```bash
php artisan serve
```

Website sẽ chạy tại: `http://localhost:8000`

## 👤 Tài khoản mặc định

### Admin
- **Email:** admin@admin.com
- **Password:** 123456

### Customer
- **Email:** customer@test.com  
- **Password:** 123456

## 📁 Cấu trúc thư mục

```
badmintonshop/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Models
│   └── ...
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Database seeders
│   └── ...
├── public/
│   ├── css/                # CSS files
│   ├── js/                 # JavaScript files
│   └── storage/            # Uploaded files
├── resources/
│   ├── views/              # Blade templates
│   └── ...
└── routes/
    └── web.php             # Web routes
```

## 🎨 Tính năng nổi bật

### Frontend
- **Giao diện hiện đại** với gradient và animations
- **Responsive design** tối ưu mobile
- **Trang hướng dẫn** chọn vợt cầu lông chi tiết
- **Hệ thống đánh giá** sản phẩm với sao
- **Giỏ hàng Ajax** không reload trang

### Backend  
- **Admin dashboard** quản lý toàn diện
- **Quản lý đơn hàng** với nhiều trạng thái
- **Hệ thống email** tự động
- **Upload hình ảnh** với validation
- **Phân quyền** admin/customer

## 🔧 Cấu hình bổ sung

### Email Configuration
Cập nhật thông tin email trong `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Badminton Shop"
```

### File Upload
Đảm bảo thư mục storage có quyền ghi:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 🐛 Troubleshooting

### Lỗi thường gặp:

1. **500 Internal Server Error**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

2. **Storage link không hoạt động**
   ```bash
   php artisan storage:link --force
   ```

3. **Permission denied (Linux/Mac)**
   ```bash
   sudo chown -R www-data:www-data storage
   sudo chown -R www-data:www-data bootstrap/cache
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

4. **Database connection failed**
   - Kiểm tra MySQL/MariaDB đã chạy chưa
   - Kiểm tra thông tin database trong `.env`
   - Đảm bảo database đã được tạo

5. **Composer install failed**
   ```bash
   composer install --ignore-platform-reqs
   ```

6. **NPM install failed**
   ```bash
   npm cache clean --force
   npm install
   ```

### ⚠️ Lưu ý quan trọng:

- **Đảm bảo PHP >= 8.1** và các extension cần thiết đã được cài đặt
- **Tạo database trước** khi chạy migration
- **Chạy seeder** để có dữ liệu mẫu
- **Build assets** trước khi chạy website
- **Cấu hình email** nếu muốn sử dụng tính năng gửi mail

## 📞 Hỗ trợ

Nếu gặp vấn đề, vui lòng:
1. Kiểm tra file log: `storage/logs/laravel.log`
2. Đảm bảo đã cài đặt đúng PHP version
3. Kiểm tra database connection
4. Xem lại các bước cài đặt

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Developed with ❤️ by ltynhi**