<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: LoginFuncionario.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte - Zypher Sneakers</title>
    <link rel="stylesheet" href="/zypher/CSS/Suporte.css">
</head>
<body>

<!-- SEU HEADER EXATAMENTE COMO VOCÊ QUER -->
<header>
    <div class="topo">
        <div class="logo">
            <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
        </div>
        <div class="icones">
            <a href="/zypher/views/PerfilFuncionario.php" title="Perfil">
                <img src="/zypher/MIDIA/perfil.png" alt="Perfil">
            </a>
        </div>
    </div>
</header>

<div class="container">
    <h1>Suporte ao Cliente</h1>

    <?php if (empty($mensagens)): ?>
        <div class="ticket" style="text-align:center;padding:60px;color:#777;">
            <h2>Tudo tranquilo por aqui!</h2>
            <p>Nenhuma mensagem pendente no momento.</p>
        </div>
    <?php else: foreach ($mensagens as $m): ?>
        <div class="ticket <?= ($m['status']??'') === 'respondida' ? 'respondida' : '' ?>">
            <div class="ticket-header">
                <div class="info">
                    <h3>#<?= $m['id_fale_conosco'] ?> - <?= htmlspecialchars($m['nome']) ?></h3>
                    <p><?= htmlspecialchars($m['email']) ?> • <?= date('d/m/Y H:i', strtotime($m['data_envio']??$m['data_resposta'])) ?></p>
                </div>
                <div class="status <?= ($m['status']??'') === 'respondida' ? 'respondida' : 'pendente' ?>">
                    <?= ($m['status']??'') === 'respondida' ? 'Respondida' : 'Pendente' ?>
                </div>
            </div>

            <div class="ticket-body">
                <strong>Assunto:</strong> <?= htmlspecialchars($m['assunto']) ?><br><br>
                <?= nl2br(htmlspecialchars($m['mensagem'])) ?>

                <?php if (($m['status']??'') === 'respondida'): ?>
                    <div class="resposta">
                        <strong>Resposta enviada em <?= date('d/m/Y H:i', strtotime($m['data_resposta'])) ?>:</strong><br><br>
                        <?= nl2br(htmlspecialchars($m['resposta'])) ?>
                    </div>
                <?php else: ?>
                    <form method="POST" class="form-resposta">
                        <input type="hidden" name="id_fale_conosco" value="<?= $m['id_fale_conosco'] ?>">
                        <textarea name="resposta" placeholder="Digite sua resposta..." required></textarea>
                        <button type="submit">Enviar Resposta</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; endif; ?>
</div>

</body>
</html>