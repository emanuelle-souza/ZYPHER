<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Redefinir Senha</title>
  <link rel="stylesheet" href="/zypher/views/css/*.css">
</head>
<body>

<h2>Redefinir Senha</h2>

<form action="../controllers/redefinir_senha.php" method="post">
  <input type="email" name="email" placeholder="Seu e-mail" required><br>
  <input type="text" name="codigo" placeholder="Código recebido" required><br>
  <input type="password" name="nova_senha" placeholder="Nova senha" required><br>
  <button type="submit">Redefinir senha</button>
</form>

</body>
</html>
