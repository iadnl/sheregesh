<?php
namespace Core;

class Message {    
    public function send($type, $text) {
        $session = new \Core\Session;
        
        $message_arr =  ['text' => $text, 'type' => $type];
        $session->set('alert_message', $message_arr);
    }
    public function getMessage($type='') {
        if ($type === 'panel') {
            $view = new \Panel\View;
        } else {
            $view = new \Core\View;
        }
        $session = new \Core\Session;
        
        if ($session->is('alert_message')) {
            $arr = $session->get('alert_message');
            $id =  uniqid();
            $content = $view->render('message', [
                'text' => $arr['text'],
                'type' => $arr['type'],
                'id' => $id,
            ]);
            $session->remove('alert_message');
            return $content;   
        } else {
            return false;
        }        
    }
}
