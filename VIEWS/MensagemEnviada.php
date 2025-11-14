<?php
session_start();
$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';

if ($status === 'sucesso') {
    $titulo = "Mensagem Enviada!";
    $mensagem = "Recebemos sua mensagem e entraremos em contato em breve.";
    $cor = "#10B981";
} else {
    $titulo = "Erro ao Enviar";
    if ($msg === 'campos') $mensagem = "Preencha todos os campos.";
    elseif ($msg === 'email') $mensagem = "Email inválido.";
    elseif ($msg === 'banco') $mensagem = "Erro no servidor. Tente novamente.";
    else $mensagem = "Ocorreu um erro ao enviar a mensagem.";
    $cor = "#EF4444";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?> - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/MensagemEnviada.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <div class="topo">
            <div class="logo">
                <a href="<?= (isset($_SESSION['membro']) && $_SESSION['membro']) ? '/zypher/VIEWS/HomeMembro.php' : '/zypher/VIEWS/HomeCliente.php' ?>">
                    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
                </a>
            </div>
            <div class="busca">
                <button type="button"><img src="/zypher/MIDIA/Lupa.png" alt="Buscar"></button>
                <input type="text" placeholder="Buscar tênis...">
            </div>
            <div class="icones">
                <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
                <a href="/zypher/views/CarrinhoCliente.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil"><img src="/zypher/MIDIA/perfil.png" alt="perfil"></a>
                <?php else: ?>
                    <a href="/zypher/views/login.php" title="Entrar"><img src="/zypher/MIDIA/perfil.png" alt="Entrar"></a>
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

    <!-- Confirmação -->
    <section class="confirmacao-section">
        <div class="confirmacao-container">
            <div class="success-icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                    <circle cx="40" cy="40" r="40" fill="<?= $status === 'sucesso' ? '#C8F5D8' : '#FECACA' ?>"/>
                    <?php if ($status === 'sucesso'): ?>
                        <path d="M25 40L35 50L55 30" stroke="<?= $cor ?>" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <?php else: ?>
                        <path d="M25 25L55 55M55 25L25 55" stroke="<?= $cor ?>" stroke-width="4" stroke-linecap="round"/>
                    <?php endif; ?>
                </svg>
            </div>
            <h1><?= htmlspecialchars($titulo) ?></h1>
            <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
            <a href="/zypher/VIEWS/FaleConosco.php" class="btn-enviar-outra">
                <?= $status === 'sucesso' ? 'Enviar Outra Mensagem' : 'Tentar Novamente' ?>
            </a>
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