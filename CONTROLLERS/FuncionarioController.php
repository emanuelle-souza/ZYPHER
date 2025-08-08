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
        header('Location: /zypher/HomeFuncionario');
    } else {
        echo "Erro ao entrar!";
    }
}
 public function showUpdateForm($id_funcionario){
        $funcionario = new Funcionario();
        $funcionarioinfo = $funcionario->getByid($id_funcionario);
        include '../views/update_funcionario.php';
    }

    public function updateUsuario() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $funcionario = new Usuario();
            $funcionario->nome = $_POST['nome'];
            $funcionario->email = $_POST['email']; 
            $funcionario->senha = $_POST['senha'];
            $funcionario->id_funcionario = $_POST['id_funcionario'];

            if ($usuario->update()) {
                header('Location: /zypher/funcionariopage');
            } else {
                echo "Erro ao atualizar o cadastro.";
            }
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

       

        header('Location: /zypher/views/HomeFuncionario.php');
        exit();
    } else {
        echo "Email ou senha incorretos!";
    }
}

}
