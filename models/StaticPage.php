<?php
namespace Models;

class StaticPage extends Model {
    public $table = 'static';
    
    function __construct() {
        parent::__construct();
        $this->table = $this->prefix.$this->table;
    } 
    public function getStaticPage($alt_name, $fields = []) {
        $fields_str = $this->iqarr($fields);
        $answer = $this->connect_base->prepare("SELECT $fields_str "
                . "FROM $this->table "
                . "WHERE alt_name=?");
        $answer->execute(array($alt_name));

        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function getAllPages($fields = []) {
        $fields_str = $this->iqarr($fields);
        $answer = $this->connect_base->query("SELECT $fields_str "
                . "FROM $this->table "
                . "ORDER BY date  DESC");
        $result = $answer->fetchAll(\PDO::FETCH_ASSOC);
        if ($result) { 
            return $result;
        } else {
            return false;
        }
    }
    public function getMediaPage($id, $count = NULL, $position = 0, $fields = []) {
        $fields_str = $this->iqarr($fields);
        if ($count===NULL) {
            $answer = $this->connect_base->prepare("SELECT $fields_str FROM ".$this->prefix.'static_media'." WHERE static_id=? ORDER BY date DESC");
            $answer->execute(array($id));
        } else {
            $answer = $this->connect_base->prepare("SELECT $fields_str FROM ".$this->prefix.'static_media'." WHERE static_id=? ORDER BY date DESC LIMIT ? OFFSET ? ");
            $answer->execute(array($id, $count, $position));
        }        
        $result = $answer->fetchAll(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }         
    public function isStaticPage($alt_name) {
        $answer = $this->connect_base->prepare("SELECT id "
                . "FROM $this->table "
                . "WHERE alt_name=?");
        $answer->execute(array($alt_name));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function isStaticPageByid($id) {
        $answer = $this->connect_base->prepare("SELECT EXISTS(SELECT title FROM $this->table WHERE id=?)");
        $answer->execute(array($id));
        $result = $answer->fetchColumn();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }    
}
