<?php
session_start();

class FaleConoscoController {

    public function showForm() {
        require_once '../views/fale_conosco.php';
    }

    public function saveMensagem() {
        // Validação
        if (!isset($_POST['nome'], $_POST['email'], $_POST['assunto'], $_POST['mensagem'])) {
            header("Location: ../views/MensagemEnviada.php?status=erro");
            exit;
        }

        $nome    = trim($_POST['nome']);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $assunto = trim($_POST['assunto']);
        $mensagem= trim($_POST['mensagem']);
        $id_usuario = $_SESSION['usuario_id'] ?? null;

        if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
            header("Location: ../views/MensagemEnviada.php?status=erro");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../views/MensagemEnviada.php?status=erro");
            exit;
        }

        // Conexão direta (igual antes)
                try {
            $pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8mb4", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // INSERT SEM A COLUNA data_envio (essa coluna provavelmente não existe na sua tabela)
            $sql = "INSERT INTO fale_conosco 
                    (id_usuario, nome, email, assunto, mensagem, status) 
                    VALUES (?, ?, ?, ?, ?, 'pendente')";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario, $nome, $email, $assunto, $mensagem]);

            header("Location: ../views/MensagemEnviada.php?status=sucesso");
            exit;

        } catch (Exception $e) {
            header("Location: ../views/MensagemEnviada.php?status=erro&msg=banco");
            exit;
        }
    }
}

// Roteamento
$controller = new FaleConoscoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->saveMensagem();
} else {
    $controller->showForm();
}