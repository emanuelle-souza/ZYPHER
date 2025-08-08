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
if ($stmt->execute([$senhaHash, $email])) {
    echo "Senha atualizada com sucesso!";
    echo '<a href="login.php"><button>Voltar para o Login</button></a>';
    session_destroy(); // Limpa sessão por segurança
} else {
    echo "Erro ao atualizar a senha.";
}
?>
