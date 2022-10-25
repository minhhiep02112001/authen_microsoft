$(document).on("submit", '#login' , function (event){
    event.preventDefault();
    var check = true;
    var _this = $(this);
    var email_phone = $(this).find('input[name="email_phone"]').val();
    $.ajax({
        type: "POST",
        url: window.findAccountUrl,
        data: {
            email_phone
        },
        cache: false,
        success: function (responsive) {
            if (responsive.data.length == 0){
                _this.find('.form-group').find('div.invalid-feedback').remove();
                let html = '<div class="invalid-feedback">Không tìm thấy tài khoản của bạn !!!</div>'
                _this.find('.form-group').append(html);
            } else{
                document.querySelector("#login").submit();
            }
        },
        error:function (){

        }
    });
});

