<?php

class Route
{
    private $page = 'home';
    private $method = 'index';
    private $data = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (empty($url)) {
            $this->page = "celatuk";
            require_once "../app/controllers/{$this->page}.php";
            $this->page = new $this->page;
            call_user_func_array([$this->page, $this->method], $this->data);
            exit;
        }

        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->page = $url[0];
            unset($url[0]);
        }

        require_once "../app/controllers/{$this->page}.php";
        $this->page = new $this->page;

        if (isset($url[1])) {
            if (method_exists($this->page, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if (!empty($url)) {
            $this->data = array_values($url);
        }

        call_user_func_array([$this->page, $this->method], $this->data);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
