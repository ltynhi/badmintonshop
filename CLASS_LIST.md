# 4.5 DANH SÁCH CÁC LỚP

## Lớp "User"

### Danh sách thuộc tính:

| STT | Tên thuộc tính | Ý nghĩa |
|-----|----------------|---------|
| 1 | id | Mã user |
| 2 | name | Tên user |
| 3 | email | Email đăng nhập |
| 4 | password | Mật khẩu |
| 5 | role | Vai trò user (admin/customer) |
| 6 | phone | Số điện thoại user |
| 7 | address | Địa chỉ user |
| 8 | email_verified_at | Thời gian xác thực email |
| 9 | remember_token | Token ghi nhớ đăng nhập |
| 10 | created_at | Thời gian tạo |
| 11 | updated_at | Thời gian cập nhật |

**Bảng 1: Danh sách thuộc tính Lớp "User"**

### Danh sách các phương thức:

| STT | Tên phương thức | Ý nghĩa |
|-----|-----------------|---------|
| 1 | isAdmin() | Kiểm tra user có phải admin |
| 2 | orders() | Lấy danh sách đơn hàng của user |
| 3 | news() | Lấy danh sách tin tức của user |
| 4 | notifications() | Lấy danh sách thông báo của user |
| 5 | unreadNotifications() | Lấy danh sách thông báo chưa đọc |

**Bảng 2: Danh sách phương thức Lớp "User"**

---

## Lớp "Product"

### Danh sách thuộc tính:

| STT | Tên thuộc tính | Ý nghĩa |
|-----|----------------|---------|
| 1 | id | Mã sản phẩm |
| 2 | category_id | Mã danh mục |
| 3 | name | Tên sản phẩm |
| 4 | slug | Đường dẫn thân thiện |
| 5 | description | Mô tả sản phẩm |
| 6 | price | Giá gốc |
| 7 | sale_price | Giá khuyến mãi |
| 8 | stock | Số lượng tồn kho |
| 9 | image | Hình ảnh chính |
| 10 | images | Danh sách hình ảnh |
| 11 | brand | Thương hiệu |
| 12 | is_featured | Sản phẩm nổi bật |
| 13 | is_active | Trạng thái hoạt động |
| 14 | created_at | Thời gian tạo |
| 15 | updated_at | Thời gian cập nhật |

**Bảng 3: Danh sách thuộc tính Lớp "Product"**

### Danh sách các phương thức:

| STT | Tên phương thức | Ý nghĩa |
|-----|-----------------|---------|
| 1 | category() | Lấy thông tin danh mục |
| 2 | orderItems() | Lấy danh sách order items |
| 3 | reviews() | Lấy danh sách đánh giá |
| 4 | approvedReviews() | Lấy danh sách đánh giá đã duyệt |
| 5 | getAverageRating() | Tính điểm đánh giá trung bình |
| 6 | getTotalReviews() | Đếm tổng số đánh giá |
| 7 | getCurrentPrice() | Lấy giá hiện tại |
| 8 | isOnSale() | Kiểm tra sản phẩm có giảm giá |

**Bảng 4: Danh sách phương thức Lớp "Product"**

---

## Lớp "Category"

### Danh sách thuộc tính:

| STT | Tên thuộc tính | Ý nghĩa |
|-----|----------------|---------|
| 1 | id | Mã danh mục |
| 2 | name | Tên danh mục |
| 3 | slug | Đường dẫn thân thiện |
| 4 | description | Mô tả danh mục |
| 5 | image | Hình ảnh danh mục |
| 6 | is_active | Trạng thái hoạt động |
| 7 | created_at | Thời gian tạo |
| 8 | updated_at | Thời gian cập nhật |

**Bảng 5: Danh sách thuộc tính Lớp "Category"**

### Danh sách các phương thức:

| STT | Tên phương thức | Ý nghĩa |
|-----|-----------------|---------|
| 1 | products() | Lấy danh sách sản phẩm trong danh mục |

**Bảng 6: Danh sách phương thức Lớp "Category"**

---

## Lớp "Order"

### Danh sách thuộc tính:

| STT | Tên thuộc tính | Ý nghĩa |
|-----|----------------|---------|
| 1 | id | Mã đơn hàng |
| 2 | user_id | Mã khách hàng |
| 3 | order_number | Số đơn hàng |
| 4 | customer_name | Tên khách hàng |
| 5 | customer_email | Email khách hàng |
| 6 | customer_phone | Số điện thoại khách hàng |
| 7 | customer_address | Địa chỉ giao hàng |
| 8 | subtotal | Tổng tiền hàng |
| 9 | shipping_fee | Phí vận chuyển |
| 10 | total | Tổng thanh toán |
| 11 | status | Trạng thái đơn hàng |
| 12 | payment_method | Phương thức thanh toán |
| 13 | payment_status | Trạng thái thanh toán |
| 14 | note | Ghi chú |
| 15 | created_at | Thời gian tạo |
| 16 | updated_at | Thời gian cập nhật |

