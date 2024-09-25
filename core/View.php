<?php
namespace Core;

class View {
    public function notFound() {
        $log = new \Core\Journal;        

        header('HTTP/1.1 404 Not Found');
        $log->add404();

        $content = $this->render('index', [
            'header' => $this->render('header', [
                'title' => 'Запрашиваемая страница не найдена, 404',
            ]),
            'main_content' => $this->render('not_found', [
            ]),
            'footer' => $this->render('footer', []),
        ]);
        
        $this->send($content);
    }
    
    // отправка ошибки в json формате
    public function sendJsonError($message = []) {
        if (is_array($message)) {
            $str = implode(' ', $message);
        } else {
            $str = $message;
        }
        $this->send(json_encode(['error' => 'true', 'message' => $str]));
    }

    // отправка успеха в json формате
    public function sendJsonSuccess($message = [], $data = []) {
        if (is_array($message)) {
            $str = implode(' ', $message);
        } else {
            $str = $message;
        }
        if (is_array($data)) {
            $data_str = json_encode($data);
        } else {
            $data_str = $data;
        }
        $this->send(json_encode(['error' => 'false', 'message' => $str, 'data' => $data_str]));
    }

    public function send($content) {
        echo $content;
        exit(0);
    }

    public function render($view, $params = []) {
        return self::renderView('../view/' . $view . '.php', $params);
    }

    protected function renderView($_file_, $_params_ = []) {
        ob_start();
        ob_implicit_flush(false);
        extract($_params_, EXTR_OVERWRITE);
        require($_file_);
        return ob_get_clean();
    }

}
