<?php
require_once __DIR__ . '/../config/database.php';
require_once '../models/funcionario.php';

class FuncionarioController {
    
    public function loginFuncionario() {
        session_start();

        if (!isset($_POST['email']) || !isset($_POST['senha'])) {
            header('Location: /zypher/views/LoginFuncionario.php');
            exit;
        }

        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        $funcionario = new Funcionario();
        $funcionarioExistente = $funcionario->buscarPorEmail($email);

        if ($funcionarioExistente) {
            // Se sua senha estiver em hash, use password_verify()
            // Se estiver salva como texto puro (como está agora), use == mesmo
            if ($senha === $funcionarioExistente['senha']) {  // ou password_verify($senha, $hash)

                // LOGIN COM SUCESSO
                $_SESSION['funcionario_id']     = $funcionarioExistente['id_funcionario'];
                $_SESSION['funcionario_nome']   = $funcionarioExistente['nome'];
                $_SESSION['funcionario_email']  = $funcionarioExistente['email'];

                // VAI DIRETO PRO SUPORTE (controller, não view!)
                header('Location: /zypher/controllers/SuporteController.php');
                exit;
            } else {
                $_SESSION['erro_login'] = "Senha incorreta!";
                header('Location: /zypher/views/LoginFuncionario.php');
                exit;
            }
        } else {
            $_SESSION['erro_login'] = "Funcionário não encontrado!";
            header('Location: /zypher/views/LoginFuncionario.php');
            exit;
        }
    }
}