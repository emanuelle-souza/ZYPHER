<?php
session_start();
require_once '../controllers/CarrinhoController.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /zypher/login?msg=precisa-logar");
    exit;
}

$itens = CarrinhoController::listarCarrinho($_SESSION['usuario_id']);
$total = 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/Carrinho.css">
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

    <main>
        <div class="container-carrinho">
            <h2>Seu Carrinho</h2>
            
            <?php if (empty($itens)): ?>
                <p class="carrinho-vazio">Seu carrinho está vazio 🛒</p>
            <?php else: ?>
                <?php foreach ($itens as $item): ?>
                    <?php 
                    $subtotal = $item['preco'] * $item['quantidade']; 
                    $total += $subtotal;
                    ?>
                    <div class="item-carrinho">
                        <div class="item-info">
                            <img src="/zypher/img/<?= htmlspecialchars($item['imagem']) ?>" 
                                 alt="<?= htmlspecialchars($item['nome']) ?>"
                                 onerror="this.src='/zypher/img/placeholder.png'">
                            <div class="item-detalhes">
                                <p class="item-nome"><?= htmlspecialchars($item['nome']) ?></p>
                                <p class="item-tamanho">Tamanho: <?= htmlspecialchars($item['tamanho']) ?></p>
                                <p class="item-quantidade">Quantidade: <?= $item['quantidade'] ?></p>
                                <p class="item-preco">R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>
                                <p class="item-subtotal">Subtotal: R$ <?= number_format($subtotal, 2, ',', '.') ?></p>
                            </div>
                        </div>
                        <form action="../controllers/RemoverItemCarrinho.php" method="POST">
                            <input type="hidden" name="id_produto" value="<?= $item['id_produto'] ?>">
                            <input type="hidden" name="tamanho" value="<?= $item['tamanho'] ?>">
                            <button type="submit" class="item-remover" title="Remover item">✖</button>
                        </form>
                    </div>
                <?php endforeach; ?>

                <div class="carrinho-resumo">
                    <p class="carrinho-total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>
                    <form action="../controllers/FinalizarCompra.php" method="POST">
                        <button type="submit" class="btn-finalizar">Finalizar Compra</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="rodape">
            <div class="text">
                <a href="#">Política de Privacidade</a> | 
                <a href="#">Termos de Uso</a> | 
                <a href="#">Contato</a>
            </div>
            <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>