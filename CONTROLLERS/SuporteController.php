<?php
session_start();
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: /zypher/views/LoginFuncionario.php");
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8mb4", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT fc.*, u.nome AS nome_usuario, f.nome AS nome_funcionario 
        FROM fale_conosco fc
        LEFT JOIN usuario u ON fc.id_usuario = u.id_usuario
        LEFT JOIN funcionario f ON fc.id_funcionario = f.id_funcionario
        ORDER BY fc.id_fale_conosco DESC";

$mensagens = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id_fale_conosco'];
    $resposta = trim($_POST['resposta']);
    $id_func = $_SESSION['funcionario_id'];
    $pdo->prepare("UPDATE fale_conosco SET resposta=?, id_funcionario=?, status='respondida', data_resposta=NOW() WHERE id_fale_conosco=?")
        ->execute([$resposta, $id_func, $id]);
    header("Location: SuporteController.php");
    exit;
}

include '../views/SuporteUsuario.php';