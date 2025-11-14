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
                header('Location: /zypher/views/HomeFuncionario.php');
                exit();
            } else {
                echo "<script>alert('Senha incorreta!'); window.location.href='/zypher/views/loginFuncionario.php';</script>";
            }
        } else {
            echo "<script>alert('Funcionário não encontrado!'); window.location.href='/zypher/views/login.php';</script>";
        }
    }

}

    

     