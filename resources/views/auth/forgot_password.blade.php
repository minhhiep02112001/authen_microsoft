<!DOCTYPE html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quên mật khẩu - IMAP ID</title>
    <meta name="author" content="TUTA">
    <meta name="description" content="IMAP ID">
    <meta name="keywords" content="IMAP ID">
    <meta name="viewport" content="width=device-width initial-scale=1">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
    <link rel="stylesheet" href="/css/style.min.css">
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
                <a class="btn-back" href="/login">
                    <button class="btn btn-light btn-square" type="button">
                        <img class="img-fluid" src="/images/chevron-left.svg" alt="" />
                    </button>Quay lại
                </a>
                <div class="login-form-header">
                    <h2 class="modal-title mb-1">Tìm tài khoản của bạn</h2>
                    <p class="text-muted">Vui lòng nhập địa chỉ email để tìm kiếm tài khoản của bạn</p>
                </div>
                <form class="login-form-groups" method="POST" action="/forgot-password?<%=params%>">
                    @csrf
                    <div class="form-group">
                        <label class="form-label visually-hidden" for="login-form-otp">Nhập email hoặc phone</label>
                        <input class="form-control" id="login-form-otp" type="text" name="email" placeholder="Nhập email hoặc phone" />
                        @if(session()->has('notification_error'))
                            <div class="invalid-feedback d-block">{{ session()->get('notification_error') }}</div>
                        @endif
                    </div>
                    <div class="login-form-btn-group">
                        <div class="form-group d-grid">
                            <button class="btn btn-primary fw-bold" type="submit">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
