<?php
require_once __DIR__ . '/../config/database.php';

class ProdutoController {
    
    public static function listarProdutos() {
    $db = new Database();
    $pdo = $db->getConnection();

    try {
        $stmt = $pdo->prepare("SELECT id, nome, marca, descricao, preco, imagem FROM produtos ORDER BY data_cadastro DESC");
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

public static function listarPorCategoria($id_categoria) {
    $db = new Database();  
    $pdo = $db->getConnection();  

    try {
        $sql = "
            SELECT p.*, c.nome AS categoria_nome 
            FROM produtos p
            JOIN categorias c ON p.id_categoria = c.id_categoria
            WHERE p.id_categoria = :id_categoria AND p.estoque > 0
            ORDER BY p.data_cadastro DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao listar produtos por categoria: " . $e->getMessage());
        return [];
    }
}
}
