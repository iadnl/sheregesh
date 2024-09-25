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
 * Use: Набор методов для работы с запросами обратной связи
 * =====================================================
 **/

namespace Models;

class Feedback extends Model {
    public $table = 'feedback';

    function __construct() {
        parent::__construct();
        $this->table = $this->prefix.$this->table;
    }
    // Добавление в базу даных сообщения от пользователя
    public function addMessage($data) {
        $answer = $this->connect_base->prepare("INSERT INTO $this->table "
            . "(title, text, date, referer, ip) "
            . "VALUES (?, ?, ?, ?, ?)"); //подготовка запроса
        $result = $answer->execute(array($data['title'], $data['text'], $data['date'], $data['referer'], $data['ip']));
        if ($result) {
            $id = $this->connect_base->lastInsertId();
            return $id;
        } else {
            return false;
        }
    }

}
