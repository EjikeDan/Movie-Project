<?php

class Api extends Controller{

    public function __construct(){
        $inputJSON = file_get_contents('php://input');
        $this->input = $inputJSON ? json_decode($inputJSON) : false;
        header("Content-Type: application/json");
    }

    public function index(){
        echo 'Movies API';
    }

    public function getAllMovies(){
        $movies = $this->model('Movies');
        list($status, $data) = $movies->fetchAll();
        if($status) {
            $response = json_encode([
                'status' => true,
                'message' => 'Movies fetch successful',
                'data' => $data ? $data : []
            ]);
        } else {
            http_response_code(500);
            $response = json_encode([
                'status' => false,
                'message' => 'Error fetching movies'
            ]);
        }
        echo $response;
    }

    public function getSingleMovie(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            echo json_encode([
                'status' => false,
                'message' => 'Only POST method is allowed'
            ]);
            return;
        }
        if (!isset($this->input->slug)) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'slug is required'
            ]);
            return;
        }

        $movie = $this->model('Movies');
        list($status, $data) = $movie->fetchOne($this->input->slug);
        if($status) {
            $response = json_encode([
                'status' => true,
                'message' => 'Movie fetch successful',
                'data' => $data ? $data : []
            ]);
        } else {
            http_response_code(500);
            $response = json_encode([
                'status' => false,
                'message' => 'Error fetching movie'
            ]);
        }
        echo $response;
    }

    public function postMovieComment(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            echo json_encode([
                'status' => false,
                'message' => 'Only POST method is allowed'
            ]);
            return;
        }

        if (!isset($this->input->token)) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'token is required'
            ]);
            return;
        }

        $user = $this->model('User');
        $data = $user->getUser($this->input->token);
        if(!$data){
            http_response_code(500);
            echo json_encode([
                'status' => false,
                'message' => 'User not found'
            ]);
            return;
        }
        $userId = $data['id'];

        if (!isset($this->input->movieId)) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'movieId is required'
            ]);
            return;
        }

        if (!isset($this->input->comment)) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'comment is required'
            ]);
            return;
        }

        $movie = $this->model('Movies');
        $status = $movie->postComment($userId, $this->input->movieId, $this->input->comment);
        if($status) {
            $response = json_encode([
                'status' => true,
                'message' => 'Comment posted successfully'
            ]);
        } else {
            http_response_code(500);
            $response = json_encode([
                'status' => false,
                'message' => 'Error posting comment'
            ]);
        }
        echo $response;
    }

    public function createMovie(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            echo json_encode([
                'status' => false,
                'message' => 'Only POST method is allowed'
            ]);
            return;
        }

        if (!isset($_POST['token'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'token is required'
            ]);
            return;
        }

        $user = $this->model('User');
        $data = $user->getUser($_POST['token']);
        if(!$data){
            http_response_code(500);
            echo json_encode([
                'status' => false,
                'message' => 'User not found'
            ]);
            return;
        }

        if (!isset($_POST['name'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'name is required'
            ]);
            return;
        }

        if (!isset($_POST['description'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'description is required'
            ]);
            return;
        }

        if (!isset($_POST['release_date'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'release_date is required'
            ]);
            return;
        }

        if (!isset($_POST['rating'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'rating is required'
            ]);
            return;
        }

        if (!isset($_POST['ticket_price'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'ticket_price is required'
            ]);
            return;
        }

        if (!isset($_POST['country'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'country is required'
            ]);
            return;
        }

        if (!isset($_POST['genre'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'genre is required'
            ]);
            return;
        }

        if (empty($_FILES['file']['name'])) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'photo is required'
            ]);
            return;
        }

        $movie = $this->model('Movies');
        list($photo_path, $message) = $movie->uploadFile($_FILES['file']);
        if(!$photo_path){
            http_response_code(500);
            echo json_encode([
                'status' => false,
                'message' => $message
            ]);
            return;
        }

        $status = $movie->createMovie($_POST['name'], $_POST['description'], $_POST['release_date'], $_POST['rating'], $_POST['ticket_price'], $_POST['country'], $_POST['genre'], $photo_path);
        if($status) {
            $response = json_encode([
                'status' => true,
                'message' => 'Movie created successfully'
            ]);
        } else {
            http_response_code(500);
            $response = json_encode([
                'status' => false,
                'message' => 'Error creating movie'
            ]);
        }
        echo $response;
    }

    public function getMovieComments(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            echo json_encode([
                'status' => false,
                'message' => 'Only POST method is allowed'
            ]);
            return;
        }
        if (!isset($this->input->movie_id)) {
            http_response_code(400);
            echo json_encode([
                'status' => false,
                'message' => 'movie_id is required'
            ]);
            return;
        }

        $movie = $this->model('Movies');
        list($status, $data) = $movie->movieComments($this->input->movie_id);
        if($status) {
            $response = json_encode([
                'status' => true,
                'message' => 'Movie conmments fetch successful',
                'data' => $data ? $data : []
            ]);
        } else {
            http_response_code(500);
            $response = json_encode([
                'status' => false,
                'message' => 'Error fetching movie comments'
            ]);
        }
        echo $response;
    }
}