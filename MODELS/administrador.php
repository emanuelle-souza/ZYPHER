<?php
class Administrador {
    private $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $database = new Database();
        $pdo = $database->getConnection();
        $this->pdo = $pdo;
    }

   
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM administrador WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $senha) {
        $admin = $this->buscarPorEmail($email);
        if ($admin && $senha === $admin['senha']) {
            return $admin;
        }
        return false;
    }

    public function getById($id) {
        $sql = "SELECT id_adm as id, nome, email, telefone FROM administrador WHERE id_adm = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>