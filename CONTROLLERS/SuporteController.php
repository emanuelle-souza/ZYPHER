<?php
// /zypher/controllers/SuporteController.php

session_start();

// Verifica login do funcionário
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: /zypher/views/login_funcionario.php");
    exit;
}

class SuporteController {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function listar() {
        $stmt = $this->pdo->prepare("
            SELECT 
                fc.*,
                u.nome AS nome_usuario,
                f.nome AS nome_funcionario
            FROM fale_conosco fc
            LEFT JOIN usuario u ON fc.id_usuario = u.id_usuario
            LEFT JOIN funcionario f ON fc.id_funcionario = f.id_funcionario
            ORDER BY fc.id_fale_conosco DESC
        ");
        $stmt->execute();
        $mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC); // AQUI ESTÁ A VARIÁVEL!

        // PASSA A VARIÁVEL PARA A VIEW
        require_once '../views/suporte.php';
    }

    public function responder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_fale_conosco'], $_POST['resposta'])) {
            header("Location: SuporteController.php?status=erro");
            exit;
        }

        $id = (int)$_POST['id_fale_conosco'];
        $resposta = trim($_POST['resposta']);
        $id_funcionario = $_SESSION['funcionario_id'];

        if (empty($resposta)) {
            header("Location: SuporteController.php?status=erro&msg=vazio");
            exit;
        }

        $stmt = $this->pdo->prepare("
            UPDATE fale_conosco 
            SET resposta = ?, id_funcionario = ?, status = 'respondida', data_resposta = NOW()
            WHERE id_fale_conosco = ?
        ");

        $sucesso = $stmt->execute([$resposta, $id_funcionario, $id]);

        // Enviar e-mail (opcional)
        if ($sucesso) {
            $this->enviarEmail($id, $resposta);
        }

        header("Location: SuporteController.php?status=" . ($sucesso ? 'sucesso' : 'erro'));
        exit;
    }

    private function enviarEmail($id, $resposta) {
        $stmt = $this->pdo->prepare("SELECT nome, email, assunto FROM fale_conosco WHERE id_fale_conosco = ?");
        $stmt->execute([$id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados) {
            $to = $dados['email'];
            $subject = "Re: " . $dados['assunto'];
            $message = "Olá {$dados['nome']},\n\nSua mensagem foi respondida:\n\n$resposta\n\nAtenciosamente,\nEquipe Zypher Sneakers";
            $headers = "From: contato@zyphersneakers.com";

            mail($to, $subject, $message, $headers);
        }
    }
}

// ROTEAMENTO
$controller = new SuporteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->responder();
} else {
    $controller->listar(); // CHAMA O MÉTODO QUE DEFINE $mensagens
}