<?php

require_once '../config/database.php';

class Administrador {
    private $conn;
    private $table_name = "administrador";

    public $administrador;
    public $email;
    public $senha;
    public $nome;
   


    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

 public function save() {
    $query = "INSERT INTO " . $this->table_name . " (email, senha, nome) VALUES (:email, :senha, :nome)";
    $stmt = $this->conn->prepare($query);

    // Criptografar a senha corretamente
    $senhaCriptografada = password_hash($this->senha, PASSWORD_DEFAULT);

    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':senha', $senhaCriptografada);
    $stmt->bindParam(':nome', $this->nome);

    return $stmt->execute();
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
