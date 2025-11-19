<?php
session_start();
require_once '../models/Funcionario.php';

if (!isset($_SESSION['funcionario_id'])) {
    header("Location: /zypher/views/loginFuncionario.php");
    exit;
}

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $uploadDir = __DIR__ . '/../uploads/fotos/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $fileName = 'funcionario_' . $_SESSION['funcionario_id'] . '.' . $ext;
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $filePath)) {
        $dbPath = '/zypher/uploads/fotos/' . $fileName;

        $funcionarioModel = new Funcionario();
        $ok = $funcionarioModel->atualizarFotoFun($_SESSION['funcionario_id'], $dbPath);
        if ($ok) {
            // Armazena na sessão para exibição imediata
            $_SESSION['foto_funcionario'] = $dbPath;
            $_SESSION['msg_foto'] = 'Foto atualizada com sucesso!';
        } else {
            $_SESSION['msg_foto'] = 'Foto enviada, mas não foi possível salvar no banco.';
        }
    }
}

header("Location: Perfilfuncionario.php");
exit;
?>
