$(document).ready(function () {
    $('#kt_sign_up_submit').click(function (e) {
        e.preventDefault();

        var username = $('input[name="username"]').val();
        var email = $('input[name="email"]').val();
        var secretAnswer = $('input[name="secret_answer"]').val();
        var password = $('input[name="password"]').val();
        var question = $('select[name="question"]').val();
        var action = "register";

        $.ajax({
            url: '../authorization', // Kayıt işlemini gerçekleştirecek PHP dosyasının yolu
            type: 'POST',
            dataType: 'json',
            data: {
                username: username,
                email: email,
                secretAnswer: secretAnswer,
                password: password,
                action: action,
                question: question
            },
            success: function (response) {
                if (response.status == 'success') {
                    // Başarılı mesajı toastr ile göster
                    toastr.success(response.message, 'Başarılı');

                    // Başarılı işlem sonrasında başka bir sayfaya yönlendirebilirsiniz
                    setTimeout(() => window.location.href = 'login', 2000);
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