**Bảng 7: Danh sách thuộc tính Lớp "Order"**

### Danh sách các phương thức:

| STT | Tên phương thức | Ý nghĩa |
|-----|-----------------|---------|
| 1 | user() | Lấy thông tin khách hàng |
| 2 | items() | Lấy danh sách sản phẩm trong đơn |
| 3 | getStatusLabelAttribute() | Lấy nhãn trạng thái tiếng Việt |

**Bảng 8: Danh sách phương thức Lớp "Order"**

---

## Lớp "OrderItem"

### Danh sách thuộc tính:

| STT | Tên thuộc tính | Ý nghĩa |
|-----|----------------|---------|
| 1 | id | Mã chi tiết đơn hàng |
| 2 | order_id | Mã đơn hàng |
| 3 | product_id | Mã sản phẩm |
| 4 | product_name | Tên sản phẩm |
| 5 | product_image | Hình ảnh sản phẩm |
| 6 | price | Giá sản phẩm |
| 7 | quantity | Số lượng |
| 8 | subtotal | Thành tiền |
| 9 | created_at | Thời gian tạo |
| 10 | updated_at | Thời gian cập nhật |

**Bảng 9: Danh sách thuộc tính Lớp "OrderItem"**

### Danh sách các phương thức:

| STT | Tên phương thức | Ý nghĩa |
|-----|-----------------|---------|
| 1 | order() | Lấy thông tin đơn hàng |
| 2 | product() | Lấy thông tin sản phẩm |

**Bảng 10: Danh sách phương thức Lớp "OrderItem"**

---

## Lớp "News"

### Danh sách thuộc tính:

| STT | Tên thuộc tính | Ý nghĩa |
|-----|----------------|---------|
| 1 | id | Mã tin tức |
| 2 | title | Tiêu đề tin tức |
| 3 | slug | Đường dẫn thân thiện |
| 4 | excerpt | Tóm tắt |
| 5 | content | Nội dung tin tức |
| 6 | image | Hình ảnh tin tức |
| 7 | user_id | Mã tác giả |
| 8 | is_published | Trạng thái xuất bản |
| 9 | published_at | Thời gian xuất bản |
| 10 | created_at | Thời gian tạo |
| 11 | updated_at | Thời gian cập nhật |

**Bảng 11: Danh sách thuộc tính Lớp "News"**

### Danh sách các phương thức:

| STT | Tên phương thức | Ý nghĩa |
|-----|-----------------|---------|
| 1 | user() | Lấy thông tin tác giả |

**Bảng 12: Danh sách phương thức Lớp "News"**

---

## Lớp "Review"

### Danh sách thuộc tính:

| STT | Tên thuộc tính | Ý nghĩa |
|-----|----------------|---------|
| 1 | id | Mã đánh giá |
| 2 | product_id | Mã sản phẩm |
| 3 | user_id | Mã khách hàng |
| 4 | rating | Điểm đánh giá (1-5) |
| 5 | comment | Nội dung đánh giá |
| 6 | is_approved | Trạng thái duyệt |
| 7 | created_at | Thời gian tạo |
| 8 | updated_at | Thời gian cập nhật |

**Bảng 13: Danh sách thuộc tính Lớp "Review"**

### Danh sách các phương thức:

| STT | Tên phương thức | Ý nghĩa |
|-----|-----------------|---------|
| 1 | product() | Lấy thông tin sản phẩm |
| 2 | user() | Lấy thông tin khách hàng |

**Bảng 14: Danh sách phương thức Lớp "Review"**

---

## Lớp "Notification"

### Danh sách thuộc tính:

| STT | Tên thuộc tính | Ý nghĩa |
|-----|----------------|---------|
| 1 | id | Mã thông báo |
| 2 | user_id | Mã người nhận |
| 3 | type | Loại thông báo |
| 4 | title | Tiêu đề thông báo |
| 5 | message | Nội dung thông báo |
| 6 | data | Dữ liệu bổ sung (JSON) |
| 7 | read_at | Thời gian đọc |
| 8 | created_at | Thời gian tạo |
| 9 | updated_at | Thời gian cập nhật |

**Bảng 15: Danh sách thuộc tính Lớp "Notification"**

### Danh sách các phương thức:

| STT | Tên phương thức | Ý nghĩa |
|-----|-----------------|---------|
| 1 | user() | Lấy thông tin người nhận |
| 2 | markAsRead() | Đánh dấu đã đọc |
| 3 | scopeUnread() | Lọc thông báo chưa đọc |
| 4 | getIconAttribute() | Lấy icon theo loại thông báo |
| 5 | getColorAttribute() | Lấy màu theo loại thông báo |

**Bảng 16: Danh sách phương thức Lớp "Notification"**
