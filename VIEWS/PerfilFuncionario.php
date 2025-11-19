<?php
session_start();
require_once '../models/Funcionario.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: /zypher/views/login.php');
    exit();
}

require_once __DIR__ . '/../controllers/FuncionarioController.php';

// Busca dados do funcionário via model (inclui possíveis colunas de foto)
$funcModel = new Funcionario();
$funcionario = $funcModel->getById($_SESSION['funcionario_id']);

// Determina caminho da foto: prioriza session, depois colunas possíveis do DB, senão imagem padrão
$fotoPath = '/zypher/MIDIA/perfil.png';
if (!empty($_SESSION['foto_funcionario'])) {
    $fotoPath = $_SESSION['foto_funcionario'];
} elseif (!empty($funcionario)) {
    // possíveis nomes de coluna onde o caminho pode estar
    foreach (['foto_perfil','foto','foto_funcionario','imagem','caminho_foto'] as $col) {
        if (!empty($funcionario[$col])) {
            $fotoPath = $funcionario[$col];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do funcionario</title>
    <link rel="stylesheet" href="/zypher/CSS/PerfilFun.css">
</head>
<body>

    <!-- Cabeçalho -->
    <header class="topo">
        <div class="logo">
            <a href="/zypher/views/SuporteUsuario.php">
                <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers">
            </a>
        </div>
    </header>

    <!-- Conteúdo -->
    <main class="perfil-container">
        <h1>PERFIL DO FUNCIONARIO</h1>

        <section class="perfil-card">
            <form action="/zypher/views/uploadFotoFun.php" method="POST" enctype="multipart/form-data" class="form-foto">
            <input type="hidden" name="id_funcionario" value="<?= $_SESSION['funcionario_id'] ?>">
            <label for="foto-upload">
        <img src="<?= htmlspecialchars($fotoPath) ?>" 
             alt="Foto de Perfil" class="foto-perfil" id="foto-preview">
    </label>
            <input type="file" name="foto" id="foto-upload" accept="image/*" style="display: none;" onchange="this.form.submit()">
</form>
<?php if (!empty($_SESSION['msg_foto'])): ?>
    <p class="msg-foto"><?= htmlspecialchars($_SESSION['msg_foto']) ?></p>
    <?php unset($_SESSION['msg_foto']); ?>
<?php endif; ?>

            <div class="info">
                <h2><?= htmlspecialchars($_SESSION['funcionario_nome'] ?? 'Nome não informado') ?></h2>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($_SESSION['funcionario_email'] ?? 'Não informado') ?></p>

                <div class="botoes">
                    <button onclick="window.location.href='/zypher/views/SuporteUsuario.php'">VOLTAR À HOMEPAGE</button>
                    <button onclick="window.location.href='/zypher/views/logout-fun.php'">SAIR</button>
                </div>
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <footer>
        <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
        <a href="/zypher/VIEWS/Termos.php">Termos de Uso</a> | 
        <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
        <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
    </footer>

    <script>
        function previewImagem(event) {
            const preview = document.getElementById('preview-foto');
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        }
    </script>
</body>
</html>
