<?php
namespace Models;

class Main extends Model {
    public function getMainPage() {
        $view = new \Core\View;
        $config = new \Configuration\Config;
        
        $content = $view->render('index', [
            'header' => $view->render('header', [
                'title' => $config->getSiteInfo('title'),
                'description' => $config->getSiteInfo('description'),
                'keywords' => $config->getSiteInfo('keywords'),
            ]),
            'main_content' => $view->render('main', [                
                'content' => '',
            ]),
            'footer' => $view->render('footer', []),
        ]);
        $view->send($content);
    }
}
