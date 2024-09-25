<?php
/*
 * =====================================================
 * Adeptus CMS - by Danil Shiryaev
 * -----------------------------------------------------
 * https://danil-shiryaev.ru
 * -----------------------------------------------------
 * Copyright (c) 2020 Danil Shiryaev
 * =====================================================
 * This code is protected by copyright
 * =====================================================
 * Use: Обработка формы обратной связи 
 * =====================================================
 **/

namespace Controllers;

use Configuration\Config;
use Core\Mail;

class Feedback
{
    private $_model;

    function __construct() {
        $this->_model = new \Models\Feedback;
    }
    // добавление сообщения в базу
    public function send() {
        $check = new \Core\Check;
        $post = new \Core\Post;
        $captcha = new \Core\Captcha;
        $view = new \Core\View;
        $mail = new Mail();
        $config = new Config();

        if ($post->isRequest('captcha')) {
            $text = $post->get('text');
            $email = $post->get('email');
            $captcha_code = $post->get('captcha');

            if (!$check->rangeStringLenght($text, 1, 1000)) {
                $view->send(json_encode(['error'=>'true', 'message'=>'Длина сообщения должна быть не более 1000 символов']));
            }
            if (!$check->rangeStringLenght($email, 0, 500)) {
                $view->send(json_encode(['error'=>'true', 'message'=>'Длина E-mail должна быть не более 500 символов']));
            }

            if (!$captcha->captchaHashVerify($captcha_code)) {
                $view->send(json_encode(['error'=>'true', 'message'=>'Неверное число с картинки']));
            }
            // сброс предыдущей капчи !ВАЖНО
            // $captcha->generateCaptcha(); // генерация капчи

            $server = new \Core\Server;
            $text_full = 'Контакты: '.$email." | Текст: ".$text;
            $_data = array(
                'title' => $text,
                'text' => $text_full,
                'date' => time(),
                'referer' => $server->getClientReferer(),
                'ip' => $server->getClientIp(),
            );

            if ($this->_model->addMessage($_data)) { // успешное добавление в базу
                $mail_to = $config->getConfig('email');
                $mail->send($mail_to, $mail_to, 'Обратная связь', $text_full);
                $view->send(json_encode(['error'=>'false', 'message'=>'Сообщение успешно отправлено']));
            } else { // не удалось добавить в базу
                $view->send(json_encode(['error'=>'true', 'message'=>'Неизвестная ошибка, попробуйте позже']));
            }
        }

        $view->notFound();
    }
}