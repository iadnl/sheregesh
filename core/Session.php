<?php
namespace Core;

class Session {
    public function is($key) {
        if (isset($_SESSION[$key])) {
            return true;
        } else {
            return false;
        }
    }
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    public function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return '';
        }
    }
    public function remove($key) {
        if ($this->is($key)) {
            unset($_SESSION[$key]);
            return true;
        } else {
            return false;
        }
    }
    public function setUserAuth($login, $degree, $id, $auth_key, $name, $surname, $patronymic) {
        $_SESSION["user_auth"] = true;
        $_SESSION["user_login"] = $login;
        $_SESSION["user_degree"] = $degree;
        $_SESSION["user_id"] = intval($id);
        $_SESSION["auth_key"] = $auth_key;
        $_SESSION["name"] = $name;
        $_SESSION["surname"] = $surname;
        $_SESSION["patronymic"] = $patronymic;
    }
    public function userIsAuth() {
        if ($this->is('user_auth')) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserFio() {
        if ($this->is('name')) {
            return $this->get('surname').' '.$this->get('name').' '.$this->get('patronymic');
        } else {
            return NULL;
        }
    }
    public function getUserId() {
        if ($this->is('user_id')) {
            return $this->get('user_id');
        } else {
            return NULL;
        }
    }
    public function getUserLogin() {
        if ($this->is('user_login')) {
            return $this->get('user_login');
        } else {
            return false;
        }
    }
    public function getUserDegree() {
        if ($this->is('user_degree')) {
            return $this->get('user_degree');
        } else {
            return 'guest';
        }
    }
    public function getUserAuthkey() {
        if ($this->is('auth_key')) {
            return $this->get('auth_key');
        } else {
            return false;
        }
    }
    public function logout() {
        $_SESSION = array();
        //session_destroy();
    }
}

