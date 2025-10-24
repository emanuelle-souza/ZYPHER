<?php
require_once '../controllers/ProdutoController.php';

if (!isset($_SESSION)) {
    session_start();
}

$usuarioLogado = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;
$produtos = ProdutoController::listarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/HomeCliente.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="topo">
            <div class="logo">
                <a href="/zypher/VIEWS/HomeCliente.php">
                    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
                </a>
            </div>
            <div class="busca">
                <input type="text" placeholder="Buscar...">
                <button>🔍</button>
            </div>
            <div class="icones">
                <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
                <a href="/zypher/views/CarrinhoCliente.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>

                <?php if ($usuarioLogado): ?>
                    <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
                        <img src="/zypher/MIDIA/perfil.png" alt="perfil">
                    </a>
                <?php else: ?>
                    <a href="/zypher/views/login.php" title="Entrar">
                        <img src="/zypher/MIDIA/perfil.png" alt="Entrar">
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- MENU -->
        <nav>
            <a href="#">Masculino</a>
            <a href="#">Feminino</a>
        </nav>
    </header>

    <!-- BANNER PRINCIPAL -->
    <section class="banner-principal">
        <img src="/zypher/MIDIA/Home.png" alt="Banner Zypher Sneakers">
        <div class="texto-banner">
            <h2>NOVIDADES</h2>
            <p>"Conforto que te leva além."</p>
        </div>
    </section>

    <!-- MAIS VENDIDOS -->
    <section class="mais-vendidos">
        <h2>MAIS VENDIDOS</h2>
        <div class="grid-produtos">
            <?php foreach ($produtos as $produto): ?>
                <a href="/zypher/VIEWS/Produto.php?id=<?= urlencode($produto['id']) ?>" class="card-link">
                    <div class="card">
                        <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                        <h3><?= htmlspecialchars($produto['nome'] ?? 'Produto sem nome') ?></h3>
                        <p><?= htmlspecialchars($produto['descricao'] ?? 'Descrição não disponível') ?></p>
                        <span class="preco">R$ <?= number_format($produto['preco'] ?? 0, 2, ',', '.') ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>
