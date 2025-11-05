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

    public function saveusuario() {
    // Verificar se o email já existe
    $checkQuery = "SELECT id_usuario FROM " . $this->table_name . " WHERE email = :email";
    $checkStmt = $this->conn->prepare($checkQuery);
    $checkStmt->bindParam(':email', $this->email);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Já existe → atualizar
        $query = "UPDATE " . $this->table_name . "
                  SET nome = :nome, telefone = :telefone, cpf = :cpf, senha = :senha, membro = 1
                  WHERE email = :email";
    } else {
        // Não existe → inserir novo
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, email, telefone, cpf, senha, membro)
                  VALUES (:nome, :email, :telefone, :cpf, :senha, 1)";
    }

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':nome', $this->nome);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':telefone', $this->telefone);
    $stmt->bindParam(':cpf', $this->cpf);
    $stmt->bindParam(':senha', $this->senha);

    return $stmt->execute();
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
    // public function updateUsuario() {
    //     $query = "UPDATE " . $this->table_name . " SET nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, senha = :senha WHERE id_usuario = :id_usuario";
    //     $stmt = $this->conn->prepare($query);

    //     // Bind params to the query
    //     $stmt->bindParam(':nome', $this->nome);
    //     $stmt->bindParam(':email', $this->email);
    //     $stmt->bindParam(':telefone', $this->telefone);
    //     $stmt->bindParam(':cpf', $this->cpf);
    //     $stmt->bindParam(':senha', $this->senha);
    //     $stmt->bindParam(':id_usuario', $this->id_usuario);

    //     return $stmt->execute();
    // }
     // Método para excluir um usuario pelo cpf
     public function deleteByCpf() {
        $query = "DELETE FROM " . $this->table_name . " WHERE cpf = :cpf";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cpf', $this->cpf);

        return $stmt->execute();
     }
     // Método para buscar um usuario pelo email
     
       public function buscarPorEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatemembro() {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, senha = :senha, membro = TRUE WHERE id_usuario = :id_usuario";
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



}

