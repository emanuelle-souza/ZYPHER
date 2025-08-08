<?php

require_once '../config/database.php';

class Usuario {
    private $conn;
    private $table_name = "usuario";

    public $id_usuario;
    public $nome;
    public $email;
    public $telefone;
    public $cpf;
    public $senha;


    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para salvar um cadastro
    public function saveusuario() {
        $query = "INSERT INTO " . $this->table_name . "(nome, email, telefone, cpf, senha) 
                  VALUES (:nome, :email, :telefone, :cpf, :senha)";
        $stmt = $this->conn->prepare($query);

        // Criptografar a senha corretamente
        $senhaCriptografada = password_hash($this->senha, PASSWORD_DEFAULT);

        // Bind params to the query
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':senha', $this->senha);

        return $stmt->execute();
    }

    // Método para listar todos os cadastros
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para buscar um cadastro pelo ID
    public function getById($id_usuario) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para atualizar um cadastro
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, senha = :senha, WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);

        // Bind params to the query
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':id_usuario', $this->id_usuario);

        return $stmt->execute();
    }
     // Método para excluir um usuario pelo cpf
     public function deleteByCpf() {
        $query = "DELETE FROM " . $this->table_name . " WHERE cpf = :cpf";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cpf', $this->cpf);

        return $stmt->execute();
     }

       public function buscarPorEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



}

