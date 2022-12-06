<?php 


class Logout extends Database {

    public function userLogout(){
        $_SESSION = array();
        session_destroy();                
    }

}