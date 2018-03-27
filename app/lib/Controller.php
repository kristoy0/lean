<?php

class Controller {
    public function model($model) {
        require_once APP.'/models/'.$model.'.php';

        return new $model();
    }

    public function view($view, $data = []) {
        if (file_exists(APP.'views'.DS.$view.'.php')) {
            require_once APP.'views'.DS.$view.'.php';
        } else {
            echo APP.'views'.DS.$view.'.php';
            die('View doesn\'t exist');
        }
    }
}