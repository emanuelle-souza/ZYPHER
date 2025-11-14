<?php
require_once '../controllers/ProdutoController.php';
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['membro']) || !$_SESSION['membro']) {
    header("Location: /zypher/VIEWS/HomeCliente.php");
    exit;
}

$produtos = ProdutoController::listarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/HomeMembro.css?v=<?= time() ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- HEADER -->
   <header>
        <div class="topo">
            <div class="logo">
                <a href="/zypher/VIEWS/HomeMembro.php">
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

     <!-- BANNER (vídeo principal) -->
    <section class="banner-principal">
        <video autoplay muted loop playsinline>
            <source src="/zypher/MIDIA/home.mp4" type="video/mp4">
        </video>
        <div class="texto-banner">
            <h2>NOVIDADES</h2>
            <p>Descontos imperdíveis</p>
        </div>
    </section>

    <br><br>

    <!-- PRODUTOS -->
    <section class="products-section">
        <h2>MAIS VENDIDOS</h2>
        <div class="grid-produtos">
            <?php foreach ($produtos as $p): 
                $preco = $p['preco'];
                $desconto = $p['desconto'] ?? 0;
                $preco_final = $preco * (1 - $desconto / 100);
                $tem_desconto = $desconto > 0;
            ?>
                <a href="/zypher/VIEWS/Produto.php?id=<?= $p['id'] ?>" class="card">
                    <?php if ($tem_desconto): ?>
                        <div class="badge">-<?= (int)$desconto ?>%</div>
                    <?php endif; ?>

                    <img src="<?= htmlspecialchars($p['imagem']) ?>" alt="<?= htmlspecialchars($p['nome']) ?>">

                    <h3><?= htmlspecialchars($p['nome']) ?></h3>
                    <p><?= htmlspecialchars($p['descricao']) ?></p>

                    <div class="price">
                        <?php if ($tem_desconto): ?>
                            <span class="old">R$ <?= number_format($preco, 2, ',', '.') ?></span>
                            <span class="new">R$ <?= number_format($preco_final, 2, ',', '.') ?></span>
                        <?php else: ?>
                            <span class="new">R$ <?= number_format($preco, 2, ',', '.') ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    
 <footer>
    <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
       <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> |  
    <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
    <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
</footer>
</body>
</html>