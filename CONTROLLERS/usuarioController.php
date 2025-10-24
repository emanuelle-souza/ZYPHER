<?php

require_once '../models/Usuario.php';

class usuarioController {
    public function Formulario(){
        include '../views/usuarioform.php';
    }

    public function saveusuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario =  new Usuario();
            $usuario->nome = $_POST['nome'];
            $usuario->email = $_POST['email']; 
            $usuario->telefone = $_POST['telefone'];
            $usuario->cpf = $_POST['cpf'];
            $usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);


            if ($usuario->saveusuario()){
                header('Location: /zypher/views/HomeCliente.php');
            } else {
                echo "Erro ao cadastrar.";
            }
        }
    }

     public function listUsuario() {
        $usuario = new Usuario();
        $usuario = $usuario->getAll();
        include '../views/Controleuserlist.php';
    } 

    public function showUpdateForm($id_usuario){
        $usuario = new Usuario();
        $usuarioinfo = $usuario->getByid($id_usuario);
        include '../views/UpdateUsuario.php';
    }

    public function updateUsuario() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();
            $usuario->nome = $_POST['nome'];
            $usuario->email = $_POST['email']; 
            $usuario->telefone = $_POST['telefone'];
            $usuario->cpf = $_POST['cpf'];
            $usuario->senha = $_POST['senha'];
            $usuario->id_usuario = $_POST['id_usuario'];

            if ($usuario->update()) {
                header('Location: /zypher/views/PerfilUsuario.php');
            } else {
                echo "Erro ao atualizar o cadastro.";
            }
        }
    }
    
    public function deleteUsuarioByCpf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();
            $usuario->cpf = $_POST['cpf'];

            if ($usuario->deleteByCpf()) {
                header('Location: /zypher/cadastro');
            } else {
                echo "Erro ao excluir o cadastro.";
            }
        }
    }

    public function loginUsuario() {
        if (!isset($_SESSION)) {
            session_start();
        }
    
        // Captura dados do formulário
        $email = $_POST['email'];
        $senha = $_POST['senha'];
    
        $usuario = new Usuario();
        $usuarioExistente = $usuario->buscarPorEmail($email);
    
        if ($usuarioExistente) {
            // Verifica senha — troque para password_verify se estiver usando hash
            if (password_verify($senha, $usuarioExistente['senha'])) {
    
   
                $_SESSION['usuario_id'] = $usuarioExistente['id_usuario'];
                $_SESSION['usuario_nome'] = $usuarioExistente['nome'];
                $_SESSION['usuario_email'] = $usuarioExistente['email'];
    
                // Redireciona para a home
                header('Location: /zypher/views/HomeCliente.php');
                exit();
            } else {
                echo "<script>alert('Senha incorreta!'); window.location.href='/zypher/views/login.php';</script>";
            }
        } else {
            echo "<script>alert('Usuário não encontrado!'); window.location.href='/zypher/views/login.php';</script>";
        }
    }
    


}