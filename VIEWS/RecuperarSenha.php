<?php
session_start();
require_once '../config/database.php';

$conn = (new Database())->getConnection();
$mensagem = '';
$codigoGerado = '';
$mostrarVerificacao = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        // 1. Gera e salva o código
        $email = $_POST['email'];
        $_SESSION['email'] = $email;

        $codigo = rand(100000, 999999);
        $expira_em = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $stmt = $conn->prepare("INSERT INTO codigos_recuperacao (email, codigo, expira_em) VALUES (?, ?, ?)");
        $stmt->execute([$email, $codigo, $expira_em]);

        $codigoGerado = $codigo;
        $mostrarVerificacao = true;

    } elseif (isset($_POST['codigo_verificacao'])) {
        // 2. Verifica o código
        $email = $_SESSION['email'] ?? '';
        $codigoDigitado = $_POST['codigo_verificacao'];

        if (!$email) {
            $mensagem = "Email não informado.";
        } else {
            $stmt = $conn->prepare("SELECT * FROM codigos_recuperacao WHERE email = ? AND codigo = ? AND expira_em > NOW()");
            $stmt->execute([$email, $codigoDigitado]);
            $valido = $stmt->fetch();

            if ($valido) {
                header("Location: RedefinirSenha.php");
                exit;
            } else {
                $mensagem = "Código inválido ou expirado.";
                $mostrarVerificacao = true;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Senha</title>
</head>
<body>
    <h2>Recuperar Senha</h2>

    <?php if (!isset($_POST['email']) && !isset($_POST['codigo_verificacao'])): ?>
        <!-- Formulário para solicitar código -->
        <form method="POST">
            <label for="email">Digite seu e-mail:</label>
            <input type="email" name="email" required>
            <button type="submit">Enviar código</button>
        </form>

    <?php endif; ?>

    <?php if ($codigoGerado): ?>
        <p><strong>Seu código é:</strong> <?= htmlspecialchars($codigoGerado) ?></p>
    <?php endif; ?>

    <?php if ($mostrarVerificacao): ?>
        <!-- Formulário para digitar o código -->
        <form method="POST">
            <label for="codigo_verificacao">Digite o código recebido:</label>
            <input type="text" name="codigo_verificacao" required>
            <button type="submit">Verificar código</button>
        </form>
    <?php endif; ?>

    <?php if ($mensagem): ?>
        <p style="color: red;"><?= $mensagem ?></p>
    <?php endif; ?>
</body>
</html>
