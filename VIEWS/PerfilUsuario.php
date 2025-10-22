<?php
session_start();
require_once '../models/Usuario.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /zypher/views/login.php');
    exit();
}

// Busca os dados do usuário logado
$usuarioModel = new Usuario();
$usuario = $usuarioModel->getById($_SESSION['usuario_id']);

if (!$usuario) {
    echo "<script>alert('Usuário não encontrado!'); window.location.href='/zypher/views/login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="/zypher/CSS/Perfil.css">
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
                <input type="text" placeholder="Buscar...">
                <button>🔍</button>
            </div>
            <div class="icones">
                <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
                <a href="/zypher/views/CarrinhoCliente.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>
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
            <a href="#">Feminino</a>
            <a href="#">Masculino</a>
        </nav>
    </header>

    <!-- Conteúdo principal -->
    <main class="perfil-container">
        <h1>PERFIL DO USUÁRIO</h1>

        <section class="perfil-card">
            <img src="/zypher/MIDIA/perfil.png" alt="Foto de Perfil" class="foto-perfil">

            <div class="info">
                <h2><?= htmlspecialchars($usuario['nome']) ?></h2>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
                <p><strong>Telefone:</strong> <?= htmlspecialchars($usuario['telefone']) ?></p>
                <p><strong>CPF:</strong> <?= htmlspecialchars($usuario['cpf']) ?></p>

                <div class="botoes">
                    <button onclick="window.location.href='usuarioform.php'">CADASTRO</button>
                    <button onclick="window.location.href='UpdateUsuario.php'">ATUALIZAR PERFIL</button>
                    <button onclick="window.location.href='/zypher/views/logout.php'">SAIR</button>
                </div>
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <footer class="rodape">
        <p>© 2025 Zypher Sneakers | Todos os direitos reservados.</p>
    </footer>

</body>
</html>
