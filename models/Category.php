<?php
namespace Models;

class Category extends Model {
    public $table = 'category';
    
    function __construct() {
        parent::__construct();
        $this->table = $this->prefix.$this->table;
    } 
    // формирование страницы категории
    public function showCategory($alt_name) {
        $view = new \Core\View;
        $url = new \Core\Url;

        $category = $this->getCategoryByUrlPage($alt_name, []);
        if ($category) {
            $all_cat_array = $this->getAllCategories(['id', 'parent_id', 'alt_name', 'title']);
            $full_url = $url->linkCategory($category['id'], $all_cat_array);
            $url_page = $url->getUrlPage();
            $url_page = $url_page === '/' ? '' : $url_page;
            if ($url_page . '/' . $alt_name === $full_url) { // Если совпал url категории
                $content = $view->render('index', [
                    'header' => $view->render('header', [
                        'title' => $category['meta_title'],
                        'description' => $category['descr'],
                        'keywords' => $category['keywords'],
                    ]),
                    'main_content' => $view->render('category', [
                        'category' => $category,
                        'news' => $this->getNewsFromCategory($category['id'], $full_url),
                        'bread_crumbs' => $view->render('bread_crumbs/bread_crumbs', [
                            'full_url' => $full_url,
                            'all_cat_array' => $all_cat_array,
                            'title' => $category['title'],
                        ]),
                    ]),
                    'footer' => $view->render('footer', []),
                ]);
                $view->send($content);
            } else {
                $view->notFound();
            }
        } else { // иначе ошибка 404 
            $view->notFound();
        }
    }

    // получение значений полей категории по id
    public function getCategoryById($id, $fiels) {
        $fiels = implode(',', $fiels);
        $fiels === '' ? $fiels = '*' : $fiels;
        $answer = $this->connect_base->prepare("SELECT $fiels FROM $this->table WHERE id=?");
        $answer->execute(array($id));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        }
    }

    // Получение всех активных категорий
    public function getAllCategories($fiels = []) {
        $fiels = implode(',', $fiels);
        $fiels === '' ? $fiels = '*' : $fiels;
        $answer = $this->connect_base->query("SELECT $fiels FROM $this->table");
        if ($answer) {
            $result = $answer->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    }

    // Получение категории по полю alt_name
    public function getCategoryByUrlPage($alt_name, $fiels = []) {
        $fiels = implode(',', $fiels);
        $fiels === '' ? $fiels = '*' : $fiels;
        $answer = $this->connect_base->prepare("SELECT $fiels FROM $this->table WHERE alt_name=?");
        $answer->execute(array($alt_name));

        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
//===========================private=================================
    // полученение списка новостей из категории
    private function getNewsFromCategory($cat_id, $full_url) {
        $view = new \Core\View;
        $article_model = new \Models\Article;
        $comments_model = new \Models\Comments;
        $pagination = new \Core\Pagination;
        
        $pages_array = $article_model->getNewsByCategoryId($cat_id, $pagination->count, $pagination->position, ['id', 'alt_name', 'title', 'short_story', 'views', 'date']); //массив с новостями 
        foreach ($pages_array as $key => $value) { // получение полных ссылок для всех
            $pages_array[$key]['alt_name'] = $full_url . '/' . $value['alt_name'] . '_' . $value['id']; 
            $pages_array[$key]['count_comments'] = $comments_model->countArticleComments($value['id']);
        }

        return $view->render('short_story_default', [
                'pages_array' => $pages_array,
            ]) . $pagination->html($article_model->countPagesInCategory($cat_id));
    }

}
