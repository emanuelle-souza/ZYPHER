<?php
require_once '../config/database.php';
require_once '../controllers/CarrinhoController.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
    exit;
}

if (!isset($_POST['id_produto'], $_POST['tamanho'])) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$idProduto = $_POST['id_produto'];
$tamanho = $_POST['tamanho'];

try {
    CarrinhoController::removerItem($idUsuario, $idProduto, $tamanho);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
