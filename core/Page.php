<?php
namespace Core;

class Page {
    public function init() {
        $check = new \Core\Check;
        $url = new \Core\Url;
        // получение alt_name и url_page
        $alt_name = $url->getAltName();

        if ($check->isUrlArticle($alt_name)) { // если url, типа 'story_12' текст с id вывод статьи
            $model_article = new \Models\Article;
            $model_article->showArticle($alt_name);
        } else { // вывод категории
            $model_category = new \Models\Category;
            $model_category->showCategory($alt_name);
        }
    }
} 
