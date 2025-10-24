<?php
require_once '../config/database.php';

class CarrinhoController {
    public static function adicionarProduto($idUsuario, $idProduto, $tamanho, $quantidade = 1) {
        $db = new Database();
        $pdo = $db->getConnection();

        // Verifica se o usuário já tem um carrinho
        $stmt = $pdo->prepare("SELECT id FROM carrinho WHERE id_usuario = ?");
        $stmt->execute([$idUsuario]);
        $carrinho = $stmt->fetch();

        if (!$carrinho) {
            $stmt = $pdo->prepare("INSERT INTO carrinho (id_usuario) VALUES (?)");
            $stmt->execute([$idUsuario]);
            $carrinhoId = $pdo->lastInsertId();
        } else {
            $carrinhoId = $carrinho['id'];
        }

        // Verifica se o item já existe
        $stmt = $pdo->prepare("SELECT * FROM carrinho_itens WHERE id_carrinho = ? AND id_produto = ? AND tamanho = ?");
        $stmt->execute([$carrinhoId, $idProduto, $tamanho]);
        $item = $stmt->fetch();

        if ($item) {
            // Atualiza quantidade
            $novaQtd = $item['quantidade'] + $quantidade;
            $stmt = $pdo->prepare("UPDATE carrinho_itens SET quantidade = ? WHERE id = ?");
            $stmt->execute([$novaQtd, $item['id']]);
        } else {
            // Adiciona novo item
            $stmt = $pdo->prepare("INSERT INTO carrinho_itens (id_carrinho, id_produto, tamanho, quantidade) VALUES (?, ?, ?, ?)");
            $stmt->execute([$carrinhoId, $idProduto, $tamanho, $quantidade]);
        }
    }

    public static function listarCarrinho($idUsuario) {
        $db = new Database();
        $pdo = $db->getConnection();

        $stmt = $pdo->prepare("
            SELECT p.nome, p.preco, p.imagem, ci.tamanho, ci.quantidade 
            FROM carrinho_itens ci
            INNER JOIN carrinho c ON ci.id_carrinho = c.id
            INNER JOIN produtos p ON ci.id_produto = p.id
            WHERE c.id_usuario = ?
        ");
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function limparCarrinho($idUsuario) {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("DELETE FROM carrinho WHERE id_usuario = ?");
        $stmt->execute([$idUsuario]);
    }

    public static function removerItem($idUsuario, $idProduto, $tamanho) {
    $db = new Database();
    $pdo = $db->getConnection();

    // Encontra o carrinho do usuário
    $stmt = $pdo->prepare("SELECT id FROM carrinho WHERE id_usuario = ?");
    $stmt->execute([$idUsuario]);
    $carrinho = $stmt->fetch();

    if ($carrinho) {
        $stmt = $pdo->prepare("DELETE FROM carrinho_itens WHERE id_carrinho = ? AND id_produto = ? AND tamanho = ?");
        $stmt->execute([$carrinho['id'], $idProduto, $tamanho]);
    }
}

}
?>
