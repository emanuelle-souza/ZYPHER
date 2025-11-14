<?php

require_once '../models/FaleConosco.php';
// INICIA A SESSÃO (OBRIGATÓRIO!)
session_start();


require_once '../models/administrador.php';

class FaleConoscoController {

    public function showForm() {
        require_once '../views/fale_conosco.php';
    }

    public function saveMensagem() {

    // Cria uma nova mensagem
    $mensagem = new Mensagem();
    $mensagem->nome = $_POST['nome'];
    $mensagem->email = $_POST['e-mail']; 
    $mensagem->assunto = $_POST['assunto'];
    $mensagem->mensagem = $_POST['mensagem'];

        // Validação
        if (!isset($_POST['nome'], $_POST['email'], $_POST['assunto'], $_POST['mensagem'])) {
            header("Location: /zypher/VIEWS/MensagemEnviada.php?status=erro");
            exit;
        }

        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $assunto = trim($_POST['assunto']);
        $mensagem = trim($_POST['mensagem']);
        $id_usuario = $_SESSION['usuario_id'] ?? null; // AGORA VAI PEGAR!

        if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
            header("Location: /zypher/VIEWS/MensagemEnviada.php?status=erro&msg=campos");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: /zypher/VIEWS/MensagemEnviada.php?status=erro&msg=email");
            exit;
        }

        // Conexão
        $pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inserir
        $stmt = $pdo->prepare("
            INSERT INTO fale_conosco (id_usuario, nome, email, assunto, mensagem)
            VALUES (?, ?, ?, ?, ?)
        ");

        $success = $stmt->execute([$id_usuario, $nome, $email, $assunto, $mensagem]);

        if ($success) {
            header("Location: /zypher/VIEWS/MensagemEnviada.php?status=sucesso");
        } else {
            header("Location: /zypher/VIEWS/MensagemEnviada.php?status=erro&msg=banco");
        }
        exit;
    }
}

// Roteamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'saveMensagem') {
    $controller = new FaleConoscoController();
    $controller->saveMensagem();
}