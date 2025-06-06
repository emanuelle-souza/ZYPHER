<?php
require_once '../config/database.php';

class Giftcard {
    private $conn;
    private $table_name = "giftcard";

    public $codigo;
    public $saldo;
    public $expiracao;
    public $ativo;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function adicionar($codigo, $saldo, $expiracao, $ativo = 1) {
        $stmt = $this->conn->prepare("INSERT INTO giftcard (codigo, saldo, expiracao, ativo) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$codigo, $saldo, $expiracao, $ativo]);
    }

    public function listarDisponiveis() {
        $stmt = $this->conn->prepare("SELECT * FROM giftcard WHERE ativo = TRUE AND expiracao >= CURDATE()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function resgatar($codigo) {
        $stmt = $this->conn->prepare("SELECT * FROM giftcard WHERE codigo = ? AND ativo = TRUE AND expiracao >= CURDATE()");
        $stmt->execute([$codigo]);
        $giftcard = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($giftcard) {
            // Desativa o giftcard após resgate
            $update = $this->conn->prepare("UPDATE giftcard SET ativo = FALSE WHERE id_giftcard = ?");
            $update->execute([$giftcard['id_giftcard']]);
            return $giftcard;
        }

        return null;
    }
}

