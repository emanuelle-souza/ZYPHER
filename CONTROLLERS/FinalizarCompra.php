<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/LoginCliente.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

try {
    $db = new Database();
     $pdo = $db->getConnection();

    // 1️⃣ Busca o carrinho do usuário
    $sqlCarrinho = "SELECT id FROM carrinho WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sqlCarrinho);
    $stmt->execute([':id_usuario' => $usuario_id]);
    $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$carrinho) {
        header("Location: ../views/CarrinhoCliente.php?erro=vazio");
        exit;
    }

    $id_carrinho = $carrinho['id'];

    // 2️⃣ Busca os itens do carrinho
    $sqlItens = "SELECT ci.id_produto, ci.quantidade, p.preco
                 FROM carrinho_itens ci
                 INNER JOIN produtos p ON ci.id_produto = p.id
                 WHERE ci.id_carrinho = :id_carrinho";
    $stmt = $pdo->prepare($sqlItens);
    $stmt->execute([':id_carrinho' => $id_carrinho]);
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($itens)) {
        header("Location: ../views/CarrinhoCliente.php?erro=vazio");
        exit;
    }

    // 3️⃣ Cria o pedido
    $sqlPedido = "INSERT INTO pedido (data_pedido, id_usuario) 
                  VALUES (NOW(), :id_usuario)";
    $stmt = $pdo->prepare($sqlPedido);
    $stmt->execute([':id_usuario' => $usuario_id]);
    $id_pedido = $pdo->lastInsertId();

    // 4️⃣ Insere os produtos no pedido_produto
    $sqlInsertItem = "INSERT INTO pedido_produto (id_pedido, id_produto, quantidade)
                      VALUES (:id_pedido, :id_produto, :quantidade)";
    $stmtInsert = $pdo->prepare($sqlInsertItem);

    foreach ($itens as $item) {
        $stmtInsert->execute([
            ':id_pedido' => $id_pedido,
            ':id_produto' => $item['id_produto'],
            ':quantidade' => $item['quantidade']
        ]);
    }

    // 5️⃣ Limpa o carrinho e seus itens
    $pdo->prepare("DELETE FROM carrinho_itens WHERE id_carrinho = :id_carrinho")
         ->execute([':id_carrinho' => $id_carrinho]);
    $pdo->prepare("DELETE FROM carrinho WHERE id = :id_carrinho")
         ->execute([':id_carrinho' => $id_carrinho]);

    // 6️⃣ Redireciona para página visual de sucesso
    header("Location: ../views/CompraFinalizada.php");
    exit;

} catch (PDOException $e) {
    echo "Erro ao finalizar compra: " . $e->getMessage();
}
