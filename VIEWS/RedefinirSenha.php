<?php
session_start();
$email = $_SESSION['email'] ?? '';
if (!$email) die("Acesso não autorizado.");
?>

<!DOCTYPE html>
<html>
<head><title>Redefinir Senha</title></head>
<link rel="stylesheet" href="/zypher/CSS/RedefinirSenha.css">

<body>
      <div class="container">
    <h2>Digite sua nova senha</h2>
    <form method="POST" action="SalvarNovaSenha.php">
        <label for="nova_senha">Nova senha:</label>
        <input type="password" name="nova_senha" required><br><br>
        <button type="submit">Salvar nova senha</button>
    </form>
    </div>
</body>
</html>
