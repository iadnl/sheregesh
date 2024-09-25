<?php
namespace Models;

class Model {
    public $connect_base;
    public  $prefix;
    public $log;

    function __construct() {
        $init_base = new \Core\DataBase;
        $this->log = new \Core\Journal;
        $config = new \Configuration\Config;

        $this->connect_base = $init_base::getConnection();
        $this->prefix = $config->getDataBase('prefix');
    }
    public function iqarr($fields=[], $prefix='') {
        if (count($fields)===0) {
            return '*';
        } else {
            foreach ($fields as $key => $value) {
                $fields[$key] = $prefix.$value;
            }
            $string_elements = implode(',', $fields);
            return $string_elements;
        }
    }
    public function escape($html) {
        if (is_array($html)) {
            foreach ($html as $key => $elem) {
                if (is_array($elem)) {
                    $html[$key] = $this->escape($elem);
                } else {
                    if ($elem) {
                        $html[$key] = htmlspecialchars($elem);
                    }
                }
            }
            return $html;
        } else {
            if ($html) {
                return htmlspecialchars($html);
            } else {
                return $html;
            }
            
        }
    }    
}
