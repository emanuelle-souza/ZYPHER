<?php
session_start();
require_once '../controllers/ProdutoController.php';

// Verifica se o usuário está logado
$usuarioLogado = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

// Busca os produtos
$produtos = ProdutoController::listarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Home - Zypher Sneakers</title>
</head>
<link rel="stylesheet" href="../css/HomeCliente.css">
<body>
    <h1>Bem-vindo à Zypher Sneakers</h1>

    <!-- Barra superior -->
    <div>
        <?php if ($usuarioLogado): ?>
            <a href="/views/Perfil.php?id=<?= $usuarioLogado ?>">Perfil</a>
        <?php else: ?>
            <a href="/zypher/views/PerfilUsuario.php">Perfil</a>
        <?php endif; ?>

        <a href="/zypher/views/CarrinhoCliente.php">Carrinho</a>
    </div>

    <h2>Produtos disponíveis</h2>

    <ul>
        <?php foreach ($produtos as $produto): ?>
            <li>
                <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
                Marca: <?= htmlspecialchars($produto['marca']) ?><br>
                Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
