$(document).ready(function () {
    $('#kt_sign_up_submit').click(function (e) {
        e.preventDefault();

        var email = $('input[name="email"]').val();
        var secretAnswer = $('input[name="secret_answer"]').val();
        var newPassword = $('input[name="new_password"]').val();
        var action = "password";

        $.ajax({
            url: '../authorization', // Kayıt işlemini gerçekleştirecek PHP dosyasının yolu
            type: 'POST',
            dataType: 'json',
            data: {
                email: email,
                secretAnswer: secretAnswer,
                newPassword: newPassword,
                action: action
            },
            success: function (response) {
                if (response.status == 'success') {
                    // Başarılı mesajı toastr ile göster
                    toastr.success(response.message, 'Başarılı');

                    // Başarılı işlem sonrasında başka bir sayfaya yönlendirebilirsiniz
                    setTimeout(() => window.location.href = 'login', 2100);
                } else {
                    // Hata mesajı toastr ile göster
                    toastr.error(response.message, 'Hata');
                }
            },
            error: function () {
                toastr.error('İstek gönderilirken bir hata oluştu.', 'Hata');
            }
        });
    });
});