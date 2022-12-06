<?php 

class Session extends Database {

    function __construct(){
        parent::__construct();
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
     }

    function checkLogin(){
        if (isset($_SESSION['token'])){
            $result = pg_query_params($this->db, "SELECT * FROM users WHERE token = $1", [$_SESSION['token']]);
            if($result){
                if(pg_num_rows($result) > 0) return pg_fetch_assoc($result);
                else return false;
            } else{
                error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
                return false;
            }
        }
        return false;    
    }
}