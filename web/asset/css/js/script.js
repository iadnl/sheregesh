$(document).ready(function () {
    $('body').on('click', '.reg-button', function (e) {
        $('.log-block').hide();
        $('.reg-block').show();
    });
    $('body').on('click', '#log-button_s', function (e) {
        $('.log-block').show();
        $('.reg-block').hide();
    });
    // ------------- login
    $(document).on('submit', '#login-form', function (e) {
        e.preventDefault();
        $('.login-form__alert').text('');
        $.ajax({
            type: "POST",
            url: "/auth/login",
            data: $(this).serialize()
        }).done(function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.error === 'true') {
                $('.login-form__alert').text(obj.message);
            } else if (obj.error === 'false') {
                location.reload();
            }
        });
    });
    $('body').on('click', '#tab_form_login', function (e) {
        e.preventDefault();
        $('.login-block').show();
        $('.login-form__alert').text('');
        $('.recover-block').hide();
        $('.registration-block').hide();
    });
    $('body').on('click', '#tab_form_recover', function (e) {
        e.preventDefault();
        $('.recover-block').show();
        $('.recover-form__alert').text('');
        $('.recover-form-code__alert').text('');
        $('.login-block').hide();
        $('.registration-block').hide();
    });
    $('body').on('click', '.recover-form-code__back', function (e) {
        e.preventDefault();
        $('#recover-form').show();
        $('#recover-form-code').hide();
    });
    $('body').on('click', '#tab_form_registration', function (e) {
        e.preventDefault();
        $('.registration-block').show();
        $('.registration-form__alert').text('');
        $('.registration-form-code__alert').text('');
        $('.login-block').hide();
        $('.recover-block').hide();
    });
    $('body').on('click', '.registration-form-code__back', function (e) {
        e.preventDefault();
        $('#registration-form').show();
        $('#registration-form-code').hide();
    });
    $(document).on('submit', '#registration-form', function (e) {
        e.preventDefault();
        $('.registration-form__alert').text('');
        $.ajax({
            type: "POST",
            url: "/auth/registration",
            data: $(this).serialize()
        }).done(function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.error === 'true') {
                $('.registration-form__alert').text(obj.message);
            } else if (obj.error === 'false') {
                $('#registration-form').html('<h3>Успешная регистрация</h3><p></p><a href="/" class="btn btn-primary btn-lg">Перейти на главную</a>');
            }
        });
    });
    $(document).on('submit', '#registration-form-code', function (e) {
        e.preventDefault();
        $('.registration-form-code__alert').text('');
        $.ajax({
            type: "POST",
            url: "/auth/registration-activate",
            data: $(this).serialize()
        }).done(function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.error === 'true') {
                $('.registration-form-code__alert').text(obj.message);
            } else if (obj.error === 'false') {
                location.reload();
            }
        });
    });
    $(document).on('submit', '#recover-form', function (e) {
        e.preventDefault();
        $('.recover-form__alert').text('');
        $.ajax({
            type: "POST",
            url: "/auth/recover",
            data: $(this).serialize()
        }).done(function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.error === 'true') {
                $('.recover-form__alert').text(obj.message);
            } else if (obj.error === 'false') {
                $('#recover-form').hide();
                $('#recover-form-code').show();
                $('.recover-form-code__email').text($('#recover-form__email').val());
            }
        });
    });
    $(document).on('submit', '#recover-form-code', function (e) {
        e.preventDefault();
        $('.recover-form-code__alert').text('');
        $.ajax({
            type: "POST",
            url: "/auth/recover-activate",
            data: $(this).serialize()
        }).done(function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.error === 'true') {
                $('.recover-form-code__alert').text(obj.message);
            } else if (obj.error === 'false') {
                location.reload();
            }
        });
    });
// ------------- login end    
    //button up
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $('body,html').animate({scrollTop: 0}, 50);
    });
    // user message animate
    $('.message').delay(400).slideToggle().delay(3500).slideToggle();
});
// change color header
function message_send(type, message) {
    $.ajax({
        type: "POST",
        url: "/ajax/get-message",
        data: {
            'message': message,
            'type': type
        }
    }).done(function (res) {
        var obj = jQuery.parseJSON(res);
        if (obj.error === 'true') {// ошибка
            console.log(obj.message);
        } else if (obj.error === 'false') {// ошибок нет
            $('.message').remove();
            $('body').prepend(obj.content);
            $('.message').delay(400).slideToggle().delay(3500).slideToggle();
        }
    });
}
