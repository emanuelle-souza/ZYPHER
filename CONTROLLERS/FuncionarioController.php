<?php
require_once '../models/funcionario.php';


class FuncionarioController {

    public function showForm() {
        // Exibe o formulário de cadastro de usuarios
        require_once '../views/login_funcionario.php';
    }

    public function saveFuncionario() {
    // Cria um novo usuario
    $funcionario = new Funcionario();
    $funcionario->email = $_POST['email'];
    $funcionario->senha = $_POST['senha']; 
    $funcionario->nome = $_POST['nome'];

    // Salva no banco de dados
    if ($funcionario->save()) {
        header('Location: /cypher/HomeFuncionario');
    } else {
        echo "Erro ao entrar!";
    }
}

    public function loginFuncionario() {
    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $funcionario = new Funcionario();
    $funcionarioExistente = $funcionario->buscarPorEmail($email);

    if ($funcionarioExistente && password_verify($senha, $funcionarioExistente['senha'])) { 
        $_SESSION['funcionario_id'] = $funcionarioExistente['id'];
        $_SESSION['email'] = $funcionarioExistente['email'];

       

        header('Location: /cypher/views/HomeFuncionario.php');
        exit();
    } else {
        echo "Email ou senha incorretos!";
    }
}

}
