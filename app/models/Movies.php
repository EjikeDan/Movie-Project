<?php 

class Movies extends Database {

    public function fetchAll(){
        $result = pg_query($this->db, "SELECT * FROM movies ORDER BY id DESC ");
        if($result){
            $data = pg_fetch_all($result);
            if($data){
                foreach($data as &$row){
                    $row['photo'] = URL.$row['photo'];
                }
            }
            return [true, $data];
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return [false, null];
        }
    }

    public function fetchOne($slug){
        $result = pg_query_params($this->db, "SELECT * FROM movies WHERE slug = $1", [$slug]);
        if($result){
            $data = pg_fetch_assoc($result);
            if($data){
                $data['photo'] = URL.$data['photo'];
            }
            return [true, $data];
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return [false, null];
        }
    }

    public function postComment($user_id, $movie_id, $comment){
        $result = pg_query_params($this->db, "insert into movie_comments (user_id, movie_id, comment) values($1, $2, $3)", [$user_id, $movie_id, $comment]);
        if($result){
            return true;
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return false;
        }
    }

    public function createMovie($name, $description, $release_date, $rating, $ticket_price, $country, $genre, $photo){
        $result = pg_query_params($this->db, "insert into movies (name, description, release_date, rating, ticket_price, country, genre, photo, slug) values($1, $2, $3, $4, $5, $6, $7, $8, $9)",
        [$name, $description, strval($release_date), intval($rating), $ticket_price, $country, $genre, $photo, strtolower(str_replace(" ", "-", $name.'-'.$release_date))]);
        if($result){
            return true;
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return false;
        }
    }

    public function uploadFile($file){
        $fileName  =  $file['name'];
        $tempPath  =  $file['tmp_name'];

        $upload_path = getcwd()."/assets/images/";
        $saved_path = "/assets/images/";

        if(!in_array(strtolower(pathinfo($fileName, PATHINFO_EXTENSION)), ['jpeg', 'jpg', 'png'])){
            return [false, 'File extension not allowed'];
        } else {
            $fileName = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8).$fileName;
            if(move_uploaded_file($tempPath, $upload_path . $fileName)){
                return [$saved_path . $fileName, 'success'];
            } else {
                return [false, 'Error uploading file'];
            }
        }
    }

    public function movieComments($id){
        $result = pg_query_params($this->db, "SELECT * FROM movie_comments mc JOIN users u ON u.id = mc.user_id WHERE movie_id = $1 ORDER BY mc.id DESC", [$id]);
        if($result){
            $data = pg_fetch_all($result);
            return [true, $data];
        } else{
            error_log("[".date('Y-m-d H:i:s')."] ".pg_last_error($this->db)."\r\n", 3, getcwd()."/logs/error.log");
            return [false, null];
        }
    }

}