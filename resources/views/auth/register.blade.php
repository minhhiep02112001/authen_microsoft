<!DOCTYPE html>
<html class="no-js" lang="vi">

<head>
    <meta charset="utf-8">
    <title>Đăng ký tài khoản - IMAP ID</title>
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
                    <h2 class="login-form-title mb-1">Tạo tài khoản</h2>
                    <p class="text-muted">Vui lòng nhập đầy đủ thông tin sau:</p>
                </div>
                <form class="login-form-groups" method="POST" action="/register">
                    @csrf
                    <div class="form-group">
                        <label class="form-label visually-hidden" for="login-form-email">Name</label>
                        <input class="form-control  is-invalid " id="login-form-email"
                               type="text" name="fullname" placeholder="Fullname" value="{{old('fullname')}}"/>
                        @error('fullname')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label visually-hidden" for="login-form-email">Email</label>
                        <input class="form-control  is-invalid " id="login-form-email"
                               type="text" name="email" placeholder="Email" value="{{old('email')}}"/>

                        @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="login-form-btn-group">
                        <div class="form-group d-grid">
                            <!-- <div>
                          <p class="_58mv">Bằng cách nhấp vào Đăng ký, bạn đồng ý với <a href="/legal/terms/update" id="terms-link" target="_blank" rel="nofollow">Điều khoản</a>, <a href="/about/privacy/update" id="privacy-link" target="_blank" rel="nofollow">Chính sách dữ liệu</a> và <a href="/policies/cookies/" id="cookie-use-link" target="_blank" rel="nofollow">Chính sách cookie</a> của chúng tôi. Bạn có thể nhận được thông báo của chúng tôi qua SMS và hủy nhận bất kỳ lúc nào.</p>
                        </div> -->
                            <button class="btn btn-primary fw-bold" type="submit">Đăng ký</button>
                        </div>
                        <div class="form-group text-center">
                            <p class="login-form-divider-text">hoặc</p>
                        </div>

                        <div class="form-group d-grid">
                            <a class="btn btn-login-light" style="background-color: #f4f4f4;
                border-color: #d3d3d3; box-shadow: none;
    color: #323232;" href="<%=oauthGoogle%>">
                                <img class="img-fluid btn-icon" src="images/google.svg" alt="Đăng nhập với google" />Đăng nhập
                                với Google
                            </a>
                        </div>
                        <div class="form-group d-grid">
                            <a class="btn btn-login-light" style="background-color: #3b5998;
                border-color: #3b5998;
                color: #fff;" type="button" href="<%=oauthFacebook%>">
                                <img class="img-fluid btn-icon" src="images/facebook.svg" alt="Đăng nhập với facebook" />Đăng
                                nhập với Facbook
                            </a>
                        </div>
                        <div class="form-group d-grid">
                            <a class="btn btn-login-light" style="background-color: #000;
                border-color: #000;
                color: #fff;" href="<%=oauthApple%>">
                                <img class="img-fluid btn-icon" src="images/apple.svg" alt="Đăng nhập với Apple" />Đăng nhập
                                với Apple
                            </a>
                        </div>
                    </div>
                    <div class="form-group text-center">Đã có tài khoản? <a class="link-primary" href="/login">Đăng
                            nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>
