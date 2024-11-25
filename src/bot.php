<?php
require "vendor/autoload.php";
require "src/DB.php";
use GuzzleHttp\Client;

class Bot {
    const API_URL = 'https://api.telegram.org/bot';
    private $token = '7690320134:AAHBcOfzOZwtgZO_2WIH5WYpatxC5I3G6J8';
    public $client;
    public function makeRequest($method, $data = []) {
        $this->client = new Client([
            'base_uri' => self::API_URL . $this->token . '/',
            'timeout'  => 2.0,
        ]);

        $request = $this->client->request('POST', $method, ['json' => $data]);

        return json_decode($request->getBody()->getContents());
    }
    public function saveUser($user_id, $username): bool {
        $query = "INSERT INTO tgusers (user_id, username) VALUES (:user_id, :username)";
        $db = new DB();
        return $db->conn->prepare($query)->execute([
            ':user_id' => $user_id,
            ':username' => $username
        ]);
    }

    public function getUser($user_id):bool|array {
        $query = "SELECT * FROM tgusers WHERE user_id = :user_id";
        $db = new DB();
        $stmt = $db->conn->prepare($query);
        $stmt->execute([
            ':user_id' => $user_id
        ]);
        return $stmt->fetch();
    }
}