<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giftcard membro</title>
    <link rel="stylesheet" href="/cypher/views/css/*.css">
</head>
<body>
    <h2>Giftcards Disponíveis</h2>

<?php if (empty($giftcards)     ): ?>
    <p>Nenhum giftcard disponível no momento.</p>
<?php else: ?>
    <ul>
        <?php foreach ($giftcards as $gc): ?>
            <li>
                <strong>Código:</strong> <?= htmlspecialchars($gc['codigo']) ?> |
                <strong>Saldo:</strong> R$ <?= number_format($gc['saldo'], 2, ',', '.') ?> |
                <strong>Expira em:</strong> <?= $gc['expiracao'] ?>
                <form method="POST" action="/cypher/resgatar-giftcard" style="display:inline;">
                    <input type="hidden" name="codigo" value="<?= htmlspecialchars($gc['codigo']) ?>">
                    <button type="submit">Resgatar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>

