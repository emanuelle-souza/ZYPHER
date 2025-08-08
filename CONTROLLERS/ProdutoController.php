<?php
require_once __DIR__ . '/../config/database.php';

class ProdutoController {
    
    public static function listarProdutos() {
    $db = new Database();
    $pdo = $db->getConnection();

    try {
        $stmt = $pdo->prepare("SELECT id, nome, marca, preco FROM produtos ORDER BY data_cadastro DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao buscar produtos: " . $e->getMessage());
    }
}


    public static function buscarProdutoPorId($id) {
        global $pdo;

        try {
            $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao buscar produto: " . $e->getMessage());
        }
    }
}
