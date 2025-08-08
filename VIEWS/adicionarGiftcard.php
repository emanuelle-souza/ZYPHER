<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giftcard Funcionario</title>
    <link rel="stylesheet" href="/zypher/views/css/*.css">
</head>
<body>
    <h2>Adicionar Giftcard</h2>
    <form method="POST" action="/zypher/adicionar-giftcard">
    <label>Código:</label><br>
    <input type="text" name="codigo" required><br>

    <label>Saldo (R$):</label><br>
    <input type="number" name="saldo" step="0.01" required><br>

    <label>Data de Expiração:</label><br>
    <input type="date" name="expiracao" required><br><br>

    <button type="submit">Adicionar Giftcard</button>
</form>
</body>
</html>
