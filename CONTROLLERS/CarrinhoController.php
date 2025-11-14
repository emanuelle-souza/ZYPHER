<?php
require_once __DIR__ . '/../config/database.php';

class CarrinhoController {
    // Adiciona produto 
public static function adicionarProduto($idUsuario, $idProduto, $tamanho, $quantidade = 1) {
    $db = new Database();
    $pdo = $db->getConnection();

    // BUSCA PRODUTO COM PREÇO E DESCONTO
    $stmt = $pdo->prepare("SELECT preco, desconto FROM produtos WHERE id = ?");
    $stmt->execute([$idProduto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) return false;

    $preco_original = floatval($produto['preco']);
    $desconto = floatval($produto['desconto'] ?? 0);
    $isMembro = isset($_SESSION['membro']) && $_SESSION['membro'];
    $preco_final = $isMembro ? $preco_original * (1 - $desconto / 100) : $preco_original;

    // PEGA OU CRIA CARRINHO
    $stmt = $pdo->prepare("SELECT id FROM carrinho WHERE id_usuario = ?");
    $stmt->execute([$idUsuario]);
    $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$carrinho) {
        $stmt = $pdo->prepare("INSERT INTO carrinho (id_usuario) VALUES (?)");
        $stmt->execute([$idUsuario]);
        $carrinhoId = $pdo->lastInsertId();
    } else {
        $carrinhoId = $carrinho['id'];
    }

    // VERIFICA SE JÁ EXISTE
    $stmt = $pdo->prepare("SELECT id, quantidade FROM carrinho_itens WHERE id_carrinho = ? AND id_produto = ? AND tamanho = ?");
    $stmt->execute([$carrinhoId, $idProduto, $tamanho]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        $novaQtd = $item['quantidade'] + $quantidade;
        $stmt = $pdo->prepare("UPDATE carrinho_itens SET quantidade = ?, preco_unitario = ? WHERE id = ?");
        $stmt->execute([$novaQtd, $preco_final, $item['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO carrinho_itens (id_carrinho, id_produto, tamanho, quantidade, preco_unitario) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$carrinhoId, $idProduto, $tamanho, $quantidade, $preco_final]);
    }
}

    // Lista os itens do carrinho 
   public static function listarCarrinho($idUsuario) {
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("
        SELECT 
            ci.id AS carrinho_item_id, 
            ci.id_produto, 
            p.nome, 
            ci.preco_unitario AS preco, 
            p.imagem, 
            ci.tamanho, 
            ci.quantidade 
        FROM carrinho_itens ci
        INNER JOIN carrinho c ON ci.id_carrinho = c.id
        INNER JOIN produtos p ON ci.id_produto = p.id
        WHERE c.id_usuario = ?
    ");
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Retorna total numérico do carrinho do usuário (float)
public static function calcularTotal($idUsuario) {
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("
        SELECT SUM(ci.preco_unitario * ci.quantidade) AS total
        FROM carrinho_itens ci
        INNER JOIN carrinho c ON ci.id_carrinho = c.id
        WHERE c.id_usuario = ?
    ");
    $stmt->execute([$idUsuario]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($row['total']) ? (float)$row['total'] : 0.0;
}


    public static function limparCarrinho($idUsuario) {
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("DELETE FROM carrinho WHERE id_usuario = ?");
        $stmt->execute([$idUsuario]);
    }

    // Remove item 
public static function removerItem($idUsuario, $idProduto, $tamanho) {
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("SELECT id FROM carrinho WHERE id_usuario = ?");
    $stmt->execute([$idUsuario]);
    $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$carrinho) {
        throw new Exception("Carrinho não encontrado");
    }

    $stmt = $pdo->prepare("DELETE FROM carrinho_itens WHERE id_carrinho = ? AND id_produto = ? AND tamanho = ?");
    $ok = $stmt->execute([$carrinho['id'], $idProduto, $tamanho]);

    if (!$ok) {
        throw new Exception("Falha ao remover item do banco");
    }
}

    // Atualiza quantidade (nova função) — se quantidade <=0 remove o item
    public static function atualizarQuantidade($idUsuario, $idProduto, $tamanho, $quantidade) {
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("SELECT id FROM carrinho WHERE id_usuario = ?");
    $stmt->execute([$idUsuario]);
    $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$carrinho) return false;

    if ($quantidade <= 0) {
        $stmt = $pdo->prepare("DELETE FROM carrinho_itens WHERE id_carrinho = ? AND id_produto = ? AND tamanho = ?");
        $stmt->execute([$carrinho['id'], $idProduto, $tamanho]);
        return true;
    } else {
        // Pega o preço com desconto atual
        $stmt = $pdo->prepare("SELECT preco, desconto FROM produtos WHERE id = ?");
        $stmt->execute([$idProduto]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        $preco_original = floatval($produto['preco']);
        $desconto = floatval($produto['desconto'] ?? 0);
        $isMembro = isset($_SESSION['membro']) && $_SESSION['membro'];
        $preco_final = $isMembro ? $preco_original * (1 - $desconto / 100) : $preco_original;

        $stmt = $pdo->prepare("
            UPDATE carrinho_itens 
            SET quantidade = ?, preco_unitario = ? 
            WHERE id_carrinho = ? AND id_produto = ? AND tamanho = ?
        ");
        $stmt->execute([$quantidade, $preco_final, $carrinho['id'], $idProduto, $tamanho]);
        return true;
    }
}
}
?>
   
