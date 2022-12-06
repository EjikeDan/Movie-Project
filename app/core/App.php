<?php

class App{

    protected $controller = 'home';
    protected $method = 'index';
    // protected $language = 'en';
    protected $params = [];

    public function __construct(){
    
        $req = $this->parseUrl();

        if(file_exists(getcwd().'/app/controllers/' . $req[0] . '.php')){
            $this->controller = $req[0];
            unset($req[0]);
        }    

        require_once getcwd().'/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if(isset($req[1])){
            if(method_exists($this->controller,$req[1])){
                $this->method = $req[1];
                unset($req[1]);
            }

        }
        $this->params = $req ? array_values($req): [];

        call_user_func_array([$this->controller,$this->method], $this->params);
    }

    public function parseUrl(){
        if(isset($_SERVER['REQUEST_URI'])){
            return $req = explode('/',filter_var(rtrim($_GET['req'],'/'),FILTER_SANITIZE_URL));
        }
    }

}
