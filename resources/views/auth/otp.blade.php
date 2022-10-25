<!DOCTYPE html>
<html class="no-js" lang="vi">

<head>
    <meta charset="utf-8">
    <title>Xác thực tài khoản - IMAP ID</title>
    <meta name="author" content="TUTA">
    <meta name="description" content="IMAP ID">
    <meta name="keywords" content="IMAP ID">
    <meta name="viewport" content="width=device-width initial-scale=1">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
    <link rel="stylesheet" href="/css/style.min.css">
    <style>
        /* MODAL –––––––––––––––––––––––––––––––––––––––––––––––––– */

        .open-modal {
            font-weight: bold;
            background: steelblue;
            color: #fff;
            padding: 0.75rem 1.75rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.8);
            cursor: pointer;
            visibility: hidden;
            opacity: 0;
            transition: all 0.35s ease-in;
        }

        .modal.is-visible {
            visibility: visible;
            opacity: 1;
        }

        .modal-dialog {
            position: relative;
            max-width: 600px;
            max-height: 80vh;
            min-width: 300px;
            border-radius: 5px;
            background: #fff;
            cursor: default;
        }

        .modal-dialog > * {
            padding: 1rem;
        }

        .modal-header,
        .modal-footer {
            background: #efefef;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header .close-modal {
            font-size: 1.5rem;
        }

        .modal p + p {
            margin-top: 1rem;
        }

        .modal .center {
            text-align: center;
        }
    </style>
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
                <a class="btn-back" href="{{url('/') }}">
                    <button class="btn btn-light btn-square" type="button">
                        <img class="img-fluid" src="/images/chevron-left.svg" alt=""/>
                    </button>
                    Quay lại
                </a>
                <div class="login-form-header">
                    <h2 class="modal-title mb-1">Nhập mã xác nhận</h2>
                    <p class="text-muted">Kiểm tra email và nhập mã xác nhận gồm 6 chữ số</p>
                </div>
                <form class="login-form-groups" method="POST" action="{{$url}}">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{{request()->user_id ?? 0}}">
                        <label class="form-label visually-hidden" for="otp">Nhập mã xác nhận</label>
                        <input class="form-control" id="otp" name="otp" type="text"
                               placeholder="Nhập otp ..."/>
                        @if(session()->has('notification_error'))
                            <div class="invalid-feedback d-block">{{ session()->get('notification_error') }}</div>
                        @endif
                    </div>
                    <div class="login-form-btn-group">
                        <div class="form-group d-grid">
                            <button class="btn btn-primary fw-bold" type="submit">Tiếp tục</button>
                        </div>
                        <div class="form-text text-end">
                            <a href="javascript:void(0)" onclick="sendOTP()">Gửi lại mã OTP</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal">
    <div class="modal-dialog">
        <header class="modal-header">
            OTP SEND
            <button class="close-modal" aria-label="close modal" data-close>✕</button>
        </header>
        <section class="modal-content">
            <p id="model-content">Một mã xác nhận đã được gửi đến email của bạn.</p>
        </section>
        <!-- <footer class="modal-footer">
          The footer of the second modal
        </footer> -->
    </div>
</div>

<div class="modal" id="modal2">
    <div class="modal-dialog">
        <header class="modal-header">
            ERROR
            <button class="close-modal" aria-label="close modal" data-close>✕</button>
        </header>
        <section class="modal-content">
            <p class="center" id="model2-content"></p>
        </section>
        <!-- <footer class="modal-footer">
          The footer of the second modal
        </footer> -->
    </div>
</div>

<script>
    const url_ajax = "{{route('resend.otp')}}";
    const openEls = document.querySelectorAll("[data-open]");
    const closeEls = document.querySelectorAll("[data-close]");
    const isVisible = "is-visible";
    const user_id = '{{request()->user_id ?? 0}}';
    const action_type = '{{request()->action_type ??''}}'
    const type = '{{request()->type ??''}}'
    for (const el of openEls) {
        el.addEventListener("click", function () {
            const modalId = this.dataset.open;
            document.getElementById(modalId).classList.add(isVisible);
        });
    }

    for (const el of closeEls) {
        el.addEventListener("click", function () {
            this.parentElement.parentElement.parentElement.classList.remove(isVisible);
        });
    }

    document.addEventListener("click", e => {
        if (e.target == document.querySelector(".modal.is-visible")) {
            document.querySelector(".modal.is-visible [data-close]").click();
        }
    });

    document.addEventListener("keyup", e => {
        // if we press the ESC
        if (e.key == "Escape" && document.querySelector(".modal.is-visible")) {
            document.querySelector(".modal.is-visible [data-close]").click();
        }
    });

    function sendOTP() {
        var data = {
            'user_id': user_id,
            'action_type': action_type,
            'type': type,
        };
        fetch(url_ajax, {
            method: 'POST', // or 'PUT'
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data),
        }).then((response) => response.json())
            .then((data) => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });

        // var xhttp = new XMLHttpRequest();
        // var data = new FormData();
        // data.append('user_id', user_id);
        // data.append('action_type', action_type);
        // data.append('type', type);
        // xhttp.onreadystatechange = function () {
        //     if (this.readyState == 4) {
        //         var responseJSON = JSON.parse(this.responseText);
        //         if (this.status == 200) {
        //             document.getElementById('modal').classList.add(isVisible);
        //             document.getElementById('model-content').innerText = responseJSON.message;
        //         } else {
        //             document.getElementById('model2-content').innerText = responseJSON.message;
        //             document.getElementById('modal2').classList.add(isVisible);
        //         }
        //     }
        // };
        // xhttp.open("POST", url_ajax, true);
        // xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        // xhttp.setRequestHeader();
        // xhttp.send(data);
    }
</script>
</body>

</html>
