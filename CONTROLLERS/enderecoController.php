<?php

require_once '../models/Endereco.php';

class enderecoController {
    public function Formularioend(){
        include '../views/enderecoform.php';
    }

    public function salvaendereco() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $endereco =  new Endereco();
            $endereco->nome = $_POST['nome'];
            $endereco->telefone = $_POST['telefone'];
            $endereco->email = $_POST['email']; 
            $endereco->cep = $_POST['cep'];
            $endereco->endereco_entrega = $_POST['endereco_entrega'];
            $endereco->numero = $_POST['numero'];
            $endereco->cidade = $_POST['cidade'];
            $endereco->estado = $_POST['estado'];

            if ($endereco->salvaend()){
                header('Location: /cypher/checkout.php');
            } else {
                echo "Erro ao cadastrar endereço.";
            }
        }
    }
    public function showUpdateFormEnd($id_usuario){
        $endereco = new Endereco();
        $enderecoinfo = $endereco->getByid($id_usuario);
        include '../views/update_endereco.php';
    }

    public function updateendereco() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $endereco =  new Endereco();
            $endereco->nome = $_POST['nome'];
            $endereco->telefone = $_POST['telefone'];
            $endereco->email = $_POST['email']; 
            $endereco->cep = $_POST['cep'];
            $endereco->endereco_entrega = $_POST('endereco_entrega');
            $endereco->numero = $_POST['numero'];
            $endereco->cidade = $_POST['cidade'];
            $endereco->estado = $_POST['estado'];

            if ($endereco->update()) {
                header('Location: /cypher/checkout.php');
            } else {
                echo "Erro ao atualizar o endereço.";
            }
        }
    }
}