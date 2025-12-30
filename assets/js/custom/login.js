$(document).ready(function () {
    $('#kt_sign_up_submit').click(function (e) {
        e.preventDefault();

        var email = $('input[name="email"]').val();
        var password = $('input[name="password"]').val();
        var action = "login";

        $.ajax({
            url: '../authorization', // Kayıt işlemini gerçekleştirecek PHP dosyasının yolu
            type: 'POST',
            dataType: 'json',
            data: {
                email: email,
                password: password,
                action: action
            },
            success: function (response) {
                if (response.status == 'success') {
                    // Başarılı mesajı toastr ile göster
                    toastr.success(response.message, 'Başarılı');

                    // Başarılı işlem sonrasında başka bir sayfaya yönlendirebilirsiniz
                    setTimeout(() => window.location.href = 'home', 2000);
                } else {
                    // Hata mesajı toastr ile göster
                    toastr.error(response.message, 'Hata');
                }
            },
            error: function () {
                toastr.error('İstek gönderilirken bir hata oluştu, lütfen sayfayı yenileyip tekrar deneyin.', 'Hata');
            }
        });
    });
});