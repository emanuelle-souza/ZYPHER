<?php
require_once __DIR__ . '/../config/database.php';
require_once '../models/funcionario.php';


class FuncionarioController {
    
    public function loginFuncionario() {
        session_start();

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $funcionario = new Funcionario();
        $funcionarioExistente = $funcionario->buscarPorEmail($email);

        if ($funcionarioExistente) {
            // Verifica senha — troque para password_verify se estiver usando hash
            if ($senha == $funcionarioExistente['senha']) {

                $_SESSION['funcionario_id'] = $funcionarioExistente['id_funcionario'];
                $_SESSION['funcionario_nome'] = $funcionarioExistente['nome'];
                $_SESSION['funcionario_email'] = $funcionarioExistente['email'];

                // Redireciona para a home
                header('Location: /zypher/views/SuporteUsuario.php');
                exit();
            } else {
                echo "<script>alert('Senha incorreta!'); window.location.href='/zypher/views/loginFuncionario.php';</script>";
            }
        } else {
            echo "<script>alert('Funcionário não encontrado!'); window.location.href='/zypher/views/login.php';</script>";
        }
    }

    // Lista todas as conversas de suporte
    public function listarConversas() {
        session_start();
        
        if (!isset($_SESSION['funcionario_id'])) {
            header('Location: /zypher/views/loginFuncionario.php');
            exit();
        }

        $mensagem = new Mensagem();
        $conversas = $mensagem->listarConversas();
        
        return $conversas;
    }

    // Busca mensagens de uma conversa específica
    public function buscarMensagensConversa($usuarioId) {
        session_start();
        
        if (!isset($_SESSION['funcionario_id'])) {
            echo json_encode(['error' => 'Não autorizado']);
            exit();
        }

        $mensagem = new Mensagem();
        $mensagens = $mensagem->buscarPorUsuario($usuarioId);
        
        echo json_encode($mensagens);
    }

    // Envia resposta para o usuário
    public function enviarResposta() {
        session_start();
        
        if (!isset($_SESSION['funcionario_id'])) {
            echo json_encode(['error' => 'Não autorizado']);
            exit();
        }

        $usuarioId = $_POST['usuario_id'];
        $mensagemTexto = $_POST['mensagem'];
        $funcionarioId = $_SESSION['funcionario_id'];

        $mensagem = new Mensagem();
        $resultado = $mensagem->enviarResposta($usuarioId, $funcionarioId, $mensagemTexto);

        if ($resultado) {
            echo json_encode(['success' => true, 'mensagem' => 'Resposta enviada com sucesso']);
        } else {
            echo json_encode(['success' => false, 'mensagem' => 'Erro ao enviar resposta']);
        }
    }

    // Marca mensagem como lida
    public function marcarComoLida() {
        session_start();
        
        if (!isset($_SESSION['funcionario_id'])) {
            echo json_encode(['error' => 'Não autorizado']);
            exit();
        }

        $mensagemId = $_POST['mensagem_id'];

        $mensagem = new Mensagem();
        $resultado = $mensagem->marcarComoLida($mensagemId);

        echo json_encode(['success' => $resultado]);
    }

    // Busca novas mensagens (para atualização em tempo real)
    public function buscarNovasMensagens() {
        session_start();
        
        if (!isset($_SESSION['funcionario_id'])) {
            echo json_encode(['error' => 'Não autorizado']);
            exit();
        }

        $ultimoId = isset($_GET['ultimo_id']) ? $_GET['ultimo_id'] : 0;
        $usuarioId = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : null;

        $mensagem = new Mensagem();
        $novasMensagens = $mensagem->buscarNovasMensagens($ultimoId, $usuarioId);
        
        echo json_encode($novasMensagens);
    }

    // Conta mensagens não lidas
    public function contarMensagensNaoLidas() {
        session_start();
        
        if (!isset($_SESSION['funcionario_id'])) {
            echo json_encode(['count' => 0]);
            exit();
        }

        $mensagem = new Mensagem();
        $count = $mensagem->contarNaoLidas();
        
        echo json_encode(['count' => $count]);
    }
}
?>