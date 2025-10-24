<?php
require_once '../models/administrador.php';


class FaleConoscoController {

    public function showForm() {
        // Exibe o formulário de contato
        require_once '../views/fale_conosco.php';
    }

    public function saveAdministrador() {
    // Cria uma nova mensagem
    $mensagem = new Mensagem();
    $mensagem->nome = $_POST['nome'];
    $mensagem->email = $_POST['e-mail']; 
    $mensagem->assunto = $_POST['assunto'];
    $mensagem->mensagem = $_POST['mensagem'];

    // Salva no banco de dados
    if ($mensagem->save()) {
        header('Location: /zypher/controleuser.php'); //arrumar o redirecionamento
    } else {
        echo "Erro ao enviar mensagem!";
    }
}


}

