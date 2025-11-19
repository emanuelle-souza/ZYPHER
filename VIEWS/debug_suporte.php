<?php
session_start();

echo "<h1>DEBUG - Sistema de Suporte</h1>";
echo "<hr>";

// 1. TESTA CONEXÃO
echo "<h2>1. Testando Conexão com Banco</h2>";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexão OK!<br>";
} catch (PDOException $e) {
    die("❌ Erro de conexão: " . $e->getMessage());
}

// 2. VERIFICA SESSÃO
echo "<hr><h2>2. Verificando Sessão do Funcionário</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

if (!isset($_SESSION['funcionario_id'])) {
    echo "❌ FUNCIONÁRIO NÃO ESTÁ LOGADO!<br>";
    echo "Por favor, faça login em: <a href='/zypher/views/LoginFuncionario.php'>LoginFuncionario.php</a>";
} else {
    echo "✅ Funcionário logado: ID = " . $_SESSION['funcionario_id'] . "<br>";
    echo "✅ Nome: " . ($_SESSION['funcionario_nome'] ?? 'Não definido') . "<br>";
}

// 3. VERIFICA ESTRUTURA DA TABELA
echo "<hr><h2>3. Estrutura da Tabela fale_conosco</h2>";
try {
    $stmt = $pdo->query("DESCRIBE fale_conosco");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage();
}

// 4. CONTA MENSAGENS
echo "<hr><h2>4. Total de Mensagens no Banco</h2>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM fale_conosco");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "📊 Total de mensagens: <strong>" . $result['total'] . "</strong><br>";
    
    if ($result['total'] == 0) {
        echo "<br>⚠️ NENHUMA MENSAGEM ENCONTRADA NO BANCO!<br>";
        echo "Vou inserir uma mensagem de teste...<br>";
        
        $pdo->exec("INSERT INTO fale_conosco (nome, email, assunto, mensagem, status) 
                    VALUES ('Cliente Teste', 'teste@email.com', 'Teste Sistema', 'Esta é uma mensagem de teste automática.', 'pendente')");
        
        echo "✅ Mensagem de teste inserida!<br>";
    }
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage();
}

// 5. MENSAGENS POR STATUS
echo "<hr><h2>5. Mensagens por Status</h2>";
try {
    $stmt = $pdo->query("SELECT status, COUNT(*) as total FROM fale_conosco GROUP BY status");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Status</th><th>Quantidade</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>" . ($row['status'] ?? 'NULL') . "</td><td>" . $row['total'] . "</td></tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage();
}

// 6. LISTA TODAS AS MENSAGENS
echo "<hr><h2>6. Listando TODAS as Mensagens</h2>";
try {
    $sql = "SELECT 
                fc.id_fale_conosco,
                fc.nome,
                fc.email,
                fc.assunto,
                fc.mensagem,
                fc.status,
                fc.resposta,
                fc.data_resposta,
                fc.id_usuario,
                fc.id_funcionario,
                u.nome AS nome_usuario,
                f.nome AS nome_funcionario
            FROM fale_conosco fc
            LEFT JOIN usuario u ON fc.id_usuario = u.id_usuario
            LEFT JOIN funcionario f ON fc.id_funcionario = f.id_funcionario
            ORDER BY fc.id_fale_conosco DESC";
    
    $stmt = $pdo->query($sql);
    $mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📧 Total encontrado: <strong>" . count($mensagens) . "</strong><br><br>";
    
    if (empty($mensagens)) {
        echo "⚠️ Array de mensagens está VAZIO!<br>";
    } else {
        echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #333; color: white;'>";
        echo "<th>ID</th><th>Nome</th><th>Email</th><th>Assunto</th><th>Mensagem</th><th>Status</th></tr>";
        
        foreach ($mensagens as $m) {
            $statusColor = ($m['status'] === 'respondida') ? '#d4edda' : '#fff3cd';
            echo "<tr style='background: {$statusColor}'>";
            echo "<td>" . $m['id_fale_conosco'] . "</td>";
            echo "<td>" . htmlspecialchars($m['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($m['email']) . "</td>";
            echo "<td>" . htmlspecialchars($m['assunto']) . "</td>";
            echo "<td>" . htmlspecialchars(substr($m['mensagem'], 0, 50)) . "...</td>";
            echo "<td><strong>" . ($m['status'] ?? 'NULL') . "</strong></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<br><h3>Dados RAW (JSON):</h3>";
    echo "<pre style='background: #f4f4f4; padding: 15px; overflow-x: auto;'>";
    echo json_encode($mensagens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "</pre>";
    
} catch (PDOException $e) {
    echo "❌ Erro SQL: " . $e->getMessage();
}

// 7. TESTA A QUERY DO CONTROLLER
echo "<hr><h2>7. Testando Query Exata do Controller</h2>";
try {
    $sql = "
        SELECT 
            fc.id_fale_conosco,
            fc.nome,
            fc.email,
            fc.assunto,
            fc.mensagem,
            COALESCE(fc.status, 'pendente') as status,
            fc.resposta,
            fc.data_resposta,
            u.nome AS nome_usuario,
            f.nome AS nome_funcionario
        FROM fale_conosco fc
        LEFT JOIN usuario u ON fc.id_usuario = u.id_usuario
        LEFT JOIN funcionario f ON fc.id_funcionario = f.id_funcionario
        ORDER BY 
            CASE WHEN fc.status = 'pendente' THEN 0 ELSE 1 END,
            fc.id_fale_conosco DESC
    ";
    
    $stmt = $pdo->query($sql);
    $mensagensController = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "✅ Query executada com sucesso!<br>";
    echo "📊 Total retornado: <strong>" . count($mensagensController) . "</strong><br>";
    
} catch (PDOException $e) {
    echo "❌ Erro na query: " . $e->getMessage();
}

// 8. VERIFICA PERMISSÕES DE ARQUIVO
echo "<hr><h2>8. Verificando Caminhos dos Arquivos</h2>";
$controller_path = __DIR__ . '/../controllers/SuporteController.php';
$view_path = __DIR__ . '/../views/SuporteUsuario.php';

echo "Controller: " . $controller_path . " - ";
echo file_exists($controller_path) ? "✅ Existe" : "❌ NÃO EXISTE";
echo "<br>";

echo "View: " . $view_path . " - ";
echo file_exists($view_path) ? "✅ Existe" : "❌ NÃO EXISTE";
echo "<br>";

echo "<hr>";
echo "<h2>✅ DEBUG COMPLETO!</h2>";
echo "<p>Coloque este arquivo na pasta <strong>/zypher/</strong> e acesse via navegador.</p>";
echo "<p>Se houver mensagens no banco mas não aparecerem no painel, o problema está no caminho dos arquivos ou na sessão.</p>";
?>

<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    h1 { color: #1E3A5F; }
    h2 { color: #444; margin-top: 20px; }
    hr { margin: 20px 0; border: 1px solid #ddd; }
    table { background: white; margin: 10px 0; }
    pre { background: #f4f4f4; padding: 10px; border-radius: 5px; }
</style>