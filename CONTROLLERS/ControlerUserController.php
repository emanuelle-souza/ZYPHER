<?php
// DashboardController.php
session_start();
require_once '../config/Database.php'; // Ajuste o caminho conforme seu projeto

class DashboardController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Pega todos os usuários (últimos 10)
    public function getUsuariosRecentes() {
        $sql = "SELECT id, nome, email, telefone, cpf, membro FROM usuarios ORDER BY id DESC LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pega o histórico de compras do usuário pelo id
    public function getHistoricoCompras($usuario_id) {
        $sql = "SELECT p.id, p.data_pedido, p.valor_total, p.status
                FROM pedido p
                WHERE p.usuario_id = :usuario_id
                ORDER BY p.data_pedido DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pega resumo rápido para painel (total usuários, membros premium, vendas, pedidos hoje)
    public function getResumo() {
        $sqlUsers = "SELECT COUNT(*) as total FROM usuarios";
        $totalUsers = $this->conn->query($sqlUsers)->fetch(PDO::FETCH_ASSOC)['total'];

        $sqlPremium = "SELECT COUNT(*) as total FROM usuarios WHERE membro = 1";
        $totalPremium = $this->conn->query($sqlPremium)->fetch(PDO::FETCH_ASSOC)['total'];

        $sqlVendas = "SELECT SUM(valor_total) as total_vendas FROM pedido";
        $totalVendas = $this->conn->query($sqlVendas)->fetch(PDO::FETCH_ASSOC)['total_vendas'] ?? 0;

        $sqlPedidosHoje = "SELECT COUNT(*) as total_pedidos_hoje FROM pedido WHERE DATE(data_pedido) = CURDATE()";
        $pedidosHoje = $this->conn->query($sqlPedidosHoje)->fetch(PDO::FETCH_ASSOC)['total_pedidos_hoje'];

        return [
            'totalUsuarios' => $totalUsers,
            'totalPremium' => $totalPremium,
            'totalVendas' => $totalVendas,
            'pedidosHoje' => $pedidosHoje,
        ];
    }
}
?>
