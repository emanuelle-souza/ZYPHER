<?php
require_once '../controllers/ProdutoController.php';

if (!isset($_SESSION)) {
    session_start();
}

$usuarioLogado = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

// Busca apenas produtos da categoria "Feminino" (id_categoria = 2)
$produtosMasculinos = ProdutoController::listarPorCategoria(2);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masculino | Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/HomeCliente.css">
    <link rel="stylesheet" href="/zypher/CSS/Masculino.css"> <!-- Opcional: estilos específicos -->
</head>
<body>

    <!-- Cabeçalho / Menu -->
    <header>
        <div class="topo">
            <div class="logo">
                <a href="/zypher/VIEWS/HomeCliente.php">
                    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
                </a>
            </div>
<div class="busca">
                <button type="button">
                    <img src="/zypher/MIDIA/Lupa.png" alt="Buscar">
                </button>
                <input type="text" placeholder="Buscar tênis...">
            </div>
            <div class="icones">
                <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
                <a href="/zypher/views/Carrinho.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
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

       <nav class="menu">
            <a href="/zypher/views/Feminino.php">Feminino</a>
            <a href="/zypher/views/Masculino.php">Masculino</a>
            <a href="/zypher/views/Explorar.php">Explorar</a>
            <a href="/zypher/views/QuemSomos.php">Sobre nós</a>
        </nav>
    </header>

    <!-- BANNER FEMININO -->
<section class="banner-feminino">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h2>COLEÇÃO MASCULINO</h2>
        <p>Estilo, conforto e elegância</p>
    </div>
</section>

    <!-- PRODUTOS FEMININOS -->
    <section class="mais-vendidos">
        <h2>EXPLORAR MASCULINO</h2>
        <?php if (empty($produtosMasculinos)): ?>
            <p style="text-align: center; color: #666; font-size: 1.1rem; margin-top: 20px;">
                Nenhum produto masculino disponível no momento.
            </p>
        <?php else: ?>
            <div class="grid-produtos">
                <?php foreach ($produtosMasculinos as $produto): ?>
                    <a href="/zypher/VIEWS/Produto.php?id=<?= urlencode($produto['id']) ?>" class="card-link">
                        <div class="card">
                            <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                            <p><?= htmlspecialchars($produto['descricao']) ?></p>
                            <span class="preco">
                                R$ <?= number_format($produto['preco'] * (1 - $produto['desconto']/100), 2, ',', '.') ?>
                                <?php if ($produto['desconto'] > 0): ?>
                                    <del style="color: #999; font-size: 0.8rem;">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></del>
                                <?php endif; ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <footer>
        <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
        <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> |  
        <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
        <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
    </footer>

</body>
</html>