<?php
namespace Core;

use Configuration\Config;

class StaticPage {
    private $_model;
    
    function __construct() {
        $this->_model = new \Models\StaticPage;
    }

    public function init($alt_name) {        
        $view = new \Core\View;
        $config = new Config;
        
        if (!$this->_model->isStaticPage($alt_name)) {
            $view->notFound();
        }
        
        $static_page = $this->_model->getStaticPage($alt_name);
        
        if (($static_page['full_tpl'] !== '') && is_file( '../view/template/' . $static_page['full_tpl'] . '.php')) {
            $full_tpl = 'template/'.$static_page['full_tpl'];
        } else {
            $full_tpl = 'static_full_story_default';
        }    

        $arr_links = [
            [
                'link' => '/page/'.$static_page['alt_name'],
                'title' => $static_page['title']
            ],
        ];
        
        $content = $view->render('index', [
            'header' => $view->render('header', [
                'title' => $static_page['meta_title'].' | '.$config->getConfig('name'),
                'keywords' => $static_page['keywords'],
                'description' => $static_page['descr'],
            ]),
            'main_content' => $view->render($full_tpl, [
                'static_page' => $static_page,
                'id_page' =>  $static_page['id'],
             
            ]),
            'footer' => $view->render('footer', []),
        ]);
        $view->send($content);
    }
}
