<?php
namespace Core;

class Url {
    public function getFullUrl() {
        return $_SERVER['REQUEST_URI'];
    }

    public function getClassName() {
        $url_str = parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
        if ($url_str) {
            $url_arr = explode('/', $url_str);
        } else {
            $url_arr = [];
        }          
        $res = array_shift($url_arr);
        if (!$res) {
            $res = 'main';
        }
        return $res;
    }

    // последний элемент url
    public function getMethodName() {
        $url_str = parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
        if ($url_str) {
            $url_arr = explode('/', $url_str);
        } else {
            $url_arr = [];
        }           
        array_shift($url_arr);
        $res = implode('', $url_arr);
        if (!$res) {
            $res = 'index';
        }
        return $res;
    }

    // последний элемент после в url, поле аlt_name у записи 
    public function getAltName() {
        $url_str = parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
        if ($url_str) {
            $url_arr = explode('/', $url_str);
        } else {
            $url_arr = [];
        }            

        return array_pop($url_arr);
    }

    // получение url запроса
    public function getPath() {
        $url_str = parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
        if ($url_str) {
            $url_arr = explode('/', $url_str);
        } else {
            $url_arr = [];
        }        

        return implode('/', $url_arr);
    }

    // получение предшествия к последнему элементу в url
    public function getUrlPage() {
        $url_str = parse_url(trim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
        if ($url_str) {
            $url_arr = explode('/', $url_str);
        } else {
            $url_arr = [];
        }       
        array_pop($url_arr);

        return '/' . implode('/', $url_arr);
    }

    public function linkArticle($article_id) {
        $article = new \Models\Article;
        $article_array = $article->getArticleById($article_id, ['alt_name', 'category_id'], false);

        return $this->linkCategory($article_array['category_id']) . '/' . $article_array['alt_name'] . '_' . $article_id;
    }

    public function linkCategory($category_id, $array_categories = NULL) {
        if ($array_categories == NULL) {
            $category_model = new \Models\Category;
            $array_categories = $category_model->getAllCategories(['id', 'parent_id', 'alt_name']); //массив категорий
        }
        foreach ($array_categories as $key => $value) {
            if ($value['id'] === $category_id) {
                if (($value['parent_id'] !== 0) && ($value['parent_id'] !== $category_id)) {
                    return $this->linkCategory($value['parent_id'], $array_categories) . '/' . $value['alt_name'];
                } else {
                    return '/' . $value['alt_name'];
                }
            }
        }
    }

}
