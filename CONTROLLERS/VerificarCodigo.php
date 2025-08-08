<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');

    if (!$email || !$codigo) {
        die("Email ou código não fornecido.");
    }

    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare("SELECT * FROM codigos_recuperacao WHERE email = ? AND codigo = ? AND expira_em > NOW()");
    $stmt->execute([$email, $codigo]);
    $valido = $stmt->fetch();

    if ($valido) {
        $_SESSION['email'] = $email;
        header("Location: ../views/redefinir_senha.php");
        exit;
    } else {
        echo "Código inválido ou expirado.";
    }
}
