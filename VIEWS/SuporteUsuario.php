<?php
session_start();
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
    <title>Painel de Suporte</title>
    <link rel="stylesheet" href="/zypher/CSS/Suporte.css">
    <style>
        body { font-family: Arial; margin: 0; background: #f4f4f4; }
        .container { max-width: 1000px; margin: 20px auto; padding: 20px; }
        .card { background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .respondida { background: #e8f5e8; border-left: 5px solid #4caf50; }
        .pendente { border-left: 5px solid #ff9800; }
        textarea { width: 100%; height: 100px; margin: 10px 0; padding: 10px; }
        .btn { background: #1E3A5F; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        .btn:hover { background: #162e4b; }
        .status { font-weight: bold; }
        .sucesso { color: green; }
        .erro { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Painel de Suporte</h1>
        <p>Bem-vindo, <strong><?= $_SESSION['funcionario_nome'] ?? 'Funcionário' ?></strong> | <a href="logout_funcionario.php">Sair</a></p>

        <?php if (isset($_GET['status'])): ?>
            <p class="<?= $_GET['status'] === 'sucesso' ? 'sucesso' : 'erro' ?>">
                <?= $_GET['status'] === 'sucesso' ? 'Resposta enviada com sucesso!' : 'Erro ao enviar resposta.' ?>
            </p>
        <?php endif; ?>

        <h2>Mensagens Recebidas</h2>

        <?php if (empty($mensagens)): ?>
            <div class="card" style="text-align:center; color:#666; padding:40px;">
                <h3>Nenhuma mensagem no momento</h3>
                <p>Tudo tranquilo por aqui!</p>
            </div>
        <?php else: ?>
            <?php foreach ($mensagens as $m): ?>
                <div class="card <?= ($m['status'] ?? 'pendente') === 'respondida' ? 'respondida' : 'pendente' ?>">
                    <p><strong>ID:</strong> #<?= $m['id_fale_conosco'] ?></p>
                    <p><strong>Cliente:</strong> <?= htmlspecialchars($m['nome']) ?>
                        <?= !empty($m['nome_usuario']) ? ' (' . htmlspecialchars($m['nome_usuario']) . ')' : '' ?>
                    </p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($m['email']) ?></p>
                    <p><strong>Assunto:</strong> <?= htmlspecialchars($m['assunto']) ?></p>
                    <p><strong>Mensagem:</strong><br><?= nl2br(htmlspecialchars($m['mensagem'])) ?></p>

                    <p class="status">
                        Status: <strong><?= ($m['status'] ?? 'pendente') === 'respondida' ? 'Respondida' : 'Pendente' ?></strong>
                        <?php if (!empty($m['data_resposta'])): ?>
                            em <?= date('d/m/Y H:i', strtotime($m['data_resposta'])) ?>
                            por <?= htmlspecialchars($m['nome_funcionario'] ?? 'Suporte') ?>
                        <?php endif; ?>
                    </p>

                    <?php if (($m['status'] ?? 'pendente') === 'respondida'): ?>
                        <p><strong>Sua resposta:</strong><br><?= nl2br(htmlspecialchars($m['resposta'])) ?></p>
                    <?php else: ?>
                        <form action="/zypher/controllers/SuporteController.php" method="POST">
                            <input type="hidden" name="id_fale_conosco" value="<?= $m['id_fale_conosco'] ?>">
                            <textarea name="resposta" placeholder="Escreva sua resposta aqui..." required></textarea>
                            <button type="submit" class="btn">Enviar Resposta</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>