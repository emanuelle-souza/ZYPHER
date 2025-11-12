<?php
session_start();
require_once '../models/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /zypher/views/login.php");
    exit;
}

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $uploadDir = __DIR__ . '/../uploads/fotos/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $fileName = 'usuario_' . $_SESSION['usuario_id'] . '.' . $ext;
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $filePath)) {
        $dbPath = '/zypher/uploads/fotos/' . $fileName;

        $usuarioModel = new Usuario();
        $usuarioModel->atualizarFoto($_SESSION['usuario_id'], $dbPath);
    }
}

header("Location: PerfilUsuario.php");
exit;
?>
