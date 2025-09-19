<?php
require_once '../config/database.php';

class HomePageController {
    public function exibirProdutos() {
        $db = new Database();
        $pdo = $db->getConnection();

        try {
            $query = "SELECT nome, marca, descricao, preco, imagem FROM produtos";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            include '../views/HomeCliente.php';
        } catch (PDOException $e) {
            echo "Erro ao buscar produtos: " . $e->getMessage();
        }
    }
}
