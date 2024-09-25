<?php
namespace Core;

class Pagination {
    public $count; // Количество элементов на одну страницу
    public $page; // Номер страницы
    public $position; // Позиция отсчета
    
    //инициализация объекта погинации 
    function __construct($count=25) {
        $get = new \Core\Get;
        // Количество элементов на одну страницу
        if ($get->get('count')<>'') {
            $this->count = $get->get('count');
        } else {
            $this->count = $count; 
        }
        // постраничный запрос
        $this->page = $get->get('page'); // номер страницы
        if (($this->page<>'') && is_int($this->page+0) && ($this->page>1)) {
            $this->position = $this->count*$this->page-$this->count; // позиция отсчета
        } else { // по умолчанию, первая страница
            $this->position = 0;
            $this->page = 1;
        }
    }
    // Формирование html кода пагинации
    public function html($count_elements, $place='site') {
        if ($place === 'site') {
            $view = new \Core\View;
        } else if ($place === 'panel') {
            $view = new \Panel\View;
        }
        return $view->render('pagination', [
            'count_paginat' => ceil($count_elements/$this->count),
            'page_num' => $this->page,
        ]);
    }
}