<?php

namespace Models;

class User extends Model {
    public $table = 'users';
    
    function __construct() {
        parent::__construct();
        $this->table = $this->prefix.$this->table;
    }      
    // Регистрация пользавателя
    public function registration($data_user) {
        $answer = $this->connect_base->prepare("INSERT INTO $this->table "
                . "(name, surname, patronymic, login, password, email, reg_date, ip_registration, auth_key) "
                . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"); //подготовка запроса
        $result = $answer->execute(array($data_user['name'], $data_user['surname'], $data_user['patronymic'],       $data_user['login'], $data_user['password'], $data_user['email'], $data_user['date'], $data_user['ip_registration'], $data_user['auth_key']));
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    // обновление auth_key пользователя по id 
    public function updateAuthDataUserById($user_id, $failed_login_count, $first_failed_login_time=false) {
        if ($first_failed_login_time) {
            $answer = $this->connect_base->prepare("UPDATE $this->table SET failed_login_count=?, first_failed_login_time=? WHERE id=?");
            $result = $answer->execute(array($failed_login_count, $first_failed_login_time, $user_id));
        } else {
            $answer = $this->connect_base->prepare("UPDATE $this->table SET failed_login_count=? WHERE id=?");
            $result = $answer->execute(array($failed_login_count, $user_id));
        }                
        if ($result) {
            return true;
        } else {
            return false;
        }
    }    
    // получение полей пользователя по id
    public function getUserById($id, $fields = []) {
        $fields_str = $this->iqarr($fields);
        $answer = $this->connect_base->prepare("SELECT $fields_str FROM $this->table WHERE id=?");
        $answer->execute(array($id));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        }
    }
    // авторизация пользователя по id в сессию
    public function authorizeUserById($user_id) {
        $session = new \Core\Session;
        $user = $this->getUserById($user_id);
        if ($user) {
            $session->setUserAuth($user['login'], $user['degree'], $user_id, $user['auth_key'], $user['name'], $user['surname'], $user['patronymic']);
        } else {
            return false;
        }
    }
    // получение id пользователя по логин
    public function getId($login) {
        $answer = $this->connect_base->prepare("SELECT id FROM $this->table WHERE login = ?");
        $answer->execute(array($login));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if (isset($result['id'])) {
            return $result['id']; // количество активных новостей
        } else {
            return 0;
        }
    }
    // обновление даты последнего посещения
    public function updateLastDateLastIp($id, $time, $ip_last) {
        $answer = $this->connect_base->prepare("UPDATE $this->table "
                . "SET last_date = ?, ip_last = ? "
                . "WHERE id=?");
        $result = $answer->execute(array($time, $ip_last, $id));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // обновление профиля пользователя
    public function updateUserProfile($login, $array_data) {
        $answer = $this->connect_base->prepare("UPDATE $this->table "
                . "SET name=?, email=?, gender=?, about_me=? "
                . "WHERE login=?");
        $result = $answer->execute(array($array_data['name'], $array_data['email'], $array_data['gender'], $array_data['about_me'], $login));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // обновление пароля пользователя
    public function updatePassword($login, $new_password) {
        $answer = $this->connect_base->prepare("UPDATE $this->table SET password=? WHERE login=?");
        $result = $answer->execute(array($new_password, $login));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // установка статуса наличия фотографии профиля пользвоателя
    public function updateUserPhotoStatus($login, $value=0) {
        $answer = $this->connect_base->prepare("UPDATE $this->table SET photo=? WHERE login=?");
        $result = $answer->execute(array($value, $login));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // получение полей пользователя по логину
    public function getUser($type='login', $value='', $fields = []) {
        $fields_str = $this->iqarr($fields);
        if ($type === 'login') {
            $answer = $this->connect_base->prepare("SELECT $fields_str FROM $this->table WHERE login=?");
        } else if ($type === 'email') {
            $answer = $this->connect_base->prepare("SELECT $fields_str FROM $this->table WHERE email=?");
        }        
        $answer->execute(array($value));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }    
    // Проверка на существование пользователя
    public function isUser($type, $value) {
        if ($type === 'login') {
            $answer = $this->connect_base->prepare("SELECT id FROM $this->table WHERE login=?");
        } else if ($type === 'email') {
            $answer = $this->connect_base->prepare("SELECT id FROM $this->table WHERE email=?");
        }
        $answer->execute(array($value));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // Проверка на существование пользователя
    public function isUserById($id) {
        $answer = $this->connect_base->prepare("SELECT name FROM $this->table WHERE id=?");
        $answer->execute(array($id));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // Проверка на блокировку пользователя
    public function isUserBlocked($id) {
        $answer = $this->connect_base->prepare("SELECT banned FROM $this->table WHERE id=?");
        $answer->execute(array($id));
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            if ($result['banned']===1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    // формирование списка пользователей
    public function userList() {
        $view = new \Core\View;
        $get = new \Core\Get;
        $pagination = new \Core\Pagination;
        
        // проверка на запрос поиска
        $search_query = $get->get('q');
        $type_search = 'login'; // по умолчанию поиск по логину
        if ($search_query === '') {
            $users_array = $this->getUsers($pagination->count, $pagination->position, ['login', 'name', 'reg_date', 'last_date', 'banned', 'photo']); //массив с пользователями	
        } else {
            if ($get->get('type') === 'name') { //поиск по логину или имени
                $type_search = 'name';
            }
            $users_array = $this->searchUsers($pagination->count, $pagination->position, $search_query, $type_search, ['login', 'name', 'reg_date', 'last_date', 'banned']); //массив с найденными пользователями
        }

        $content = $view->render('index', [
            'header' => $view->render('header', [
                'title' => 'Пользователи',
            ]),
            'main_content' => $view->render('user/user_list', [
                'users_array' => $users_array,
                'query' => $get->get('q'),
                'type' => $type_search,
                'pagination' => $pagination->html($this->countUsers()),
            ]),
            'footer' => $view->render('footer', []),
        ]);
        $view->send($content);
    }
    
    //--------------------private-------------------------------
    // получение всех полей пользователей с позиции и смещением
    private function getUsers($count, $position, $fields = []) {
        $fields_str = $this->iqarr($fields);
        $answer = $this->connect_base->prepare("SELECT $fields_str "
                . "FROM $this->table "
                . "LIMIT ? OFFSET ? ");
        $answer->execute(array($count, $position));
        $result = $answer->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    // поиск пользователей с позицией и смещением
    private function searchUsers($count, $position, $query, $type_search, $fields = []) {
        $query = "%" . $query . "%";
        $fields_str = $this->iqarr($fields);
        $answer = $this->connect_base->prepare("SELECT $fields_str "
                . "FROM $this->table "
                . "WHERE $type_search "
                . "LIKE ? LIMIT ? OFFSET ?");
        $answer->execute(array($query, $count, $position));
        $result = $answer->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    // Получение количества пользователей
    private function countUsers() {
        $answer = $this->connect_base->query("SELECT COUNT(*) "
                . "FROM $this->table");
        $result = $answer->fetch(\PDO::FETCH_ASSOC);
        if (isset($result['COUNT(*)'])) {
            return $result['COUNT(*)']; // количество активных новостей
        } else {
            return 0;
        }
    }
}
