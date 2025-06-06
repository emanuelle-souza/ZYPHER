<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];
    $novaSenha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

    $conn = (new Database())->getConnection();

    $stmt = $conn->prepare("SELECT * FROM recuperacao_senha WHERE email = ? AND codigo = ? AND expiracao > NOW()");
    $stmt->execute([$email, $codigo]);
    $valido = $stmt->fetch();

    if ($valido) {
        $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
        $stmt->execute([$novaSenha, $email]);

        $conn->prepare("DELETE FROM recuperacao_senha WHERE email = ?")->execute([$email]);

        echo "Senha redefinida com sucesso!";
    } else {
        echo "Código inválido ou expirado.";
    }
}
?>