<?php
// /zypher/controllers/FinalizarCompra.php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /zypher/views/LoginCliente.php?redirect=/zypher/views/Pagamento.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

try {
    $db = new Database();
    $pdo = $db->getConnection();

    // Busca carrinho do usuário
    $sqlCarrinho = "SELECT id FROM carrinho WHERE id_usuario = :id_usuario LIMIT 1";
    $stmt = $pdo->prepare($sqlCarrinho);
    $stmt->execute([':id_usuario' => $usuario_id]);
    $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$carrinho) {
        header("Location: /zypher/views/CarrinhoCliente.php?erro=vazio");
        exit;
    }
    $id_carrinho = $carrinho['id'];

    // Busca itens do carrinho
    $sqlItens = "SELECT ci.id_produto, ci.quantidade, p.preco, p.nome, p.imagem
                 FROM carrinho_itens ci
                 INNER JOIN produtos p ON ci.id_produto = p.id
                 WHERE ci.id_carrinho = :id_carrinho";
    $stmt = $pdo->prepare($sqlItens);
    $stmt->execute([':id_carrinho' => $id_carrinho]);
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($itens)) {
        header("Location: /zypher/views/CarrinhoCliente.php?erro=vazio");
        exit;
    }

    // Calcula subtotal
    $subtotal = 0;
    foreach ($itens as $item) {
        $subtotal += $item['preco'] * $item['quantidade'];
    }

    // Cupons válidos
    $cupons_validos = [
        'ZYPHER10' => 10.00,
        'ZYPHER20' => 20.00,
        'ZYPHER50' => 50.00
    ];

    // Pega o cupom enviado pelo formulário
    $cupom_code = isset($_POST['cupom_code']) && !empty($_POST['cupom_code']) 
                  ? trim($_POST['cupom_code']) 
                  : null;
    
    $desconto_cupom = 0.0;
    if ($cupom_code && isset($cupons_validos[$cupom_code])) {
        $desconto_cupom = $cupons_validos[$cupom_code];
    }

    // Frete (grátis por enquanto)
    $frete = 0.0;

    // Calcula total final (o mesmo cálculo que no frontend)
    $total_final = max(0, $subtotal - $desconto_cupom + $frete);

    // Pega o valor final enviado pelo frontend para validação
    $valor_enviado = isset($_POST['valor_final']) ? (float)$_POST['valor_final'] : null;
    
    // Valida se o valor bate (margem de 0.01 para arredondamento)
    if ($valor_enviado !== null && abs($total_final - $valor_enviado) > 0.01) {
        error_log("Divergência de valores: Calculado=$total_final, Enviado=$valor_enviado");
        // Usa o valor calculado no backend por segurança
    }

    // Método de pagamento
    $metodo_pagamento = isset($_POST['metodo_pagamento']) 
                        ? trim($_POST['metodo_pagamento']) 
                        : 'pix';
    
    // Valida método
    if (!in_array($metodo_pagamento, ['pix', 'card'])) {
        $metodo_pagamento = 'pix';
    }

    // Verifica se tem endereço (opcional, mas recomendado)
    $tem_endereco = isset($_SESSION['endereco_entrega']) && !empty($_SESSION['endereco_entrega']);
    
    // Inicia transação
    $pdo->beginTransaction();

    try {
        // Insere pedido
        $sqlPedido = "INSERT INTO pedido (
                        data_pedido, 
                        id_usuario, 
                        total, 
                        metodo_pagamento, 
                        status
                      ) VALUES (
                        NOW(), 
                        :id_usuario, 
                        :total, 
                        :metodo_pagamento, 
                        :status
                      )";
        
        $stmt = $pdo->prepare($sqlPedido);
        $stmt->execute([
            ':id_usuario' => $usuario_id,
            ':total' => $total_final,
            ':metodo_pagamento' => $metodo_pagamento,
            ':status' => 'aguardando_pagamento'
        ]);
        
        $id_pedido = $pdo->lastInsertId();

        // Insere itens do pedido
        $sqlInsertItem = "INSERT INTO pedido_produto (
                            id_pedido, 
                            id_produto, 
                            quantidade, 
                            preco_unitario
                          ) VALUES (
                            :id_pedido, 
                            :id_produto, 
                            :quantidade, 
                            :preco_unitario
                          )";
        
        $stmtInsert = $pdo->prepare($sqlInsertItem);
        
        foreach ($itens as $item) {
            $stmtInsert->execute([
                ':id_pedido' => $id_pedido,
                ':id_produto' => $item['id_produto'],
                ':quantidade' => $item['quantidade'],
                ':preco_unitario' => $item['preco']
            ]);

            // Opcional: Atualizar estoque dos produtos
            // $sqlEstoque = "UPDATE produtos SET estoque = estoque - :quantidade WHERE id = :id_produto";
            // $pdo->prepare($sqlEstoque)->execute([':quantidade' => $item['quantidade'], ':id_produto' => $item['id_produto']]);
        }

        // Limpa o carrinho
        $pdo->prepare("DELETE FROM carrinho_itens WHERE id_carrinho = :id_carrinho")
             ->execute([':id_carrinho' => $id_carrinho]);
        
        $pdo->prepare("DELETE FROM carrinho WHERE id = :id_carrinho")
             ->execute([':id_carrinho' => $id_carrinho]);

        // Commit da transação
        $pdo->commit();

        // Gera código de rastreamento
        $rastreamento = 'ZY' . strtoupper(bin2hex(random_bytes(5)));

        // Salva informações da compra na sessão
        $_SESSION['ultima_compra'] = [
            'id_pedido' => $id_pedido,
            'subtotal' => $subtotal,
            'desconto' => $desconto_cupom,
            'frete' => $frete,
            'total' => $total_final,
            'metodo' => $metodo_pagamento,
            'metodo_nome' => $metodo_pagamento === 'pix' ? 'PIX' : 'Cartão de Crédito',
            'rastreamento' => $rastreamento,
            'cupom' => $cupom_code,
            'itens' => $itens,
            'data' => date('d/m/Y H:i'),
            'tem_endereco' => $tem_endereco
        ];

        // Limpa cupom da sessão se existir
        if (isset($_SESSION['cupom'])) {
            unset($_SESSION['cupom']);
        }

        // Redireciona para página de confirmação
        header("Location: /zypher/views/CompraFinalizada.php");
        exit;

    } catch (Exception $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        throw $e;
    }

} catch (PDOException $e) {
    error_log("Erro ao finalizar compra: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    // Exibe erro detalhado em desenvolvimento
    if (ini_get('display_errors')) {
        die("Erro PDO: " . $e->getMessage());
    }
    
    // Redireciona com mensagem de erro
    header("Location: /zypher/views/Pagamento.php?erro=falha_processamento");
    exit;
    
} catch (Exception $e) {
    error_log("Erro geral ao finalizar compra: " . $e->getMessage());
    
    if (ini_get('display_errors')) {
        die("Erro: " . $e->getMessage());
    }
    
    header("Location: /zypher/views/Pagamento.php?erro=erro_sistema");
    exit;
}
?>