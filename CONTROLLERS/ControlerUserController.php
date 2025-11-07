<?php
// ControlerUserController.php (SEM data_cadastro)
class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // === RESUMO PEDIDOS ===
    public function getResumoPedidos() {
        $total = $this->pdo->query("SELECT COUNT(*) FROM pedido")->fetchColumn();
        $vendas = $this->pdo->query("SELECT COALESCE(SUM(total), 0) FROM pedido")->fetchColumn();
        $pendentes = $this->pdo->query("SELECT COUNT(*) FROM pedido WHERE COALESCE(status, 'Pendente') = 'Pendente'")->fetchColumn();
        $enviados = $this->pdo->query("SELECT COUNT(*) FROM pedido WHERE COALESCE(status, 'Pendente') = 'Enviado'")->fetchColumn();
        return compact('total', 'vendas', 'pendentes', 'enviados');
    }

    // === PEDIDOS RECENTES ===
    public function getPedidos() {
        $sql = "SELECT p.id_pedido, p.data_pedido, p.total, COALESCE(p.status, 'Pendente') as status, u.nome, u.email
                FROM pedido p
                JOIN usuario u ON p.id_usuario = u.id_usuario
                ORDER BY p.data_pedido DESC LIMIT 10";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // === ATUALIZAR STATUS ===
    public function atualizarStatus($id, $status) {
        $sql = "UPDATE pedido SET status = :status WHERE id_pedido = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // === RESUMO USUÁRIOS ===
    public function getResumoUsuarios() {
    // Total de usuários normais
    $sql = "SELECT COUNT(*) FROM usuario WHERE email NOT IN (SELECT email FROM administrador)";
    $total = $this->pdo->query($sql)->fetchColumn();

    // Premium
    $sql = "SELECT COUNT(*) FROM usuario WHERE membro = 1 AND email NOT IN (SELECT email FROM administrador)";
    $premium = $this->pdo->query($sql)->fetchColumn();

    // Admins
    $sql = "SELECT COUNT(*) FROM administrador";
    $admins = $this->pdo->query($sql)->fetchColumn();

    return [
        'total' => $total + $admins,
        'premium' => $premium,
        'admins' => $admins
    ];
}
public function getUsuarios() {
    // === 1. TODOS OS ADMINS (sempre aparecem) ===
    $sql_admins = "SELECT 
                       0 as id_usuario,
                       a.nome,
                       a.email,
                       0 as membro,
                       '' as telefone,
                       '' as cpf,
                       1 as is_admin
                   FROM administrador a
                   ORDER BY a.nome";
    $stmt = $this->pdo->prepare($sql_admins);
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // === 2. USUÁRIOS NORMAIS (excluindo admins) ===
    $sql = "SELECT u.id_usuario, u.nome, u.email, u.membro, u.telefone, u.cpf,
                   0 as is_admin
            FROM usuario u
            WHERE u.email NOT IN (SELECT email FROM administrador)
            ORDER BY u.id_usuario DESC
            LIMIT 10";  // MÁXIMO 10 USUÁRIOS
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // === 3. JUNTA: USUÁRIOS PRIMEIRO + TODOS OS ADMINS NO FINAL ===
    $todos = array_merge($usuarios, $admins);

    // === 4. Garante booleanos ===
    foreach ($todos as &$u) {
        $u['is_admin'] = (bool)$u['is_admin'];
        $u['membro'] = (bool)$u['membro'];
    }

    return $todos;
}

public function getHistoricoUsuario($id_usuario) {
    if ($id_usuario <= 0) {
        return []; // Admins não têm histórico
    }

    $sql = "SELECT p.id_pedido, p.data_pedido, p.total, p.status
            FROM pedido p
            WHERE p.id_usuario = :id
            ORDER BY p.data_pedido DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getUsuarioPorId($id) {
    if (strpos($id, 'admin_') === 0) {
        $email = str_replace('admin_', '', $id);
        $sql = "SELECT 0 as id_usuario, nome, email, 0 as membro, '' as telefone, '' as cpf, 1 as is_admin
                FROM administrador WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $sql = "SELECT u.*, a.id_adm IS NOT NULL as is_admin
            FROM usuario u
            LEFT JOIN administrador a ON u.email = a.email
            WHERE u.id_usuario = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($u) $u['is_admin'] = (bool)$u['is_admin'];
    return $u;
}
}
?>