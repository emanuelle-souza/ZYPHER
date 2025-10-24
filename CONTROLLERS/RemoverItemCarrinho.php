<?php
session_start();
require_once 'CarrinhoController.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../views/LoginCliente.php");
    exit;
}

$idUsuario = $_SESSION['id_usuario'];
$idProduto = $_POST['id_produto'];
$tamanho = $_POST['tamanho'];

CarrinhoController::removerItem($idUsuario, $idProduto, $tamanho);

header("Location: ../views/CarrinhoCliente.php");
exit;
?>
