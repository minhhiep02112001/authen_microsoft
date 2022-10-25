<!DOCTYPE html>
<html class="no-js" lang="vi">

<head>
    <meta charset="utf-8">
    <title>Đăng nhập - IMAP ID</title>
    <meta name="author" content="TUTA">
    <meta name="description" content="IMAP ID">
    <meta name="keywords" content="IMAP ID">
    <meta name="viewport" content="width=device-width initial-scale=1">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
</head>

<body>
    <div class="page">
        <div class="login">
            <div class="container">
                <div class="login-left">
                    <img class="img-fluid login-slogan" src="/images/slogan.png" alt="" />
                    <hr class="login-divider">
                    <img class="img-fluid login-brands" src="/images/brands.png" alt="" />
                </div>
                <div class="login-form">
                    <img class="img-fluid login-form-logo" src="/images/logo.svg" alt="" />

                    <form class="login-form-groups" id="login" method="POST" action="{{ route('post.login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label visually-hidden" for="login-form-email">Email</label>
                            <input class="form-control is-invalid" id="login-form-email" name="email_phone"
                                type="text" placeholder="Email hoặc số điện thoại"
                                value="{{ old('email_phone') }}" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="login-form-btn-group">
                            <div class="form-group d-grid">
                                <button class="btn btn-primary fw-bold" type="submit">Tiếp theo</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>

</html>
