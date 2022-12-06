<?php 

class User extends Database {

    public function getUser($token){
        $result = pg_query_params($this->db, "SELECT * FROM users WHERE token = $1", [$token]);
        if($result){
            if(pg_num_rows($result) > 0) return pg_fetch_assoc($result);
            else return false;
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return false;
        }
    }

    public function getUserWithEmail($email){
        $result = pg_query_params($this->db, "SELECT * FROM users WHERE email = $1", [$email]);
        if($result){
            if(pg_num_rows($result) > 0) return pg_fetch_assoc($result);
            else return false;
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return false;
        }
    }

}