<?php
session_start();
require_once __DIR__ . '/CarrinhoController.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$idProduto  = isset($_POST['id_produto']) ? $_POST['id_produto'] : null;
$tamanho    = isset($_POST['tamanho']) ? $_POST['tamanho'] : null;
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : null;

if (!$idProduto || !$tamanho || $quantidade === null) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Parâmetros inválidos']);
    exit;
}

$ok = CarrinhoController::atualizarQuantidade($idUsuario, $idProduto, $tamanho, $quantidade);

if ($ok) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar quantidade']);
}
