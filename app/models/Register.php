<?php 


class Register extends Database {

    public $email;
    public $password;
    public $name;
    public $token;

    public function userRegister(){
        $result = pg_query_params($this->db, "insert into users (name, email, password, token) values($1, $2, $3, $4)", [$this->name, $this->email, sha1($this->password), $this->token]);
        if($result){
            return true;
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return false;
        }
    }

}