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
                <a href="<?php 
    echo (isset($_SESSION['membro']) && $_SESSION['membro']) 
        ? '/zypher/VIEWS/HomeMembro.php' 
        : '/zypher/VIEWS/HomeCliente.php'; 
?>">
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

    <!-- Conteúdo principal -->
    <main class="perfil-container">
        <h1>PERFIL DO USUÁRIO</h1>

        <section class="perfil-card">
            <form action="/zypher/views/uploadFoto.php" method="POST" enctype="multipart/form-data" class="form-foto">
    <input type="hidden" name="id_usuario" value="<?= $_SESSION['usuario_id'] ?>">
    <label for="foto-upload">
        <img src="<?= !empty($usuario['foto_perfil']) ? htmlspecialchars($usuario['foto_perfil']) : '/zypher/MIDIA/perfil.png' ?>" 
             alt="Foto de Perfil" class="foto-perfil" id="foto-preview">
    </label>
    <input type="file" name="foto" id="foto-upload" accept="image/*" style="display: none;" onchange="this.form.submit()">
</form>


            <div class="info">
                <h2><?= htmlspecialchars($usuario['nome']) ?></h2>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
                <p><strong>Telefone:</strong> <?= htmlspecialchars($usuario['telefone']) ?></p>
                <p><strong>CPF:</strong> <?= htmlspecialchars($usuario['cpf']) ?></p>

                <div class="botoes">
                    <button onclick="window.location.href='UpdateUsuario.php'">ATUALIZAR PERFIL</button>
                    <button onclick="window.location.href='/zypher/views/logout.php'">SAIR</button>
                </div>
            </div>
        </section>
    </main>

     <!-- Footer -->
    <footer>
        <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
          <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> | 
        <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
        <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
