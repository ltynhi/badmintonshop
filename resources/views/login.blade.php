<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng nhập - Coza Shop</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }

        .login-header {
            background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
            color: white;
            text-align: center;
            padding: 40px 30px;
        }

        .login-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .login-form {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #e6560e;
            box-shadow: 0 0 0 3px rgba(230, 86, 14, 0.1);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(230, 86, 14, 0.3);
        }

        .form-links {
            text-align: center;
        }

        .form-links a {
            color: #e6560e;
            text-decoration: none;
            font-weight: 500;
            margin: 0 10px;
        }

        .form-links a:hover {
            text-decoration: underline;
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: #999;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
        }

        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-home:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: #efe;
            color: #363;
            border: 1px solid #cfc;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
            
            .login-form {
                padding: 30px 20px;
            }
            
            .back-home {
                top: 10px;
                left: 10px;
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <a href="{{ route('home') }}" class="back-home">
        <i class="fas fa-arrow-left"></i> Về trang chủ
    </a>

    <div class="login-container">
        <div class="login-header">
            <h1>Đăng nhập</h1>
            <p>Chào mừng bạn trở lại Coza Shop</p>
        </div>

        <div class="login-form">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Nhập email của bạn"
                           required 
                           autocomplete="email" 
                           autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Nhập mật khẩu"
                           required 
                           autocomplete="current-password">
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" 
                               name="remember" 
                               style="margin-right: 8px; width: auto;">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>

            <div class="divider">
                <span>hoặc</span>
            </div>

            <div class="form-links">
                <a href="{{ route('register') }}">
                    <i class="fas fa-user-plus"></i> Đăng ký tài khoản
                </a>
                |
                <a href="{{ route('forgot-pass') }}">
                    <i class="fas fa-key"></i> Quên mật khẩu?
                </a>
            </div>
        </div>
    </div>
</body>
</html>