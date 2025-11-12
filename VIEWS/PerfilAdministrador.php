<?php
session_start();
if (!isset($_SESSION['id_adm'])) {
    header('Location: /zypher/views/LoginAdmnistrador.php');
    exit();
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

    <div class="perfil-container">
        <div class="perfil-card">
            <div class="card-header">
                <h1>PERFIL DO ADMINISTRADOR</h1>
                <div class="admin-badge">Admin</div>
            </div>

            <div class="card-body">
                <img src="/zypher/MIDIA/admin_william.jpg" alt="Foto do Admin" class="foto-perfil">

                <div class="info">
                    <h2><?= htmlspecialchars($_SESSION['nome']) ?></h2>
                    <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                </div>

                <div class="botoes">
                    <a href="/zypher/views/Controleuser.php" class="btn-custom btn-dashboard">
                        Voltar ao Dashboard
                    </a>
                    <a href="/zypher/views/logout-adm.php" class="btn-custom btn-sair">
                        Sair
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>