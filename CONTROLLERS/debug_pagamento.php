<?php
// /zypher/debug_pagamento.php
// Script para testar o fluxo de pagamento e identificar problemas

session_start();
require_once __DIR__ . '/config/database.php';

echo "<h1>Debug - Fluxo de Pagamento</h1>";
echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// 1. Verifica sessão do usuário
echo "<h2>1. Verificando Sessão</h2>";
if (isset($_SESSION['usuario_id'])) {
    echo "<p class='success'>✓ Usuário logado: ID = " . $_SESSION['usuario_id'] . "</p>";
    $usuario_id = $_SESSION['usuario_id'];
} else {
    echo "<p class='error'>✗ Usuário NÃO está logado</p>";
    die("Faça login primeiro!");
}

// 2. Verifica endereço
echo "<h2>2. Verificando Endereço</h2>";
try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    $sql = "SELECT * FROM endereco WHERE id_usuario = :id_usuario ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_usuario' => $usuario_id]);
    $endereco = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($endereco) {
        echo "<p class='success'>✓ Endereço encontrado no banco:</p>";
        echo "<pre>" . print_r($endereco, true) . "</pre>";
    } else {
        echo "<p class='error'>✗ Nenhum endereço cadastrado</p>";
    }
    
    if (isset($_SESSION['endereco_entrega'])) {
        echo "<p class='success'>✓ Endereço na sessão:</p>";
        echo "<pre>" . print_r($_SESSION['endereco_entrega'], true) . "</pre>";
    } else {
        echo "<p class='info'>ℹ Endereço não está na sessão (pode ser normal)</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Erro ao buscar endereço: " . $e->getMessage() . "</p>";
}

// 3. Verifica carrinho
echo "<h2>3. Verificando Carrinho</h2>";
try {
    $sql = "SELECT * FROM carrinho WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_usuario' => $usuario_id]);
    $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($carrinho) {
        echo "<p class='success'>✓ Carrinho encontrado: ID = " . $carrinho['id'] . "</p>";
        
        // Busca itens
        $sqlItens = "SELECT ci.*, p.nome, p.preco, p.imagem 
                     FROM carrinho_itens ci 
                     JOIN produtos p ON ci.id_produto = p.id 
                     WHERE ci.id_carrinho = :id_carrinho";
        $stmt = $pdo->prepare($sqlItens);
        $stmt->execute([':id_carrinho' => $carrinho['id']]);
        $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($itens)) {
            echo "<p class='success'>✓ Total de itens: " . count($itens) . "</p>";
            echo "<table border='1' cellpadding='10'>";
            echo "<tr><th>Produto</th><th>Imagem</th><th>Quantidade</th><th>Preço Unit.</th><th>Subtotal</th></tr>";
            
            $total = 0;
            foreach ($itens as $item) {
                $subtotal = $item['preco'] * $item['quantidade'];
                $total += $subtotal;
                
                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['nome']) . "</td>";
                echo "<td>" . htmlspecialchars($item['imagem'] ?? 'SEM IMAGEM') . "</td>";
                echo "<td>" . $item['quantidade'] . "</td>";
                echo "<td>R$ " . number_format($item['preco'], 2, ',', '.') . "</td>";
                echo "<td>R$ " . number_format($subtotal, 2, ',', '.') . "</td>";
                echo "</tr>";
            }
            
            echo "<tr><td colspan='4' align='right'><strong>TOTAL:</strong></td>";
            echo "<td><strong>R$ " . number_format($total, 2, ',', '.') . "</strong></td></tr>";
            echo "</table>";
        } else {
            echo "<p class='error'>✗ Carrinho vazio</p>";
        }
    } else {
        echo "<p class='error'>✗ Carrinho não encontrado</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Erro ao buscar carrinho: " . $e->getMessage() . "</p>";
}

// 4. Verifica estrutura das tabelas
echo "<h2>4. Verificando Estrutura das Tabelas</h2>";
$tabelas = ['endereco', 'carrinho', 'carrinho_itens', 'pedido', 'pedido_produto', 'produtos'];

foreach ($tabelas as $tabela) {
    try {
        $stmt = $pdo->query("DESCRIBE $tabela");
        $colunas = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p class='success'>✓ Tabela '$tabela': " . implode(', ', $colunas) . "</p>";
    } catch (Exception $e) {
        echo "<p class='error'>✗ Erro na tabela '$tabela': " . $e->getMessage() . "</p>";
    }
}

// 5. Testa conexão com database.php
echo "<h2>5. Testando Database</h2>";
try {
    $testDb = new Database();
    $testPdo = $testDb->getConnection();
    echo "<p class='success'>✓ Conexão com banco OK</p>";
    echo "<p class='info'>Driver: " . $testPdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "</p>";
} catch (Exception $e) {
    echo "<p class='error'>✗ Erro de conexão: " . $e->getMessage() . "</p>";
}

// 6. Informações do PHP
echo "<h2>6. Configurações PHP</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>display_errors: " . ini_get('display_errors') . "</p>";
echo "<p>error_reporting: " . error_reporting() . "</p>";
echo "<p>Session ID: " . session_id() . "</p>";

echo "<hr><h3>Próximos passos:</h3>";
echo "<ul>";
echo "<li><a href='/zypher/views/Pagamento.php'>Ir para página de Pagamento</a></li>";
echo "<li><a href='/zypher/views/CarrinhoCliente.php'>Ver Carrinho</a></li>";
echo "<li><a href='/zypher/views/EnderecoCliente.php'>Cadastrar Endereço</a></li>";
echo "</ul>";
?>