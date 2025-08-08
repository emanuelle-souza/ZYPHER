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
            $usuario->senha = $_POST('senha');

            if ($usuario->saveusuario()){
                header('Location: /cypher/HomeCliente');
            } else {
                echo "Erro ao cadastrar.";
            }
        }
    }

     public function listUsuario() {
        $usuario = new Usuario();
        $usuario = $usuario->getAll();
        include '../views/controleuser_list.php';
    } 

    public function showUpdateForm($id_usuario){
        $usuario = new Usuario();
        $usuarioinfo = $usuario->getByid($id_usuario);
        include '../views/update_usuario.php';
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
                header('Location: /cypher/usuariopage');
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
                header('Location: /cypher/cadastro');
            } else {
                echo "Erro ao excluir o cadastro.";
            }
        }
    }

    public function loginUsuario() {
    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = new Usuario();
    $usuarioExistente = $usuario->buscarPorEmail($email);

    if ($usuarioExistente && $senha == $usuarioExistente['senha']) {
        $_SESSION['usuario_id'] = $usuarioExistente['id'];
        $_SESSION['email'] = $usuarioExistente['email'];

       

        header('Location: /cypher/views/HomeCliente');
        exit();
    } else {
        echo "Email ou senha incorretos!";
    }
}



}