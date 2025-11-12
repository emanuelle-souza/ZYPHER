<?php
session_start();

if (!isset($_SESSION['id_adm'])) {
    header('Location: /zypher/views/LoginAdmnistrador.php');
    exit();
}

// Caminho da foto do admin (padrão)
$fotoPath = isset($_SESSION['foto_adm']) && file_exists($_SESSION['foto_adm'])
    ? $_SESSION['foto_adm']
    : '/zypher/MIDIA/perfil.png';

// Upload de foto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_perfil'])) {
    $uploadDir = __DIR__ . '/../uploads/admin/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileTmp = $_FILES['foto_perfil']['tmp_name'];
    $fileName = 'admin_' . $_SESSION['id_adm'] . '.jpg';
    $destino = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmp, $destino)) {
        $_SESSION['foto_adm'] = '/zypher/uploads/admin/' . $fileName;
        $fotoPath = $_SESSION['foto_adm'];
        $mensagem = "Foto atualizada com sucesso!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Administrador</title>
    <link rel="stylesheet" href="/zypher/CSS/PerfilAdm.css">
</head>
<body>

    <!-- Cabeçalho -->
    <header class="topo">
        <div class="logo">
            <a href="/zypher/views/HomeAdm.php">
                <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers">
            </a>
        </div>
    </header>

    <!-- Conteúdo -->
    <main class="perfil-container">
        <h1>PERFIL DO ADMINISTRADOR</h1>

        <section class="perfil-card">
            <form action="" method="POST" enctype="multipart/form-data" class="foto-form">
                <label for="foto_perfil" class="foto-label">
                    <img src="<?= htmlspecialchars($fotoPath) ?>" alt="Foto do Admin" class="foto-perfil" id="preview-foto">
                </label>
                <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" onchange="previewImagem(event)">
                <button type="submit" class="btn-upload">Salvar Foto</button>
                <?php if (!empty($mensagem)): ?>
                    <p class="msg-sucesso"><?= $mensagem ?></p>
                <?php endif; ?>
            </form>

            <div class="info">
                <h2><?= htmlspecialchars($_SESSION['nome']) ?></h2>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>

                <div class="botoes">
                    <button onclick="window.location.href='/zypher/views/Controleuser.php'">VOLTAR À HOME</button>
                    <button onclick="window.location.href='/zypher/views/logout-adm.php'">SAIR</button>
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
