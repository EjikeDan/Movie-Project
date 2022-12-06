<?php

class Database extends Common {

    protected $db;

    function __construct(){
        $this->openDatabaseConnection();
    }

    function __destruct() {
        $this->closeDatabaseConnection();
    }

    private function openDatabaseConnection()
    {
        $host        = "host = ".DB_HOST;
        $port        = "port = ".DB_PORT;
        $dbname      = "dbname = movies_db";
        $credentials = "user = ".DB_USER." password = ".DB_PASS;

        $this->db = pg_connect("$host $port $dbname $credentials");
        if(pg_connection_status($this->db) !== PGSQL_CONNECTION_OK){
            echo "Failed to connect to Database: " . pg_last_error($this->db);
        }
   
    }

    private function closeDatabaseConnection()
    {
        //pg_close($this->db);   
    }

}