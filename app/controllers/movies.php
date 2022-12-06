<?php

class Movies extends Controller{

    public function index($slug = ''){
        
        global $loggedUser;
        $index = $this->model('Index');

        if($slug == ''){
            $this->view('home/index', ['user' => $loggedUser]);
        } else{
            $this->view('home/movie', ['user' => $loggedUser, 'slug' => $slug]);
        }
    }

}