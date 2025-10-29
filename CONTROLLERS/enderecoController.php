<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $endereco = [
        'nome' => isset($_POST['nome']) ? trim($_POST['nome']) : '',
        'telefone' => isset($_POST['telefone']) ? trim($_POST['telefone']) : '',
        'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
        'cep' => isset($_POST['cep']) ? trim($_POST['cep']) : '',
        'endereco_entrega' => isset($_POST['endereco_entrega']) ? trim($_POST['endereco_entrega']) : '',
        'numero' => isset($_POST['numero']) ? trim($_POST['numero']) : '',
        'cidade' => isset($_POST['cidade']) ? trim($_POST['cidade']) : '',
        'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : ''
    ];

    // Aqui você poderia validar mais antes de salvar.
    $_SESSION['endereco_entrega'] = $endereco;

    // Redireciona para pagamento
    header("Location: /zypher/views/Pagamento.php");
    exit;
} else {
    // caso acesso direto
    header("Location: /zypher/views/enderecoform.php");
    exit;
}
