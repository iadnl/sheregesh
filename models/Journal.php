<?php
namespace Models;

class Journal extends Model {
    public $table = 'logs';
    
    function __construct() {
        parent::__construct();
        $this->table = $this->prefix.$this->table;
    } 
    // Добавление в базу даных записи ошибки 404 журнала
    public function addLog404($data) {
        $answer = $this->connect_base->prepare("INSERT INTO $this->prefix".'logs_404 '
                . "(url, count, ip_first, ip_last, date_first, date_last) "
                . "VALUES (?, ?, ?, ?, ?, ?)"); //подготовка запроса
        $result = $answer->execute(array($data['url'], $data['count'], $data['ip_first'], $data['ip_last'], $data['date_first'], $data['date_last']));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // Обновление записи ошибки 404 
    public function updateRecord404($data) {
        $answer = $this->connect_base->prepare("UPDATE $this->prefix".'logs_404'." SET count=?, ip_last=?, date_last=? WHERE url=?");
        $result = $answer->execute(array($data['count'], $data['ip_last'], $data['date_last'], $data['url']));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }   
    // получение записи 404 по url
    public function getRecordNotfoundByUrl($url, $fields=[]) {
        $fields_str = $this->iqarr($fields);
        $answer = $this->connect_base->prepare("SELECT $fields_str "
                . "FROM $this->prefix".'logs_404 '
                . "WHERE url=?");
        $answer->execute(array($url));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }       
    // Добавление в базу даных записей журнала
    public function addLog($data) {
        $answer = $this->connect_base->prepare("INSERT INTO $this->table "
                . "(text, ip, date, user_id, type, page) "
                . "VALUES (?, ?, ?, ?, ?, ?)"); //подготовка запроса
        $result = $answer->execute(array($data['text'], $data['ip'], $data['date'], $data['user_id'], $data['type'], $data['page']));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}
