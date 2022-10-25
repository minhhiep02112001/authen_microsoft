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
                <img class="img-fluid login-slogan" src="/images/slogan.png" alt=""/>
                <hr class="login-divider">
                <img class="img-fluid login-brands" src="/images/brands.png" alt=""/>
            </div>
            <div class="login-form">
                <img class="img-fluid login-form-logo" src="/images/logo.svg" alt=""/>
                <a class="btn-back" href="/forgot-password">
                    <button class="btn btn-light btn-square" type="button">
                        <img class="img-fluid" src="/images/chevron-left.svg" alt=""/>
                    </button>
                    Quay lại
                </a>
                <div class="login-form-header">
                    <h2 class="modal-title mb-1">Lấy lại mật khẩu</h2>
                </div>
                <form class="login-form-groups" method="POST"
                      action="{{route('post.reset.password', ['token' => $token])}}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label visually-hidden" for="login-form-password">Mật khẩu mới</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="login-form-password"
                               name="password" type="password"
                               placeholder="Mật khẩu mới"/>

                        @error('password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label class="form-label visually-hidden" for="login-form-password-confirm">Nhập lại mật
                            khẩu</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="login-form-password-confirm"
                               name="password_confirmation" type="password" placeholder="Nhập lại mật khẩu"/>

                    </div>
                    <div class="login-form-btn-group">
                        <div class="form-group d-grid">
                            <button class="btn btn-primary fw-bold" type="submit">Thay đổi mật khẩu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
