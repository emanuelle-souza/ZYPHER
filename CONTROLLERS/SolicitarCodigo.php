<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    $codigo = rand(100000, 999999);
    $expira_em = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    $conn = (new Database())->getConnection();

    $stmt = $conn->prepare("INSERT INTO codigos_recuperacao (email, codigo, expira_em) VALUES (?, ?, ?)");
    $stmt->execute([$email, $codigo, $expira_em]);

    // Enviar o código por e-mail (simulado aqui)
    // mail($email, "Código de recuperação", "Seu código é: $codigo");

    $_SESSION['email'] = $email;
}
?>

<form id="redirecionar" method="POST" action="../views/inserir_codigo.php">
  <button type="submit" style="display: none;"></button>
</form>
<script>document.getElementById('redirecionar').submit();</script>
