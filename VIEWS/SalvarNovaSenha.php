<?php
session_start();
require_once '../config/database.php';

$email = $_SESSION['email'] ?? '';
$novaSenha = $_POST['nova_senha'] ?? '';

if (!$email || !$novaSenha) {
    die("Dados incompletos.");
}

$conn = (new Database())->getConnection();
$senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE usuario SET senha = ? WHERE email = ?");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Redefinição de Senha</title>
  <link rel="stylesheet" href="/zypher/CSS/SalvarSenha.css">
</head>
<body>
  <div class="container">
    <?php
    if ($stmt->execute([$senhaHash, $email])) {
        echo "<h2>Senha atualizada com sucesso!</h2>";
        echo '<a href="login.php"><button>Voltar para o Login</button></a>';
        session_destroy();
    } else {
        echo "<h2>Erro ao atualizar a senha.</h2>";
    }
    ?>
  </div>
</body>
</html>
