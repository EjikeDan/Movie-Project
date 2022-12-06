<?php 


class Login extends Database {

    public $email;
    public $password;

    public function userLogin(){
        $result = pg_query_params($this->db, "SELECT * FROM users WHERE email = $1 AND password = $2", [$this->email, sha1($this->password)]);
        if($result){
            if(pg_num_rows($result) > 0) return pg_fetch_assoc($result);
            else return false;
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return false;
        }

    }

}