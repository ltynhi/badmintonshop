# Biểu đồ Class Tổng quát - Hệ thống E-commerce Laravel

## Mô tả hệ thống
Đây là hệ thống thương mại điện tử được xây dựng bằng Laravel với các chức năng chính:
- Quản lý sản phẩm và danh mục
- Hệ thống đặt hàng và thanh toán
- Quản lý người dùng và phân quyền
- Hệ thống đánh giá sản phẩm
- Quản lý tin tức và thông báo
- Hệ thống liên hệ

## Biểu đồ Class (PlantUML)

```plantuml
@startuml
!define ENTITY class
!define CONTROLLER class
!define SERVICE class

package "Models" {
    ENTITY User {
        +id: int
        +name: string
        +email: string
        +password: string
        +role: string
        +phone: string
        +address: string
        +email_verified_at: datetime
        +remember_token: string
        --
        +isAdmin(): bool
        +orders(): HasMany
        +news(): HasMany
        +notifications(): HasMany
        +unreadNotifications(): HasMany
    }

    ENTITY Category {
        +id: int
        +name: string
        +slug: string
        +description: text
        +image: string
        +is_active: boolean
        --
        +products(): HasMany
    }

    ENTITY Product {
        +id: int
        +category_id: int
        +name: string
        +slug: string
        +description: text
        +price: int
        +sale_price: int
        +stock: int
        +image: string
        +images: array
        +brand: string
        +is_featured: boolean
        +is_active: boolean
        --
        +category(): BelongsTo
        +orderItems(): HasMany
        +reviews(): HasMany
        +approvedReviews(): HasMany
        +getAverageRating(): float
        +getTotalReviews(): int
        +getCurrentPrice(): int
        +isOnSale(): bool
    }

    ENTITY Order {
        +id: int
        +user_id: int
        +order_number: string
        +customer_name: string
        +customer_email: string
        +customer_phone: string
        +customer_address: string
        +subtotal: int
        +shipping_fee: int
        +total: int
        +status: string
        +payment_method: string
        +payment_status: string
        +note: text
        --
        +user(): BelongsTo
        +items(): HasMany
        +orderItems(): HasMany
        +getStatusLabelAttribute(): string
    }

    ENTITY OrderItem {
        +id: int
        +order_id: int
        +product_id: int
        +product_name: string
        +price: decimal
        +quantity: int
        +total: decimal
        --
        +order(): BelongsTo
        +product(): BelongsTo
    }

    ENTITY Review {
        +id: int
        +product_id: int
        +user_id: int
        +rating: int
        +comment: text
        +is_approved: boolean
        --
        +product(): BelongsTo
        +user(): BelongsTo
    }

    ENTITY News {
        +id: int
        +title: string
        +slug: string
        +excerpt: text
        +content: text
        +image: string
        +user_id: int
        +is_published: boolean
        +published_at: datetime
        --
        +user(): BelongsTo
    }

    ENTITY Contact {
        +id: int
        +name: string
        +email: string
        +phone: string
        +message: text
        +status: string
        +admin_reply: text
        +replied_at: datetime
        +replied_by: int
        --
        +repliedBy(): BelongsTo
        +getStatusTextAttribute(): string
        +getStatusColorAttribute(): string
    }

    ENTITY Notification {
        +id: int
        +user_id: int
        +type: string
        +title: string
        +message: text
        +data: array
        +read_at: datetime
        --
        +user(): BelongsTo
        +markAsRead(): void
        +scopeUnread(): Builder
        +getIconAttribute(): string
        +getColorAttribute(): string
    }
}

package "Controllers" {
    CONTROLLER AuthController {
        +login()
        +register()
        +logout()
        +profile()
        +updateProfile()
    }

    CONTROLLER AdminAuthController {
        +login()
        +logout()
        +dashboard()
    }

    CONTROLLER CartController {
        +index()
        +add()
        +update()
        +remove()
        +clear()
    }

    CONTROLLER CheckoutController {
        +index()
        +process()
        +success()
    }

    CONTROLLER OrderController {
        +index()
        +show()
        +create()
        +update()
        +cancel()
    }

    CONTROLLER ReviewController {
        +store()
        +approve()
        +reject()
    }

    CONTROLLER NotificationController {
        +index()
        +markAsRead()
        +markAllAsRead()
    }

    CONTROLLER ContactController {
        +store()
        +reply()
        +updateStatus()
    }

    CONTROLLER PageController {
        +home()
        +products()
        +productDetail()
        +news()
        +newsDetail()
        +contact()
    }

    CONTROLLER SearchController {
        +search()
        +suggestions()
    }

    CONTROLLER PasswordResetController {
        +sendResetLink()
        +reset()
    }
}

package "Mail" {
    SERVICE WelcomeEmail {
        +user: User
        +build(): Mailable
    }
}

' Relationships
User ||--o{ Order : "has many"
User ||--o{ Review : "has many"
User ||--o{ News : "has many"
User ||--o{ Notification : "has many"
User ||--o{ Contact : "replied by"

Category ||--o{ Product : "has many"

Product ||--o{ OrderItem : "has many"
Product ||--o{ Review : "has many"
Product }o--|| Category : "belongs to"

Order ||--o{ OrderItem : "has many"
Order }o--|| User : "belongs to"

OrderItem }o--|| Order : "belongs to"
OrderItem }o--|| Product : "belongs to"

Review }o--|| Product : "belongs to"
Review }o--|| User : "belongs to"

News }o--|| User : "belongs to"

Notification }o--|| User : "belongs to"

Contact }o--|| User : "replied by"

@enduml
```

## Mô tả các thành phần chính

### 1. User Management
- **User**: Quản lý thông tin người dùng, phân quyền admin/customer
- **AuthController**: Xử lý đăng nhập, đăng ký, quản lý profile
- **AdminAuthController**: Xử lý đăng nhập admin riêng biệt

### 2. Product Management
- **Category**: Danh mục sản phẩm với slug và trạng thái
- **Product**: Sản phẩm với thông tin chi tiết, giá, kho, hình ảnh
- **Review**: Đánh giá sản phẩm từ khách hàng

### 3. Order Management
- **Order**: Đơn hàng với thông tin khách hàng và trạng thái
- **OrderItem**: Chi tiết sản phẩm trong đơn hàng
- **CartController**: Quản lý giỏ hàng
- **CheckoutController**: Xử lý thanh toán

### 4. Communication
- **News**: Tin tức và bài viết
- **Contact**: Liên hệ từ khách hàng
- **Notification**: Thông báo hệ thống
- **WelcomeEmail**: Email chào mừng

### 5. Support Features
- **SearchController**: Tìm kiếm sản phẩm
- **PasswordResetController**: Đặt lại mật khẩu
- **PageController**: Các trang chính của website

## Mối quan hệ chính
1. **User** có nhiều **Order**, **Review**, **News**, **Notification**
2. **Category** có nhiều **Product**
3. **Product** thuộc về **Category**, có nhiều **OrderItem** và **Review**
4. **Order** thuộc về **User** và có nhiều **OrderItem**
5. **OrderItem** liên kết **Order** và **Product**

## Đặc điểm kỹ thuật
- Sử dụng Laravel Eloquent ORM cho các mối quan hệ
- Tự động tạo slug cho Category, Product, News
- Hệ thống phân quyền đơn giản (admin/user)
- Quản lý trạng thái đơn hàng và thanh toán
- Hệ thống thông báo với nhiều loại khác nhau