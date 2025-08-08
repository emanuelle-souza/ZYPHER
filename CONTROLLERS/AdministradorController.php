<?php
require_once '../models/administrador.php';


class AdministradorController {

    public function showForm() {
        // Exibe o formulário de cadastro de usuarios
        require_once '../views/login_administrador.php';
    }

    public function saveAdministrador() {
    // Cria um novo usuario
    $administrador = new Administrador();
    $administrador->email = $_POST['email'];
    $administrador->senha = $_POST['senha']; 
    $administrador->nome = $_POST['nome'];

    // Salva no banco de dados
    if ($administrador->save()) {
        header('Location: /zypher/controleuser.php');
    } else {
        echo "Erro ao entrar!";
    }
}

public function showUpdateForm($id_administrador){
        $administrador = new Funcionario();
        $administradorinfo = $administrador->getByid($id_administrador);
        include '../views/update_administrador.php';
    }

    public function updateAdministrador() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $administrador = new Administrador();
            $administrador->nome = $_POST['nome'];
            $administrador->email = $_POST['email']; 
            $administrador->senha = $_POST['senha'];
            $administrador->id_adm = $_POST['id_adm'];

            if ($administrador->update()) {
                header('Location: /zypher/administradorpage');
            } else {
                echo "Erro ao atualizar o cadastro.";
            }
        }
    }

    public function loginAdministrador() {
    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $administrador = new Administrador();
    $administradorExistente = $administrador->buscarPorEmail($email);

    if ($administradorExistente && password_verify($senha, $administradorExistente['senha'])) { 
        $_SESSION['administrador_id'] = $administradorExistente['id'];
        $_SESSION['email'] = $administradorExistente['email'];

       

        header('Location: /zypher/views/controleuser.php');
        exit();
    } else {
        echo "Email ou senha incorretos!";
    }
}

}
