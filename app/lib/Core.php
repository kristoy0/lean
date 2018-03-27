<?php

class Core {
    private $controller = null;
    private $method = null;
    private $params = [];

    public function __construct() {
        $this->fetchUrl();

        if (!$this->controller) {
            require APP.'controllers'.DS.'Home.php';
            $page = new Home();
            $page->index();

        } elseif(file_exists(APP.'controllers'.DS.ucwords($this->controller).'.php')) {
            require_once APP.'controllers'.DS.ucwords($this->controller).'.php';
            $this->controller = new $this->controller;

            if (method_exists($this->controller, $this->method)) {
                $this->method = $this->method;
            } else {
                $this->method = 'index';
            }

            call_user_func_array([$this->controller, $this->method], $this->params);
        }
    }

    private function fetchUrl() {
        if (isset($_GET['url'])) {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->controller = isset($url[0]) ? $url[0] : null;
            $this->method = isset($url[1]) ? $url[1] : null;

            unset($url[0], $url[1]);

            $this->params = $url ? array_values($url) : [];
        }
    }
}