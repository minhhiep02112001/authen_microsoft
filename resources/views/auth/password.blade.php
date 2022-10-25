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
    <link rel="stylesheet" href="{{asset('css/style.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <div class="login-form-header">
                    <h2 class="modal-title mb-1" style="text-align: center">Chào mừng</h2>
                    <p class="mb-4" style="text-align: center"><i class="fa fa-user" style="font-size:24px"></i>  {{$email_phone??''}}</a>
                    </p>
                </div>
                <form class="login-form-groups" method="POST" action="{{route('post.login')}}">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="_id" value="{{$_id}}">
                        <label class="form-label visually-hidden" for="login-form-email">Mật khẩu</label>
                        <input class="form-control is-invalid" required id="password" name="password" type="password"
                               placeholder="Mật khẩu"/>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if (session('notification_error'))
                            <div class="invalid-feedback">{{ session('notification_error') }}</div>
                        @endif
                    </div>
                    <div class="login-form-btn-group">
                        <div class="form-group d-grid">
                            <button class="btn btn-primary fw-bold" type="submit">Đăng nhập</button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px">
                        <div class="form-text text-end">
                            <a href="/forgot-password">Quên mật khẩu?</a>
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
