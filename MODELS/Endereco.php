<?php

require_once '../config/database.php';

class Endereco {
    private $conn;
    private $table_name = "endereco";

    public $id_usuario;
    public $nome;
    public $telefone;
    public $email;
    public $cep;
    public $endereco_entrega;
    public $numero;
    public $cidade;
    public $estado;


    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para salvar um cadastro
    public function salvaend() {
        $query = "INSERT INTO " . $this->table_name . " (nome, telefone, email, cep, endereco_entrega, numero, cidade, estado) 
                  VALUES (:nome, :telefone, :email, :cep, :endereco_entrega, :numero, :cidade, :estado)";
        $stmt = $this->conn->prepare($query);

        // Bind params to the query
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':endereco_entrega', $this->endereco_entrega);
        $stmt->bindParam(':numero', $this->numero);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':estado', $this->estado);

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
        $query = "UPDATE " . $this->table_name . " SET nome = :nome,  telefone = :telefone, email = :email, cep = :cep, endereco_entrega = :endereco_entrega, numero = :numero, cidade = :cidade, estado = :estado WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);

        // Bind params to the query
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':endereco_entrega', $this->endereco_entrega);
        $stmt->bindParam(':numero', $this->numero);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':estado', $this->estado);

        return $stmt->execute();
    }
}
