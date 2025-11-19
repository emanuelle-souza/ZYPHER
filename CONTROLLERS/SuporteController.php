<?php
session_start();

// Verifica se o funcionário está logado
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: /zypher/views/LoginFuncionario.php");
    exit;
}

class SuporteController {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=ZYPHER_SNEAKERS;charset=utf8mb4", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão com o banco: " . $e->getMessage());
        }
    }


public function listar() {
    try {
        $sql = "
            SELECT 
                fc.id_fale_conosco,
                fc.nome,
                fc.email,
                fc.assunto,
                fc.mensagem,
                fc.status,
                fc.resposta,
                fc.data_resposta,
                fc.id_funcionario,
                u.nome AS nome_usuario,
                f.nome AS nome_funcionario
            FROM fale_conosco fc
            LEFT JOIN usuario u ON fc.id_usuario = u.id_usuario
            LEFT JOIN funcionario f ON fc.id_funcionario = f.id_funcionario
            ORDER BY fc.id_fale_conosco DESC
        ";

        $stmt = $this->pdo->query($sql);
        $mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // DEBUG TEMPORÁRIO — APAGUE DEPOIS
        if (empty($mensagens)) {
            echo "<div style='background:#ffeeee;padding:15px;margin:20px;border-left:5px solid red;'>
                    <strong>Nenhuma mensagem no banco ainda ou coluna 'status' com valor NULL.</strong><br>
                    Total encontrado: " . count($mensagens) . "
                  </div>";
        }

        require_once __DIR__ . '/../views/SuporteUsuario.php';

    } catch (Exception $e) {
        die("Erro no painel de suporte: " . $e->getMessage());
    }

// Roteamento
$controller = new SuporteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->responder();
} else {
    $controller->listar();
}
}}
