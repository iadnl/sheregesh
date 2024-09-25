<?php
namespace Controllers;

class Main {
    public function index() {
        $main_model = new \Models\Main;
        $main_model->getMainPage();
    }
}
