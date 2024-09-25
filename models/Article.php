<?php
namespace Models;

class Article extends Model { 
    public $table = 'article';
    
    function __construct() {
        parent::__construct();
        $this->table = $this->prefix.$this->table;
    }   
    // формирование страницы статьи
    public function showArticle($alt_name) {
        $view = new \Core\View;        
        $url = new \Core\Url;

        $id_news = $this->getIdArticleFromUrl($alt_name);

        $article = $this->getArticleById($id_news, ['category_id', 'alt_name']);
        if ($article) { // если есть такая новость
            $model_category = new \Models\Category;
            $all_cat_array = $model_category->getAllCategories(['id', 'parent_id', 'alt_name', 'title']);
            $full_url = $url->linkCategory($article['category_id'], $all_cat_array) . '/' . $article['alt_name'].'_'.$id_news;
            $url_page = $url->getUrlPage();
            if ($url_page . '/' . $alt_name === $full_url) {// Если совпал url новости
                $this->incView($id_news); // увеличение счетчика просмотров
                $article = $this->getArticleById($id_news);
                $article['title_category'] = $model_category->getCategoryById($article['category_id'], ['title'])['title'];
                $comments_model = new \Models\Comments;
                $article['count_comments'] = $comments_model->countArticleComments($article['id']);

                $content = $view->render('index', [
                    'header' => $view->render('header', [
                        'title' => $article['meta_title'],
                        'description' => $article['descr'],
                        'keywords' => $article['keywords'],
                    ]),
                    'main_content' => $view->render('article_full_story_default', [
                        'article' => $article,
                        'bread_crumbs' => $view->render('bread_crumbs/bread_crumbs', [
                            'full_url' => $full_url,
                            'all_cat_array' => $all_cat_array,
                            'title' => $article['title'],
                        ]),
                    ]),
                    'footer' => $view->render('footer', []),
                ]);
                $view->send($content);
            } else {
                $view->notFound();
            }
        } else { //если нет такой новости, то 404
            $view->notFound();
        }
    }
    // получение статьи по id если стаьья разрешена на просмотр 
    public function getArticleById($id, $fiels = []) {
        $fiels = implode(',', $fiels);
        $fiels === '' ? $fiels = '*' : $fiels;
        $answer = $this->connect_base->prepare("SELECT $fiels FROM $this->table WHERE id=? AND active = 1");
        $answer->execute(array($id));

        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    // Проверка на существование новости
    public function isArticle($id) {
        $answer = $this->connect_base->prepare("SELECT id FROM $this->table WHERE id=?");
        $answer->execute(array($id));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result['id'];
        } else {
            return false;
        }
    }
    // увеличение счетчика просмотров
    public function incView($id) {
        $answer = $this->connect_base->prepare("UPDATE $this->table SET views = views+1 WHERE id=?");
        $answer->execute(array($id));

        $result = $answer->fetch(\PDO::FETCH_ASSOC);
    }
    // Получение новостей по количеству и с позиции на главную с allow_main равному 1 (с отметкой публикации на главной) 
    public function loadNews($count, $position, $fiels = []) {
        $fiels = implode(',', $fiels);
        $fiels === '' ? $fiels = '*' : $fiels;
        $answer = $this->connect_base->prepare("SELECT $fiels FROM $this->table WHERE active = 1 AND allow_main = 1 ORDER BY date  DESC LIMIT ? OFFSET ? ");
        $answer->execute(array($count, $position));

        $result = $answer->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    // Количество активных новостей всего
    public function countNews() {
        $answer = $this->connect_base->query("SELECT COUNT(*) FROM $this->table WHERE active = 1");
        if ($answer) {
            $result = $answer->fetch(\PDO::FETCH_ASSOC);
            if (isset($result['COUNT(*)'])) {
                return $result['COUNT(*)']; // количество активных новостей
            }
        }
        return false;
    }
    // получение новостей по количеству и с позиции	
    public function getNewsByCategoryId($cat_id, $count, $position, $fiels = []) {
        $fiels = implode(',', $fiels);
        $fiels === '' ? $fiels = '*' : $fiels;
        $answer = $this->connect_base->prepare("SELECT $fiels FROM $this->table WHERE category_id =? AND active = 1 ORDER BY date DESC LIMIT ? OFFSET ? ");
        $answer->execute(array($cat_id, $count, $position));
        if ($answer) {
            $result = $answer->fetchAll(\PDO::FETCH_ASSOC);
            //echo '11111sss';
            return $result;
        } else {
            return false;
        }
    }
    // Количество активных новостей в категории
    public function countPagesInCategory($cat_id) {
        $answer = $this->connect_base->prepare("SELECT COUNT(*) FROM $this->table WHERE category_id=? AND active = 1");
        $answer->execute(array($cat_id));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if (isset($result['COUNT(*)'])) {
            return $result['COUNT(*)']; // количество активных новостей
        } else {
            return false;
        }
    }
//===========================private=================================
    // Возвращает цыфры стоящие на конце после "_"
    private function getIdArticleFromUrl($url) {
        $elem_array = explode('_', $url);
        return array_pop($elem_array);
    }

}
