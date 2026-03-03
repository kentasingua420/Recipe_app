<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            max-width: 100vw;
            width: 100%;
            min-height: 100vh;
            align-items: stretch;
            background: #f8f9fa;
        }

        .image-section {
            display: flex;
            justify-content: center;
            align-items: stretch;
            min-height: 100vh;
            overflow: hidden;
            background: #ffffff;
        }

        .image-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0;
            box-shadow: none;
        }

        .form-section {
            background: white;
            padding: 60px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 480px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 40px auto;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .logo {
            width: 48px;
            height: 48px;
            background: #dc3545;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f9f9f9;
        }

        .form-group input:focus {
            outline: none;
            border-color: #dc3545;
            background: white;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            font-size: 14px;
        }

        .remember-forgot a {
            color: #dc3545;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .remember-forgot a:hover {
            color: #c82333;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
        }

        .checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #dc3545;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .login-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(220, 53, 69, 0.2);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            color: #999;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .social-login {
            display: flex;
            gap: 16px;
            justify-content: center;
            margin-bottom: 28px;
        }

        .social-btn {
            width: 48px;
            height: 48px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            border-color: #dc3545;
            background: #fff5f5;
            transform: translateY(-2px);
        }

        .signup-link {
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .signup-link a {
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #c82333;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .image-section {
                display: none;
            }

            .form-section {
                padding: 30px;
                border-radius: 0;
            }

            .form-header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-section">
            <img src="{{ asset('image/login2.jpg') }}" alt="Fresh food">
        </div>

        <div class="form-section">
            <div class="form-header">
                <div class="logo">
                    <img src="{{ asset('image/logologo.jpg') }}" alt="RecipeNest Logo" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                </div>
                <h1>Welcome Back</h1>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                    @error('email') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                    @error('password') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="remember-forgot">
                    <label class="checkbox">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn">Sign In</button>

                <div class="divider">OR</div>

                <div class="social-login">
                    <button type="button" class="social-btn" title="Google">G</button>
                    <button type="button" class="social-btn" title="Facebook">f</button>
                    <button type="button" class="social-btn" title="Apple">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                        </svg>
                    </button>
                </div>

                <div class="signup-link">
                    Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>