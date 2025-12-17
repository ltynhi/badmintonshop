@echo off
echo ========================================
echo CAI DAT WEB BAN CAU LONG
echo ========================================
echo.

echo [1/4] Cai dat dependencies...
call composer install
echo.

echo [2/4] Chay migrations va tao du lieu mau...
php artisan migrate:fresh --seed
echo.

echo [3/4] Tao symbolic link cho storage...
php artisan storage:link
echo.

echo [4/4] Clear cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo.

echo ========================================
echo CAI DAT HOAN TAT!
echo ========================================
echo.
echo TAI KHOAN ADMIN:
echo Email: admin@admin.com
echo Password: 123456
echo.
echo TAI KHOAN KHACH HANG:
echo Email: customer@test.com
echo Password: 123456
echo.
echo Chay lenh: php artisan serve
echo Sau do truy cap: http://localhost:8000
echo.
pause
