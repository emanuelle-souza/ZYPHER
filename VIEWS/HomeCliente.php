<?php
//session_start();
require_once '../controllers/ProdutoController.php';

// Verifica se o usuário está logado
$usuarioLogado = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

// Busca os produtos
$produtos = ProdutoController::listarProdutos();

if (!isset($_SESSION)) {
    session_start();
}

?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/HomeCliente.css">
</head>
<body>
    <!-- Header -->
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
                <?php if (!isset($_SESSION)) session_start(); ?>

<?php if (isset($_SESSION['usuario_id'])): ?>
    <!-- Usuário logado: vai para o perfil -->
    <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
        <img src="/zypher/MIDIA/perfil.png" alt="perfil">
    </a>
<?php else: ?>
    <!-- Usuário não logado: mostra opções de login/cadastro -->
    <a href="/zypher/views/login.php" title="Entrar">
        <img src="/zypher/MIDIA/perfil.png" alt="Entrar">
    </a>
<?php endif; ?>
            </div>
        </div>

        <!-- Menu -->
        <nav>
            <a href="#">Feminino</a>
            <a href="#">Masculino</a>
        </nav>
    </header>

    <!-- Seção Novidades -->
    <section class="novidades">
        <h2>NOVIDADES</h2>
        <p>"Conforto que te leva além."</p>
        <div class="destaque">
            <img src="/zypher/MIDIA/Home.png" alt="Produto destaque">
        </div>
    </section>

    <!-- Mais Vendidos -->
    <section class="mais-vendidos">
        <h2>MAIS VENDIDOS</h2>
        <div class="grid-produtos">
            <?php foreach ($produtos as $produto): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                        <h3><?= htmlspecialchars($produto['nome'] ?? 'Produto sem nome') ?></h3>
                        <p><?= htmlspecialchars($produto['descricao'] ?? 'Descrição não disponível') ?></p>
                        <span class="preco">
                        R$ <?= number_format($produto['preco'] ?? 0, 2, ',', '.') ?>
                        </span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>
