<?php

require_once '../config/database.php';

class Administrador {
    private $conn;
    private $table_name = "administrador";

    public $id_adm;
    public $nome;
    public $email;
    public $senha;


    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
