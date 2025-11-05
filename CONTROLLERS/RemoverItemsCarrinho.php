<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../controllers/CarrinhoController.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$idProduto = $_POST['id_produto'] ?? null;
$tamanho = $_POST['tamanho'] ?? null;

if (!$idProduto || !$tamanho) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

try {
    CarrinhoController::removerItem($idUsuario, $idProduto, $tamanho);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
