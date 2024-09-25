<?php
namespace Core;

class Journal
{
    public function add404() {
        $server = new \Core\Server;
        $session = new \Core\Session;
        $journal_model = new \Models\Journal;
        $url = new \Core\Url;               
                
        $url_404 = $url->getFullUrl();
        $ip = $server->getClientIp();
        $date = time();
        
        $record = $journal_model->getRecordNotfoundByUrl($url_404);
        if ($record) {
            $array_data = array(
                'url' => $url_404,
                'count' => (int)$record['count']+1,
                'ip_last' => $ip,
                'date_last' => $date,
            );    
            return $journal_model->updateRecord404($array_data);
        }
        
        // новая запись
        $array_data = array(
            'url' => $url_404,
            'count' => 1,
            'ip_first' => $ip,
            'ip_last' => $ip,
            'date_first' => $date,
            'date_last' => $date,
        );    
        $journal_model->addLog404($array_data);
        
    }
    // добавление сообщения в базу данных
    public function add($type, $text, $data='') {
        $server = new \Core\Server;
        $session = new \Core\Session;
        $journal_model = new \Models\Journal;
        
        $data_string = '[';
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data_string .= $key.' : '.$value;
            }
        } else {
            $data_string .= $data;
        } 
        $data_string .= ']';
        $ip = $server->getClientIp();
        $date = time();
        $user_id = $session->getUserId();
        $page = $server->getClientReferer();
        $text = $text.' '.$data_string;
        
        $array_data = array(
            'text' => $text,
            'ip' => $ip,
            'date' => $date,
            'user_id' => $user_id,
            'type' => $type,
            'page' => $page,
        );
        $journal_model->addLog($array_data);
    }
}