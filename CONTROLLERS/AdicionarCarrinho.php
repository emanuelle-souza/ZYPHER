<?php
session_start();

require_once 'CarrinhoController.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /zypher/VIEWS/LoginCliente.php?msg=faça-login-para-adicionar");
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$idProduto = $_POST['id_produto'];
$tamanho = $_POST['tamanho'];

CarrinhoController::adicionarProduto($idUsuario, $idProduto, $tamanho, 1);

header("Location: /zypher/VIEWS/Carrinho.php");
exit;

?>
