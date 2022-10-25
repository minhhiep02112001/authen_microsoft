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
                <div class="login-form-header" style="text-align: center;">

                    <h2 class="modal-title mb-1">Wellcome {{$data['email']}}
                    </h2>
                    @if(!empty($data))
                        <div class="">User ID : {{auth()->id()}} </div>

                        {{--                    <div class="">Confirm Status : {{auth()->user()->}}--}}
                        {{--                    </div>--}}

                        <div>
                            Số điện thoại: @if(!empty($data['phone']))
                                {{ $data['phone'] }}
                            @else
                                {{--                                <a href="/account/settings/phone/change" class="change-phone">(change)</a>--}}
                                null
                            @endif
                        </div>

                        <form action="{{route('logout')}}" method="POST"  style="margin-top: 10px;">
                            @csrf
                            <button type="submit" class="btn btn-primary fw-bold"> Logout</button>
                        </form>
                        <br>

                        @if(auth()->check() && !auth()->user()->check_temporary)
                            <hr>
                            @if (session('temporary_password'))
                                Mật khẩu của bạn là: <b><u>{{ session('temporary_password') }}</u></b> <br>
                            @endif
                            Bạn cần thay đổi mật khẩu
                            <hr>
                        @endif
                        <a href="{{route('account.change.password')}}" class="btn btn-secondary">Change Password</a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
</body>

</html>
