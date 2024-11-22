<?php

class DB {
    public $host = "localhost";
    public $user = "root";
    public $pass = "Maftuna@2005";
    public $db_name = "currencyconverter";
    public $conn;
    public function __construct(){
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user, $this->pass);
    }
}