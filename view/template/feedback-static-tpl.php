<?php
$access = new \Core\Access;

$captcha = new \Core\Captcha;
$captcha->generateCaptcha();
?>
<div class="container">
    <div class="static-fullstory">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <h1 class="static-fullstory__title"><?= $static_page['title'] ?></h1>
                <?= $static_page['full_story'] ?>
                <form class="form-feedback" id="feedback" method="post">
                    <div class="row">
                        <div class="col-8">
                            <label for="text" class="form-label">Обращение</label>
                            <textarea type="text" class="form-control" id="text" name="text" required></textarea>
                        </div>
                        <div class="col-8">
                            <label for="email" class="form-label">Соц. сети или E-mail (необязательно)</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-8">
                            <label for="captcha" class="form-label">Введите число с картинки</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <img class="captcha-image" src="<?= $captcha->getImageLink() ?>" alt="капча">
                                </span>
                                <input type="text" id="captcha" class="form-control" name="captcha" required>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <span class="feedback-form__alert"></span>
                            <button class="btn btn-primary" type="submit"><div class="spinner-border text-light" role="status"><span class="visually-hidden">Отправка...</span></div> Отправить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on('submit', '#feedback', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/feedback/send",
                data: $('#feedback').serialize(),
                beforeSend: function () {
                    $('.spinner-border').css('display', 'inline-block');
                },
            }).done(function (data) {
                $('.spinner-border').css('display', 'none');
                var obj = jQuery.parseJSON(data);
                if (obj.error === 'true') {
                    $('.feedback-form__alert').text(obj.message);
                } else if (obj.error === 'false') {
                    $('#feedback').html('<div class="feedback-success">Сообщение отправлено</div>');
                }
            });
        });
    });
</script>

<?php if ($access->allowGroup(['admin'])): /* только для админа, дополнительные возможности */ ?>
    <script>
        var _option_array = {
            'type': 'static',
            'id': <?=$static_page['id']?>,
        }
    </script>
<?php endif ?>


