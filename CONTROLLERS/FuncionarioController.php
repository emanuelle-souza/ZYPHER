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

    public function updateFuncionario() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $funcionario = new Funcionario();
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

    if ($funcionarioExistente) {
            // Verifica senha — troque para password_verify se estiver usando hash
            if (password_verify($senha, $funcionarioExistente['senha'])) {

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

    

     