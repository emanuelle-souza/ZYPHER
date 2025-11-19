<?php
require_once '../config/database.php';

class Funcionario {
    private $conn;
    private $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $database = new Database();
        $this->conn = $database->getConnection();
        // manter compatibilidade com código que usa $this->pdo
        $this->pdo = $this->conn;
    }

   
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM funcionario WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $senha) {
       $funcionario = $this->buscarPorEmail($email);
        if ($funcionario && $senha ===$funcionario['senha']) {
            return$funcionario;
        }
        return false;
    }

    public function getById($id) {
        // Retorna todos os campos do funcionário para permitir obter caminho da foto (se existir)
        $sql = "SELECT * FROM funcionario WHERE id_funcionario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizarFotoFun($id_funcionario, $caminho)
    {
        try {
            // colunas candidatas onde o caminho da foto pode estar armazenado
            $possibleCols = ['foto_perfil', 'foto', 'foto_funcionario', 'imagem'];
            foreach ($possibleCols as $col) {
                $check = $this->conn->prepare("SHOW COLUMNS FROM funcionario LIKE ?");
                $check->execute([$col]);
                if ($check->fetch()) {
                    $sql = "UPDATE funcionario SET {$col} = ? WHERE id_funcionario = ?";
                    $stmt = $this->conn->prepare($sql);
                    return (bool)$stmt->execute([$caminho, $id_funcionario]);
                }
            }

            // Nenhuma coluna compatível encontrada
            error_log('atualizarFotoFun: nenhuma coluna de foto encontrada na tabela funcionario');
            return false;
        } catch (PDOException $e) {
            error_log('Erro atualizarFotoFun: ' . $e->getMessage());
            return false;
        }
    }
}


    class Mensagem {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lista todas as conversas agrupadas por usuário
    public function listarConversas() {
        $query = "SELECT 
                    m.id_usuario,
                    u.nome as usuario_nome,
                    u.email as usuario_email,
                    MAX(m.data_envio) as ultima_mensagem,
                    COUNT(CASE WHEN m.lida = 0 AND m.remetente = 'usuario' THEN 1 END) as nao_lidas,
                    (SELECT mensagem FROM mensagens WHERE id_usuario = m.id_usuario ORDER BY data_envio DESC LIMIT 1) as ultima_msg
                  FROM mensagens m
                  INNER JOIN usuarios u ON m.id_usuario = u.id_usuario
                  GROUP BY m.id_usuario, u.nome, u.email
                  ORDER BY ultima_mensagem DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca todas as mensagens de um usuário específico
    public function buscarPorUsuario($usuarioId) {
        $query = "SELECT 
                    m.*,
                    u.nome as usuario_nome,
                    f.nome as funcionario_nome
                  FROM mensagens m
                  LEFT JOIN usuarios u ON m.id_usuario = u.id_usuario
                  LEFT JOIN funcionarios f ON m.id_funcionario = f.id_funcionario
                  WHERE m.id_usuario = :usuario_id
                  ORDER BY m.data_envio ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Envia resposta do funcionário
    public function enviarResposta($usuarioId, $funcionarioId, $mensagem) {
        $query = "INSERT INTO mensagens (id_usuario, id_funcionario, mensagem, remetente, data_envio, lida)
                  VALUES (:usuario_id, :funcionario_id, :mensagem, 'funcionario', NOW(), 0)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':funcionario_id', $funcionarioId);
        $stmt->bindParam(':mensagem', $mensagem);
        
        return $stmt->execute();
    }

    // Marca mensagem como lida
    public function marcarComoLida($mensagemId) {
        $query = "UPDATE mensagens SET lida = 1 WHERE id_mensagem = :mensagem_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mensagem_id', $mensagemId);
        
        return $stmt->execute();
    }

    // Marca todas as mensagens de um usuário como lidas
    public function marcarTodasComoLidas($usuarioId) {
        $query = "UPDATE mensagens SET lida = 1 
                  WHERE id_usuario = :usuario_id AND remetente = 'usuario' AND lida = 0";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId);
        
        return $stmt->execute();
    }

    // Busca novas mensagens para atualização em tempo real
    public function buscarNovasMensagens($ultimoId, $usuarioId = null) {
        if ($usuarioId) {
            $query = "SELECT m.*, u.nome as usuario_nome, f.nome as funcionario_nome
                      FROM mensagens m
                      LEFT JOIN usuarios u ON m.id_usuario = u.id_usuario
                      LEFT JOIN funcionarios f ON m.id_funcionario = f.id_funcionario
                      WHERE m.id_mensagem > :ultimo_id AND m.id_usuario = :usuario_id
                      ORDER BY m.data_envio ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ultimo_id', $ultimoId);
            $stmt->bindParam(':usuario_id', $usuarioId);
        } else {
            $query = "SELECT m.*, u.nome as usuario_nome
                      FROM mensagens m
                      INNER JOIN usuarios u ON m.id_usuario = u.id_usuario
                      WHERE m.id_mensagem > :ultimo_id AND m.remetente = 'usuario'
                      ORDER BY m.data_envio ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ultimo_id', $ultimoId);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Conta mensagens não lidas
    public function contarNaoLidas() {
        $query = "SELECT COUNT(*) as total FROM mensagens 
                  WHERE lida = 0 AND remetente = 'usuario'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    // Salva mensagem do usuário (vinda do "Fale Conosco")
    public function salvarMensagemUsuario($usuarioId, $mensagem, $assunto = null) {
        $query = "INSERT INTO mensagens (id_usuario, mensagem, assunto, remetente, data_envio, lida)
                  VALUES (:usuario_id, :mensagem, :assunto, 'usuario', NOW(), 0)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':assunto', $assunto);
        
        return $stmt->execute();
    }

}
?>