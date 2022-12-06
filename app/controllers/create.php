<?php

class Create extends Controller{

    public function index(){
        global $loggedUser;
        $index = $this->model('Index');
        $this->view('home/create', ['user' => $loggedUser]);
    }
}