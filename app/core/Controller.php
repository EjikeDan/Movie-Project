<?php 

class Controller{

    public function model($model){
            require_once getcwd().'/app/models/Session.php';
            global $loggedUser;
            $session = new Session;
            $loggedUser = $session->checkLogin();

            if($loggedUser && $model == 'Login'){
                header('Location: ' . URL . '/movies');
            } 

            require_once getcwd().'/app/models/' . $model . '.php';
            return new $model();
    }

    public function view($view, $data = []){
        //including the header, the view and the footer    
        require_once getcwd().'/app/views/layout/header.php';
        require_once getcwd().'/app/views/' . $view . '.php';
        require_once getcwd().'/app/views/layout/footer.php';
    }

}