<?php

class Home extends Controller{

    public function index(){
        header('Location: ' . URL . '/movies');
    }

    public function login(){
        $login = $this->model('Login');
        if(isset($_POST['email'])){
            $login->email = $_POST['email'];
            $login->password = $_POST['password'];
            $user = $login->userlogin();
            if(!$user){
                $this->view('home/login', ['error' => 'Invalid credentials']);
            }else{
                $_SESSION['token'] = $user['token'];
                header('Location: ' . URL . '/movies');                
            }
        }else{
                $this->view('home/login');
        }
    }

    public function register(){
        if(isset($_POST['email'])){
            $user = $this->model('User');
            $result = $user->getUserWithEmail($_POST['email']);
            if($result){
                $this->view('home/register', ['error' => 'Another user registered with email']);
                return;
            }

            $register = $this->model('Register');
            $register->email = $_POST['email'];
            $register->password = $_POST['password'];
            $register->name = $_POST['name'];
            $register->token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
            $user = $register->userRegister();
            if(!$user){
                $this->view('home/register', ['error' => 'Error registering user']);
            }else{
                $this->view('home/login', ['message' => 'Registeration successful. Login now']);
            }
        }else{
            $this->view('home/register');
        }
    }

    public function logout(){
            $logout = $this->model('Logout');
            $logout->userLogout();
            header('Location: ' . URL . '/movies');
    }
}